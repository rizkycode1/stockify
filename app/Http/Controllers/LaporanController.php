<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        $tahun = (int) $request->input('tahun', now()->year);

        // Ringkasan inventaris
        $totalBarang = Barang::where('company_id', $companyId)
            ->count();

        $totalStok = Barang::where('company_id', $companyId)
            ->sum('stok');

        $totalKategori = Kategori::where('company_id', $companyId)
            ->count();

        $totalSupplier = Supplier::where('company_id', $companyId)
            ->count();

        // Nilai inventaris
        $nilaiInventaris = Barang::where('company_id', $companyId)
            ->selectRaw('COALESCE(SUM(harga * stok), 0) as total')
            ->value('total');

        // Stok rendah
        $stokRendah = Barang::with(['kategori', 'supplier'])
            ->where('company_id', $companyId)
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->get();

        // Daftar barang
        $daftarBarang = Barang::with(['kategori', 'supplier'])
            ->where('company_id', $companyId)
            ->latest()
            ->get();

        // Distribusi stok per kategori
        $stokPerKategori = Kategori::where('company_id', $companyId)
            ->with(['barangs' => function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            }])
            ->get()
            ->map(function ($kategori) {
                $kategori->total_stok = $kategori->barangs->sum('stok');
                $kategori->total_barang = $kategori->barangs->count();

                return $kategori;
            });

        // Grafik barang masuk bulanan
        $dataMasuk = BarangMasuk::where('company_id', $companyId)
            ->whereYear('tanggal', $tahun)
            ->get(['tanggal', 'jumlah']);

        $bulanLabels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $grafikBarangMasuk = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $grafikBarangMasuk[] = $dataMasuk
                ->filter(function ($item) use ($bulan) {
                    return Carbon::parse($item->tanggal)->month == $bulan;
                })
                ->sum('jumlah');
        }

        // Aktivitas barang masuk pada tahun terpilih
        $barangMasuk = BarangMasuk::with('barang')
            ->where('company_id', $companyId)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->take(10)
            ->get();

        return view('laporan.index', compact(
            'tahun',
            'bulanLabels',
            'grafikBarangMasuk',
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
