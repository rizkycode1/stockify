<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BarangMasukController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $barangMasuks = BarangMasuk::with('barang')
            ->where('company_id', $companyId)
            ->latest()
            ->get();

        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $companyId = Auth::user()->company_id;

        $barangs = Barang::where('company_id', $companyId)
            ->orderBy('nama_barang')
            ->get();

        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $data = $request->validate([
            'barang_id' => [
                'required',
                Rule::exists('barangs', 'id')
                    ->where('company_id', $companyId),
            ],
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($data, $companyId) {
            $barang = Barang::where('company_id', $companyId)
                ->where('id', $data['barang_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $barang->increment('stok', $data['jumlah']);

            $barangMasuk = new BarangMasuk($data);
            $barangMasuk->company_id = $companyId;
            $barangMasuk->save();
        });

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan!');
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $companyId = Auth::user()->company_id;

        $barangMasuk = BarangMasuk::where('company_id', $companyId)
            ->findOrFail($barangMasuk->id);

        $barangs = Barang::where('company_id', $companyId)
            ->orderBy('nama_barang')
            ->get();

        return view('barang_masuk.edit', compact(
            'barangMasuk',
            'barangs'
        ));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $companyId = Auth::user()->company_id;

        $barangMasuk = BarangMasuk::where('company_id', $companyId)
            ->findOrFail($barangMasuk->id);

        $data = $request->validate([
            'barang_id' => [
                'required',
                Rule::exists('barangs', 'id')
                    ->where('company_id', $companyId),
            ],
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $berhasil = DB::transaction(function () use (
            $data,
            $companyId,
            $barangMasuk
        ) {
            $riwayat = BarangMasuk::where('company_id', $companyId)
                ->where('id', $barangMasuk->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lama = Barang::where('company_id', $companyId)
                ->where('id', $riwayat->barang_id)
                ->lockForUpdate()
                ->firstOrFail();

            $baru = Barang::where('company_id', $companyId)
                ->where('id', $data['barang_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($lama->id == $baru->id) {
                $stokBaru = $lama->stok
                    - $riwayat->jumlah
                    + $data['jumlah'];

                if ($stokBaru < 0) {
                    return false;
                }

                $lama->stok = $stokBaru;
                $lama->save();
            } else {
                if ($lama->stok < $riwayat->jumlah) {
                    return false;
                }

                $lama->decrement('stok', $riwayat->jumlah);
                $baru->increment('stok', $data['jumlah']);
            }

            $riwayat->update($data);

            return true;
        });

        if (!$berhasil) {
            return back()->withInput()->with(
                'error',
                'Stok tidak cukup untuk mengubah riwayat barang masuk.'
            );
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil diperbarui!');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $companyId = Auth::user()->company_id;

        $barangMasuk = BarangMasuk::where('company_id', $companyId)
            ->findOrFail($barangMasuk->id);

        $berhasil = DB::transaction(function () use (
            $barangMasuk,
            $companyId
        ) {
            $riwayat = BarangMasuk::where('company_id', $companyId)
                ->where('id', $barangMasuk->id)
                ->lockForUpdate()
                ->firstOrFail();

            $barang = Barang::where('company_id', $companyId)
                ->where('id', $riwayat->barang_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($barang->stok < $riwayat->jumlah) {
                return false;
            }

            $barang->decrement('stok', $riwayat->jumlah);

            $riwayat->delete();

            return true;
        });

        if (!$berhasil) {
            return back()->with(
                'error',
                'Stok tidak cukup untuk menghapus riwayat ini.'
            );
        }

        return redirect()->route('barang-masuk.index')
            ->with('success', 'Data barang masuk berhasil dihapus!');
    }
}
