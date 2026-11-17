<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $barangKeluars = BarangKeluar::with('barang')
            ->where('company_id', $companyId)
            ->latest()
            ->paginate(10);

        return view('barang-keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;

        $barangs = Barang::where('company_id', $companyId)
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('barang-keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $validated = $request->validate([
            'barang_id' => [
                'required',
                Rule::exists('barangs', 'id')
                    ->where('company_id', $companyId),
            ],
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'tujuan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $companyId) {

            $barang = Barang::where('company_id', $companyId)
                ->where('id', $validated['barang_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['jumlah'] > $barang->stok) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Jumlah barang keluar melebihi stok yang tersedia. Stok saat ini: ' . $barang->stok,
                ]);
            }

            $barangKeluar = new BarangKeluar($validated);
            $barangKeluar->company_id = $companyId;
            $barangKeluar->save();

            $barang->decrement('stok', $validated['jumlah']);
        });

        return redirect()
            ->route('barang-keluar.index')
            ->with('success', 'Transaksi barang keluar berhasil disimpan.');
    }
}
