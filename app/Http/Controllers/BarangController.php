<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'supplier']);

        // Pencarian nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter status stok
        if ($request->status === 'aman') {
            $query->where('stok', '>', 5);
        } elseif ($request->status === 'rendah') {
            $query->where('stok', '>', 0)->where('stok', '<=', 5);
        } elseif ($request->status === 'habis') {
            $query->where('stok', 0);
        }

        $barangs = $query->latest()->paginate(10)->withQueryString();

        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $stokRendah = Barang::where('stok', '<=', 5)->count();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

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
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('barang.create', compact('kategoris', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        $suppliers = Supplier::all();

        return view('barang.edit', compact(
            'barang',
            'kategoris',
            'suppliers'
        ));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->barangMasuks()->exists()) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena memiliki riwayat barang masuk.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}
