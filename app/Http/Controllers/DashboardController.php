<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalSupplier = Supplier::count();
        $totalStok = Barang::sum('stok');

        $stokRendah = Barang::where('stok', '<=', 5)
            ->latest()->get();

        $barangMasuk = BarangMasuk::with('barang')
            ->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalBarang',
            'totalKategori',
            'totalSupplier',
            'totalStok',
            'stokRendah',
            'barangMasuk'
        ));
    }
}
