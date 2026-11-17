<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        // Statistik inventaris perusahaan
        $totalBarang = Barang::where('company_id', $companyId)
            ->count();

        $totalKategori = Kategori::where('company_id', $companyId)
            ->count();

        $totalSupplier = Supplier::where('company_id', $companyId)
            ->count();

        $totalStok = Barang::where('company_id', $companyId)
            ->sum('stok');

        // Daftar stok rendah
        $stokRendah = Barang::where('company_id', $companyId)
            ->where('stok', '<=', 5)
            ->latest()
            ->get();

        // Riwayat barang masuk terbaru
        $barangMasuk = BarangMasuk::with('barang')
            ->where('company_id', $companyId)
            ->latest()
            ->take(5)
            ->get();

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
