<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')
            ->latest()->get();

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();

        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($data) {
            $barang = Barang::where('id', $data['barang_id'])
                ->lockForUpdate()->firstOrFail();

            $barang->increment('stok', $data['jumlah']);

            BarangMasuk::create($data);
        });

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan!');
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs = Barang::all();

        return view('barang_masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($data, $barangMasuk) {
            $lama = Barang::where('id', $barangMasuk->barang_id)
                ->lockForUpdate()->firstOrFail();

            $baru = Barang::where('id', $data['barang_id'])
                ->lockForUpdate()->firstOrFail();

            if ($lama->id === $baru->id) {
                $lama->stok = $lama->stok - $barangMasuk->jumlah
                    + $data['jumlah'];
                $lama->save();
            } else {
                if ($lama->stok < $barangMasuk->jumlah) {
                    throw new \Exception('Stok tidak cukup untuk mengubah riwayat.');
                }

                $lama->decrement('stok', $barangMasuk->jumlah);
                $baru->increment('stok', $data['jumlah']);
            }

            $barangMasuk->update($data);
        });

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil diperbarui!');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {
            $barang = Barang::where('id', $barangMasuk->barang_id)
                ->lockForUpdate()->firstOrFail();

            if ($barang->stok < $barangMasuk->jumlah) {
                throw new \Exception('Stok tidak cukup untuk menghapus riwayat ini.');
            }

            $barang->decrement('stok', $barangMasuk->jumlah);
            $barangMasuk->delete();
        });

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus!');
    }
}
