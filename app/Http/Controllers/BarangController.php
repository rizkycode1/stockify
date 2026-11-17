<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $query = Barang::with(['kategori', 'supplier'])
            ->where('company_id', $companyId);

        if ($request->filled('search')) {
            $query->where(
                'nama_barang',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->status === 'aman') {
            $query->where('stok', '>', 5);
        } elseif ($request->status === 'rendah') {
            $query->where('stok', '>', 0)
                ->where('stok', '<=', 5);
        } elseif ($request->status === 'habis') {
            $query->where('stok', 0);
        }

        $barangs = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $totalBarang = Barang::where('company_id', $companyId)->count();

        $totalStok = Barang::where('company_id', $companyId)
            ->sum('stok');

        $stokRendah = Barang::where('company_id', $companyId)
            ->where('stok', '<=', 5)
            ->count();

        $kategoris = Kategori::where('company_id', $companyId)
            ->orderBy('nama_kategori')
            ->get();

        return view('barang.index', compact(
            'barangs',
            'totalBarang',
            'totalStok',
            'stokRendah',
            'kategoris'
        ));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;

        $kategoris = Kategori::where('company_id', $companyId)->get();

        $suppliers = Supplier::where('company_id', $companyId)->get();

        return view('barang.create', compact(
            'kategoris',
            'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',

            'kategori_id' => [
                'nullable',
                Rule::exists('kategoris', 'id')
                    ->where('company_id', $companyId),
            ],

            'supplier_id' => [
                'nullable',
                Rule::exists('suppliers', 'id')
                    ->where('company_id', $companyId),
            ],

            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')
                ->store('foto-barang', 'public');
        }

        $barang = new Barang($validated);
        $barang->company_id = $companyId;
        $barang->save();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $companyId = Auth::user()->company_id;

        $barang = Barang::where('company_id', $companyId)
            ->findOrFail($barang->id);

        $kategoris = Kategori::where('company_id', $companyId)->get();

        $suppliers = Supplier::where('company_id', $companyId)->get();

        return view('barang.edit', compact(
            'barang',
            'kategoris',
            'suppliers'
        ));
    }

    public function update(Request $request, Barang $barang)
    {
        $companyId = Auth::user()->company_id;

        $barang = Barang::where('company_id', $companyId)
            ->findOrFail($barang->id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',

            'kategori_id' => [
                'nullable',
                Rule::exists('kategoris', 'id')
                    ->where('company_id', $companyId),
            ],

            'supplier_id' => [
                'nullable',
                Rule::exists('suppliers', 'id')
                    ->where('company_id', $companyId),
            ],

            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }

            $validated['foto'] = $request->file('foto')
                ->store('foto-barang', 'public');
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $barang = Barang::where(
            'company_id',
            Auth::user()->company_id
        )->findOrFail($barang->id);

        if ($barang->barangMasuks()->exists()) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat barang masuk.');
        }

        if ($barang->barangKeluars()->exists()) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat barang keluar.');
        }

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
