<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();

        $totalStok = Barang::sum('stok');

        $totalKategori = Kategori::count();

        $totalSupplier = Supplier::count();

        $nilaiInventaris = Barang::select(
            DB::raw('COALESCE(SUM(harga * stok), 0) as total')
        )->value('total');

        $stokRendah = Barang::with(['kategori', 'supplier'])
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->get();

        $daftarBarang = Barang::with(['kategori', 'supplier'])
            ->latest()
            ->get();

        $stokPerKategori = Kategori::withCount('barangs')->get();

        $barangMasuk = BarangMasuk::with('barang')
            ->latest()
            ->take(10)
            ->get();

        return view('laporan.index', compact(
            'totalBarang',
            'totalStok',
            'totalKategori',
            'totalSupplier',
            'nilaiInventaris',
            'stokRendah',
            'daftarBarang',
            'stokPerKategori',
            'barangMasuk'
        ));
    }
}
