
@extends('layouts.app')

@section('title', 'Laporan Inventaris')

@section('content')
<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <div>
            <div class="eyebrow"><i class="fas fa-chart-line"></i> BUSINESS INTELLIGENCE</div>
            <h2>Inventory <span>Analytics</span></h2>
            <p>Analisis persediaan dan performa inventaris Stockify.</p>
        </div>

        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-file-pdf"></i>
            Cetak Laporan
        </button>
    </div>

    {{-- SUMMARY --}}
    <div class="report-stats">
        <div class="stat-card">
            <div class="stat-top">
                <span>Total Barang</span>
                <div class="stat-icon blue"><i class="fas fa-boxes-stacked"></i></div>
            </div>
            <h2>{{ number_format($totalBarang) }}</h2>
            <small>Jenis barang terdaftar</small>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span>Total Stok</span>
                <div class="stat-icon green"><i class="fas fa-cubes"></i></div>
            </div>
            <h2>{{ number_format($totalStok) }}</h2>
            <small>Unit persediaan tersedia</small>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span>Kategori</span>
                <div class="stat-icon purple"><i class="fas fa-layer-group"></i></div>
            </div>
            <h2>{{ number_format($totalKategori) }}</h2>
            <small>Kelompok inventaris</small>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <span>Supplier</span>
                <div class="stat-icon orange"><i class="fas fa-truck-fast"></i></div>
            </div>
            <h2>{{ number_format($totalSupplier) }}</h2>
            <small>Mitra pemasok terdaftar</small>
        </div>
    </div>

    {{-- INVENTORY VALUE --}}
    <div class="value-card">
        <div class="value-content">
            <div class="eyebrow">TOTAL INVENTORY VALUATION</div>
            <h2>Rp {{ number_format($nilaiInventaris, 0, ',', '.') }}</h2>
            <p>Estimasi nilai seluruh persediaan berdasarkan harga barang dikalikan jumlah stok.</p>
        </div>
        <div class="value-decoration">
            <i class="fas fa-chart-pie"></i>
        </div>
    </div>

    {{-- INVENTORY TABLE --}}
    <div class="report-panel">
        <div class="panel-heading">
            <div>
                <h5>Daftar Seluruh Barang</h5>
                <p>Rincian lengkap inventaris perusahaan</p>
            </div>
            <span class="panel-label">INVENTORY DATA</span>
        </div>

        <div class="table-responsive">
            <table class="enterprise-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Supplier</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Nilai Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarBarang as $barang)
                    <tr>
                        <td class="number">{{ $loop->iteration }}</td>
                        <td class="item-name">{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $barang->supplier->nama_supplier ?? '-' }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($barang->stok <= 5)
                                <span class="status-low">{{ $barang->stok }} Rendah</span>
                            @else
                                <span class="status-safe">{{ $barang->stok }} Aman</span>
                            @endif
                        </td>
                        <td class="amount">
                            Rp {{ number_format($barang->harga * $barang->stok, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">Belum ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- STOCK ALERT AND CATEGORY --}}
    <div class="report-grid">

        <div class="report-panel">
            <div class="panel-heading">
                <div>
                    <h5>Monitoring Stok Rendah</h5>
                    <p>Barang yang membutuhkan perhatian</p>
                </div>
                <div class="stat-icon red"><i class="fas fa-triangle-exclamation"></i></div>
            </div>

            <div class="panel-content">
                @forelse($stokRendah as $barang)
                <div class="list-row">
                    <div class="list-info">
                        <strong>{{ $barang->nama_barang }}</strong>
                        <small>{{ $barang->kategori->nama_kategori ?? 'Tanpa kategori' }}</small>
                    </div>
                    <span class="status-low">{{ $barang->stok }} tersisa</span>
                </div>
                @empty
                <div class="success-message">
                    <i class="fas fa-circle-check"></i>
                    Semua stok barang dalam kondisi aman.
                </div>
                @endforelse
            </div>
        </div>

        <div class="report-panel">
            <div class="panel-heading">
                <div>
                    <h5>Distribusi Kategori</h5>
                    <p>Jumlah barang berdasarkan kategori</p>
                </div>
                <div class="stat-icon purple"><i class="fas fa-chart-column"></i></div>
            </div>

            <div class="panel-content">
                @forelse($stokPerKategori as $kategori)
                <div class="list-row">
                    <div class="list-info">
                        <strong>{{ $kategori->nama_kategori }}</strong>
                        <small>Kategori inventaris</small>
                    </div>
                    <span class="category-count">{{ $kategori->barangs_count }} barang</span>
                </div>
                @empty
                <div class="empty-message">Belum ada kategori terdaftar.</div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- RECENT STOCK MOVEMENT --}}
    <div class="report-panel recent-panel">
        <div class="panel-heading">
            <div>
                <h5>Aktivitas Barang Masuk</h5>
                <p>Catatan transaksi persediaan terbaru</p>
            </div>
            <span class="panel-label">RECENT MOVEMENT</span>
        </div>

        <div class="table-responsive">
            <table class="enterprise-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Masuk</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangMasuk as $masuk)
                    <tr>
                        <td class="number">{{ $loop->iteration }}</td>
                        <td class="item-name">{{ $masuk->barang->nama_barang ?? 'Barang dihapus' }}</td>
                        <td><span class="status-safe">+{{ $masuk->jumlah }} unit</span></td>
                        <td>{{ $masuk->tanggal }}</td>
                        <td>{{ $masuk->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada riwayat barang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="report-footer">
        <span>STOCKIFY · INVENTORY MANAGEMENT SYSTEM</span>
        <span>Generated {{ now()->format('d M Y, H:i') }}</span>
    </div>

</div>

<style>
.report-page { color: var(--text); }

.report-header {
    display:flex; justify-content:space-between; align-items:center;
    gap:20px; margin-bottom:28px;
}
.eyebrow {
    color:var(--blue-light); font-size:10px; font-weight:800;
    letter-spacing:2px; margin-bottom:9px;
}
.report-header h2 { font-size:28px; font-weight:800; margin:0; }
.report-header h2 span { color:var(--blue-light); }
.report-header p { color:var(--muted); margin:7px 0 0; font-size:13px; }

.btn-print {
    border:0; background:var(--blue); color:white; border-radius:10px;
    padding:12px 17px; font-weight:700; font-size:13px;
}
.btn-print:hover { background:#246ce0; }

.report-stats {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:16px; margin-bottom:20px;
}
.stat-card {
    background:var(--panel); border:1px solid var(--border);
    border-radius:15px; padding:20px;
}
.stat-top { display:flex; justify-content:space-between; align-items:center; }
.stat-top > span { color:var(--muted); font-size:12px; }
.stat-card h2 { font-size:27px; font-weight:800; margin:18px 0 5px; }
.stat-card small { color:var(--muted); font-size:11px; }

.stat-icon {
    width:39px; height:39px; border-radius:11px;
    display:flex; align-items:center; justify-content:center;
}
.stat-icon.blue { background:#3984ff20; color:#65a3ff; }
.stat-icon.green { background:#22c58b20; color:#22c58b; }
.stat-icon.purple { background:#a78bfa20; color:#a78bfa; }
.stat-icon.orange { background:#f59e0b20; color:#f59e0b; }
.stat-icon.red { background:#ff647c20; color:#ff647c; }

.value-card {
    position:relative; overflow:hidden; display:flex;
    justify-content:space-between; align-items:center;
    background:linear-gradient(115deg,#12346a,#1553a7 65%,#2477db);
    border:1px solid #3984ff55; border-radius:16px;
    padding:26px 30px; margin-bottom:22px;
}
.value-card .eyebrow { color:#b8d5ff; }
.value-card h2 { color:white; font-size:30px; font-weight:800; margin:9px 0; }
.value-card p { color:#d0e2ff; font-size:12px; margin:0; }
.value-decoration { font-size:75px; color:#ffffff20; padding-right:20px; }

.report-panel {
    background:var(--panel); border:1px solid var(--border);
    border-radius:15px; overflow:hidden; margin-bottom:20px;
}
.panel-heading {
    padding:19px 22px; display:flex; justify-content:space-between;
    align-items:center; border-bottom:1px solid var(--border); gap:12px;
}
.panel-heading h5 { font-size:14px; font-weight:800; margin:0; }
.panel-heading p { font-size:11px; color:var(--muted); margin:5px 0 0; }
.panel-label {
    color:var(--blue-light); background:#3984ff16;
    padding:7px 10px; border-radius:7px; font-size:9px;
    font-weight:800; letter-spacing:1px;
}
.enterprise-table { width:100%; border-collapse:collapse; font-size:12px; }
.enterprise-table thead { background:#ffffff05; }
.enterprise-table th {
    padding:14px 17px; color:var(--muted); font-size:10px;
    text-transform:uppercase; letter-spacing:.6px; white-space:nowrap;
}
.enterprise-table td {
    padding:14px 17px; border-top:1px solid var(--border);
    color:var(--text); white-space:nowrap;
}
.enterprise-table tbody tr:hover { background:#ffffff06; }
.number { color:var(--muted)!important; }
.item-name { font-weight:700; }
.amount { color:var(--blue-light)!important; font-weight:700; }

.status-low, .status-safe, .category-count {
    display:inline-block; padding:6px 9px; border-radius:7px;
    font-size:10px; font-weight:700;
}
.status-low { color:#ff8496; background:#ff647c18; }
.status-safe { color:#35d6a0; background:#22c58b18; }
.category-count { color:#82b5ff; background:#3984ff20; }

.report-grid {
    display:grid; grid-template-columns:1fr 1fr; gap:20px;
}
.report-grid .report-panel { margin:0; }
.panel-content { padding:4px 21px 12px; }
.list-row {
    display:flex; justify-content:space-between; align-items:center;
    gap:12px; padding:15px 0; border-bottom:1px solid var(--border);
}
.list-row:last-child { border-bottom:0; }
.list-info { display:flex; flex-direction:column; gap:5px; }
.list-info strong { font-size:12px; }
.list-info small { color:var(--muted); font-size:10px; }
.success-message, .empty-message, .empty-state {
    color:var(--muted); padding:22px; text-align:center; font-size:12px;
}
.success-message { color:#35d6a0; }
.success-message i { margin-right:7px; }
.recent-panel { margin-top:20px; }
.report-footer {
    display:flex; justify-content:space-between; gap:10px;
    color:var(--muted); font-size:9px; letter-spacing:.6px;
    padding:8px 2px 2px;
}

@media(max-width:1000px) {
    .report-stats { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:650px) {
    .report-header { align-items:flex-start; flex-direction:column; }
    .report-header h2 { font-size:23px; }
    .report-grid { grid-template-columns:1fr; }
    .value-card { padding:22px; }
    .value-card h2 { font-size:23px; }
    .value-decoration { font-size:45px; padding:0; }
    .report-footer { flex-direction:column; }
}

@media print {
    body, .report-page { background:white!important; color:#172033!important; }
    .sidebar, .topbar, nav, button, .btn-print { display:none!important; }
    .report-page { padding:0!important; }
    .stat-card, .report-panel, .value-card {
        background:white!important; color:#172033!important;
        border:1px solid #ddd!important; box-shadow:none!important;
        break-inside:avoid;
    }
    .stat-card h2, .panel-heading h5, .enterprise-table td,
    .list-info strong { color:#172033!important; }
    .enterprise-table th, .panel-heading p, .list-info small,
    .report-header p { color:#555!important; }
    .value-card h2, .value-card p, .value-card .eyebrow { color:#172033!important; }
    .value-decoration { display:none; }
    .report-grid { break-inside:avoid; }
}
</style>
@endsection
