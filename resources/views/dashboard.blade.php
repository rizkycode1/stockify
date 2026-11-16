
@extends('layouts.app')

@section('title', 'Executive Dashboard')
@section('breadcrumb', 'Executive Overview')

@section('content')

<div class="stockify-dashboard">

    {{-- HEADER --}}
    <div class="dash-header">
        <div>
            <div class="dash-eyebrow">
                <i class="fas fa-chart-line"></i> STOCKIFY BUSINESS INTELLIGENCE
            </div>
            <h2>Executive <span>Overview</span></h2>
            <p>Selamat datang kembali, {{ auth()->user()->name }}. Berikut kondisi inventaris perusahaan.</p>
        </div>

        <div class="dash-header-actions">
            <div class="live-indicator">
                <span></span> SYSTEM ONLINE
            </div>
            <a href="{{ route('laporan.index') }}" class="dash-report-btn">
                <i class="fas fa-file-lines"></i> Laporan
            </a>
        </div>
    </div>

    {{-- HERO --}}
    <div class="dash-hero">
        <div class="hero-content">
            <div class="hero-label">
                <i class="fas fa-warehouse"></i> INVENTORY CONTROL CENTER
            </div>

            <h1>Control Your Inventory.<br>
                <span>Lead With Better Insights.</span>
            </h1>

            <p>
                Satu pusat kendali untuk memantau persediaan, mengelola
                operasional, dan mengambil keputusan bisnis dengan lebih baik.
            </p>

            <div class="hero-actions">
                <a href="{{ route('barang.index') }}" class="hero-primary">
                    Kelola Inventaris <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('barang-masuk.create') }}" class="hero-secondary">
                    <i class="fas fa-plus"></i> Barang Masuk
                </a>
            </div>
        </div>

        <div class="hero-graphic">
            <div class="graphic-ring ring-one"></div>
            <div class="graphic-ring ring-two"></div>
            <div class="graphic-center">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="graphic-tag tag-top">
                <i class="fas fa-shield-halved"></i> INVENTORY SYSTEM
            </div>
            <div class="graphic-tag tag-bottom">
                <i class="fas fa-circle-check"></i> MANAGEMENT ACTIVE
            </div>
        </div>

        <div class="hero-decoration"></div>
    </div>

    {{-- KPI --}}
    <div class="section-heading">
        <div>
            <span class="section-eyebrow">KEY PERFORMANCE INDICATORS</span>
            <h4>Inventory Performance</h4>
        </div>
        <span class="section-date">{{ now()->format('d M Y') }}</span>
    </div>

    <div class="kpi-grid">

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-blue">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <span class="kpi-code">INV-001</span>
            </div>
            <div class="kpi-label">Total Jenis Barang</div>
            <div class="kpi-value">{{ number_format($totalBarang) }}</div>
            <div class="kpi-footer">
                <i class="fas fa-database"></i> Data barang terdaftar
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-green">
                    <i class="fas fa-cubes"></i>
                </div>
                <span class="kpi-code">STK-002</span>
            </div>
            <div class="kpi-label">Total Unit Stok</div>
            <div class="kpi-value">{{ number_format($totalStok) }}</div>
            <div class="kpi-footer">
                <i class="fas fa-layer-group"></i> Seluruh unit persediaan
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-purple">
                    <i class="fas fa-layer-group"></i>
                </div>
                <span class="kpi-code">CAT-003</span>
            </div>
            <div class="kpi-label">Total Kategori</div>
            <div class="kpi-value">{{ number_format($totalKategori) }}</div>
            <div class="kpi-footer">
                <i class="fas fa-tags"></i> Klasifikasi inventaris
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-top">
                <div class="kpi-icon kpi-orange">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <span class="kpi-code">SUP-004</span>
            </div>
            <div class="kpi-label">Total Supplier</div>
            <div class="kpi-value">{{ number_format($totalSupplier) }}</div>
            <div class="kpi-footer">
                <i class="fas fa-handshake"></i> Mitra pemasok terdaftar
            </div>
        </div>

    </div>

    {{-- OPERATIONS --}}
    <div class="section-heading">
        <div>
            <span class="section-eyebrow">OPERATIONAL INTELLIGENCE</span>
            <h4>Operations Center</h4>
        </div>
    </div>

    <div class="operations-grid">

        {{-- OPERATIONAL OVERVIEW --}}
        <div class="dash-panel operations-main">
            <div class="panel-header">
                <div>
                    <h5>Operational Overview</h5>
                    <p>Ringkasan data operasional Stockify</p>
                </div>
                <div class="panel-icon">
                    <i class="fas fa-chart-column"></i>
                </div>
            </div>

            <div class="operations-content">

                <div class="operation-metric">
                    <div class="operation-info">
                        <span>Kategori Terdaftar</span>
                        <strong>{{ number_format($totalKategori) }}</strong>
                    </div>
                    <div class="operation-track">
                        <div class="operation-fill fill-blue {{ $totalKategori > 0 ? 'has-data' : 'no-data' }}"></div>
                    </div>
                    <small>Kelompok inventaris dalam sistem</small>
                </div>

                <div class="operation-metric">
                    <div class="operation-info">
                        <span>Supplier Terdaftar</span>
                        <strong>{{ number_format($totalSupplier) }}</strong>
                    </div>
                    <div class="operation-track">
                        <div class="operation-fill fill-green {{ $totalSupplier > 0 ? 'has-data' : 'no-data' }}"></div>
                    </div>
                    <small>Mitra pemasok perusahaan</small>
                </div>

                <div class="system-status">
                    <div class="system-status-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div>
                        <strong>Inventory Management System</strong>
                        <small>Dashboard pengelolaan inventaris Stockify</small>
                    </div>
                    <span class="active-badge">ACTIVE</span>
                </div>

            </div>
        </div>

        {{-- STOCK ALERT --}}
        <div class="dash-panel stock-alert-panel">
            <div class="panel-header">
                <div>
                    <h5>Stock Intelligence</h5>
                    <p>Monitoring persediaan menipis</p>
                </div>
                <div class="panel-icon warning-icon">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
            </div>

            <div class="alert-summary">
                <div>
                    <span>Barang Stok Rendah</span>
                    <strong>{{ $stokRendah->count() }}</strong>
                </div>
                <div class="alert-summary-icon">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>

            <div class="stock-list">
                @forelse($stokRendah as $barang)
                    <div class="stock-item">
                        <div class="stock-item-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stock-item-info">
                            <strong>{{ $barang->nama_barang }}</strong>
                            <small>Stok perlu diperiksa</small>
                        </div>
                        <span class="stock-quantity">{{ $barang->stok }} unit</span>
                    </div>
                @empty
                    <div class="stock-empty">
                        <i class="fas fa-circle-check"></i>
                        <strong>Semua stok terkendali</strong>
                        <small>Tidak ada barang dengan stok rendah.</small>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('barang.index') }}" class="panel-link">
                Periksa Seluruh Inventaris
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>

    {{-- RECENT STOCK MOVEMENT --}}
    <div class="dash-panel movement-panel">
        <div class="panel-header movement-heading">
            <div>
                <span class="section-eyebrow">LATEST TRANSACTIONS</span>
                <h5>Recent Stock Movement</h5>
                <p>Aktivitas barang masuk terbaru</p>
            </div>

            <a href="{{ route('barang-masuk.index') }}" class="movement-button">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="movement-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAMA BARANG</th>
                        <th>JUMLAH MASUK</th>
                        <th>TANGGAL</th>
                        <th>KETERANGAN</th>
                        <th>STATUS</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($barangMasuk as $index => $masuk)
                    <tr>
                        <td class="muted-cell">{{ $index + 1 }}</td>
                        <td>
                            <div class="movement-item">
                                <div class="movement-item-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <strong>{{ $masuk->barang->nama_barang ?? 'Barang dihapus' }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="movement-quantity">
                                <i class="fas fa-arrow-down"></i>
                                +{{ $masuk->jumlah }} unit
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($masuk->tanggal)->format('d M Y') }}</td>
                        <td class="muted-cell">{{ $masuk->keterangan ?? '-' }}</td>
                        <td><span class="recorded-badge">TERCATAT</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-movement">
                            <i class="fas fa-inbox"></i>
                            <strong>Belum ada transaksi barang masuk</strong>
                            <small>Transaksi terbaru akan muncul di sini.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- QUICK ACCESS --}}
    <div class="section-heading quick-heading">
        <div>
            <span class="section-eyebrow">WORKSPACE</span>
            <h4>Quick Access</h4>
        </div>
    </div>

    <div class="quick-grid">
        <a href="{{ route('barang.index') }}" class="quick-card">
            <div class="quick-icon blue">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <div>
                <strong>Data Barang</strong>
                <small>Kelola seluruh inventaris</small>
            </div>
            <i class="fas fa-arrow-up-right-from-square quick-arrow"></i>
        </a>

        <a href="{{ route('kategori.index') }}" class="quick-card">
            <div class="quick-icon purple">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <strong>Kategori</strong>
                <small>Atur klasifikasi barang</small>
            </div>
            <i class="fas fa-arrow-up-right-from-square quick-arrow"></i>
        </a>

        <a href="{{ route('supplier.index') }}" class="quick-card">
            <div class="quick-icon orange">
                <i class="fas fa-truck"></i>
            </div>
            <div>
                <strong>Supplier</strong>
                <small>Kelola mitra pemasok</small>
            </div>
            <i class="fas fa-arrow-up-right-from-square quick-arrow"></i>
        </a>

        <a href="{{ route('aktivitas.index') }}" class="quick-card">
            <div class="quick-icon green">
                <i class="fas fa-clock-rotate-left"></i>
            </div>
            <div>
                <strong>Riwayat Aktivitas</strong>
                <small>Pantau aktivitas pengguna</small>
            </div>
            <i class="fas fa-arrow-up-right-from-square quick-arrow"></i>
        </a>
    </div>

    {{-- FOOTER --}}
    <div class="dashboard-footer">
        <span>
            <i class="fas fa-shield-halved"></i>
            STOCKIFY INVENTORY MANAGEMENT SYSTEM
        </span>
        <span>Executive Dashboard · {{ now()->format('d M Y H:i') }}</span>
    </div>

</div>

<style>
.stockify-dashboard { color:var(--text); }

/* HEADER */
.dash-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    margin-bottom:25px;
}
.dash-eyebrow,.section-eyebrow {
    color:var(--blue-light);
    font-size:9px;
    font-weight:800;
    letter-spacing:1.7px;
}
.dash-header h2 {
    font-size:28px;
    font-weight:800;
    margin:8px 0 5px;
}
.dash-header h2 span { color:var(--blue-light); }
.dash-header p {
    color:var(--muted);
    font-size:12px;
    margin:0;
}
.dash-header-actions {
    display:flex;
    align-items:center;
    gap:12px;
}
.live-indicator {
    color:#35d6a0;
    font-size:9px;
    font-weight:800;
    background:#22c58b12;
    padding:10px 12px;
    border:1px solid #22c58b30;
    border-radius:8px;
}
.live-indicator span {
    display:inline-block;
    width:7px;
    height:7px;
    background:#22c58b;
    border-radius:50%;
    margin-right:6px;
}
.dash-report-btn,.hero-primary,.hero-secondary,.movement-button {
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:9px;
    border-radius:9px;
    padding:11px 15px;
    font-size:11px;
    font-weight:800;
}
.dash-report-btn {
    background:var(--blue);
    color:white;
}

/* HERO */
.dash-hero {
    position:relative;
    overflow:hidden;
    min-height:280px;
    border:1px solid #3984ff45;
    border-radius:19px;
    background:linear-gradient(110deg,#112d58,#10213d 65%,#0d192e);
    padding:37px 40px;
    margin-bottom:30px;
}
.hero-content {
    position:relative;
    z-index:2;
    max-width:660px;
}
.hero-label {
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#a9cbff;
    background:#ffffff12;
    border:1px solid #ffffff17;
    border-radius:30px;
    padding:8px 13px;
    font-size:9px;
    font-weight:800;
    letter-spacing:1px;
    margin-bottom:20px;
}
.hero-content h1 {
    font-size:clamp(24px,3vw,35px);
    line-height:1.25;
    font-weight:900;
    color:white;
    margin:0 0 12px;
}
.hero-content h1 span { color:#77adff; }
.hero-content p {
    color:#b6c9e4;
    font-size:12px;
    line-height:1.8;
    max-width:500px;
    margin-bottom:22px;
}
.hero-actions {
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}
.hero-primary {
    background:#fff;
    color:#15376b;
}
.hero-secondary {
    color:white;
    background:#ffffff12;
    border:1px solid #ffffff30;
}
.hero-graphic {
    position:absolute;
    right:9%;
    top:50%;
    transform:translateY(-50%);
    width:205px;
    height:205px;
    display:grid;
    place-items:center;
}
.graphic-ring {
    position:absolute;
    border:1px solid #80b6ff35;
    border-radius:50%;
}
.ring-one { width:205px; height:205px; }
.ring-two {
    width:155px;
    height:155px;
    border-style:dashed;
}
.graphic-center {
    width:105px;
    height:105px;
    display:grid;
    place-items:center;
    border-radius:30px;
    background:linear-gradient(145deg,#3984ff,#1750a4);
    box-shadow:0 15px 50px #3984ff50;
    color:white;
    font-size:45px;
}
.graphic-tag {
    position:absolute;
    background:#142d50;
    border:1px solid #ffffff25;
    color:#c8dcff;
    padding:8px 11px;
    border-radius:8px;
    font-size:8px;
    font-weight:800;
    white-space:nowrap;
}
.tag-top { top:8px; right:-35px; }
.tag-bottom { bottom:8px; left:-35px; }
.hero-decoration {
    position:absolute;
    width:350px;
    height:350px;
    border-radius:50%;
    border:1px solid #ffffff08;
    right:-100px;
    bottom:-240px;
}

/* SECTION */
.section-heading {
    display:flex;
    justify-content:space-between;
    align-items:end;
    margin:28px 0 15px;
}
.section-heading h4 {
    font-size:16px;
    font-weight:800;
    margin:5px 0 0;
}
.section-date {
    color:var(--muted);
    font-size:10px;
}

/* KPI */
.kpi-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
}
.kpi-card {
    background:var(--panel);
    border:1px solid var(--border);
    border-radius:14px;
    padding:18px;
    transition:.2s;
}
.kpi-card:hover {
    border-color:#3984ff80;
    transform:translateY(-3px);
}
.kpi-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.kpi-icon,.quick-icon {
    width:41px;
    height:41px;
    display:grid;
    place-items:center;
    border-radius:11px;
    font-size:17px;
}
.kpi-blue,.quick-icon.blue {
    color:#65a3ff;
    background:#3984ff20;
}
.kpi-green,.quick-icon.green {
    color:#35d6a0;
    background:#22c58b20;
}
.kpi-purple,.quick-icon.purple {
    color:#b69aff;
    background:#a78bfa20;
}
.kpi-orange,.quick-icon.orange {
    color:#ffc15e;
    background:#f59e0b20;
}
.kpi-code {
    color:var(--muted);
    font-size:8px;
    letter-spacing:1px;
}
.kpi-label {
    color:var(--muted);
    font-size:11px;
    margin-top:19px;
}
.kpi-value {
    font-size:29px;
    font-weight:900;
    margin:3px 0 8px;
}
.kpi-footer {
    color:var(--muted);
    font-size:9px;
}
.kpi-footer i {
    margin-right:5px;
    color:var(--blue-light);
}

/* PANELS */
.operations-grid {
    display:grid;
    grid-template-columns:1.5fr 1fr;
    gap:16px;
}
.dash-panel {
    background:var(--panel);
    border:1px solid var(--border);
    border-radius:15px;
    overflow:hidden;
}
.panel-header {
    padding:19px 21px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid var(--border);
}
.panel-header h5 {
    font-size:13px;
    font-weight:800;
    margin:0;
}
.panel-header p {
    color:var(--muted);
    font-size:10px;
    margin:5px 0 0;
}
.panel-icon {
    width:36px;
    height:36px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:var(--blue-light);
    background:#3984ff20;
}
.warning-icon {
    color:#ffc15e;
    background:#f59e0b20;
}
.operations-content { padding:23px; }
.operation-metric { margin-bottom:24px; }
.operation-info {
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}
.operation-info span {
    color:var(--muted);
    font-size:11px;
}
.operation-info strong { font-size:12px; }
.operation-track {
    height:7px;
    border-radius:10px;
    background:#24334d;
    overflow:hidden;
}
.operation-fill {
    height:100%;
    border-radius:10px;
}
.fill-blue { background:#3984ff; }
.fill-green { background:#22c58b; }
.operation-fill.has-data { width:100%; }
.operation-fill.no-data { width:0%; }

.operation-metric > small {
    color:var(--muted);
    font-size:9px;
    display:block;
    margin-top:8px;
}
.system-status {
    display:flex;
    align-items:center;
    gap:12px;
    padding:15px;
    background:#0b1628;
    border:1px solid var(--border);
    border-radius:11px;
}
.system-status-icon {
    width:39px;
    height:39px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:#65a3ff;
    background:#3984ff20;
}
.system-status strong {
    display:block;
    font-size:11px;
}
.system-status small {
    display:block;
    color:var(--muted);
    font-size:9px;
    margin-top:4px;
}
.active-badge {
    margin-left:auto;
    color:#35d6a0;
    background:#22c58b18;
    padding:6px 8px;
    border-radius:6px;
    font-size:8px;
    font-weight:800;
}

/* STOCK ALERT */
.alert-summary {
    margin:17px 18px 5px;
    padding:15px;
    background:#ff647c0d;
    border:1px solid #ff647c25;
    border-radius:11px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.alert-summary span {
    display:block;
    color:var(--muted);
    font-size:10px;
}
.alert-summary strong {
    display:block;
    font-size:25px;
    margin-top:4px;
}
.alert-summary-icon {
    color:#ff8496;
    font-size:25px;
}
.stock-list {
    padding:0 18px;
    max-height:245px;
    overflow-y:auto;
}
.stock-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:13px 0;
    border-bottom:1px solid var(--border);
}
.stock-item-icon {
    width:33px;
    height:33px;
    border-radius:9px;
    display:grid;
    place-items:center;
    color:#ff8496;
    background:#ff647c15;
}
.stock-item-info {
    flex:1;
    min-width:0;
}
.stock-item-info strong {
    display:block;
    font-size:10px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}
.stock-item-info small {
    color:var(--muted);
    font-size:9px;
}
.stock-quantity {
    color:#ff8496;
    background:#ff647c18;
    padding:6px 8px;
    border-radius:6px;
    font-size:9px;
    font-weight:800;
}
.stock-empty {
    display:flex;
    flex-direction:column;
    align-items:center;
    padding:25px 10px;
    gap:7px;
}
.stock-empty i {
    color:#35d6a0;
    font-size:28px;
}
.stock-empty strong { font-size:11px; }
.stock-empty small {
    color:var(--muted);
    font-size:9px;
}
.panel-link {
    display:flex;
    justify-content:space-between;
    margin:12px 18px 17px;
    padding:11px;
    border-radius:8px;
    background:#3984ff12;
    color:var(--blue-light);
    text-decoration:none;
    font-size:10px;
    font-weight:800;
}

/* MOVEMENT */
.movement-panel { margin-top:20px; }
.movement-heading { padding:20px 22px; }
.movement-heading h5 { margin-top:6px; }
.movement-button {
    background:#3984ff18;
    color:var(--blue-light);
}
.movement-table {
    width:100%;
    border-collapse:collapse;
    min-width:760px;
    font-size:11px;
}
.movement-table thead { background:#ffffff05; }
.movement-table th {
    color:var(--muted);
    font-size:9px;
    letter-spacing:.6px;
    padding:14px 16px;
    text-align:left;
}
.movement-table td {
    padding:14px 16px;
    border-top:1px solid var(--border);
    white-space:nowrap;
}
.movement-table tbody tr:hover { background:#ffffff05; }
.movement-item {
    display:flex;
    align-items:center;
    gap:9px;
}
.movement-item-icon {
    width:31px;
    height:31px;
    border-radius:8px;
    background:#3984ff18;
    color:var(--blue-light);
    display:grid;
    place-items:center;
}
.movement-item strong { font-size:11px; }
.muted-cell { color:var(--muted)!important; }
.movement-quantity {
    color:#35d6a0;
    background:#22c58b18;
    padding:7px 9px;
    border-radius:7px;
    font-size:9px;
    font-weight:800;
}
.recorded-badge {
    color:#82b5ff;
    background:#3984ff18;
    padding:6px 8px;
    border-radius:6px;
    font-size:8px;
    font-weight:800;
}
.empty-movement {
    text-align:center;
    padding:35px!important;
}
.empty-movement i {
    display:block;
    font-size:26px;
    color:var(--muted);
    margin-bottom:10px;
}
.empty-movement strong {
    display:block;
    font-size:11px;
}
.empty-movement small {
    display:block;
    color:var(--muted);
    margin-top:5px;
}

/* QUICK ACCESS */
.quick-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:13px;
}
.quick-card {
    display:flex;
    align-items:center;
    gap:11px;
    background:var(--panel);
    border:1px solid var(--border);
    border-radius:12px;
    padding:15px;
    text-decoration:none;
    color:var(--text);
    transition:.2s;
    min-width:0;
}
.quick-card:hover {
    border-color:#3984ff80;
    transform:translateY(-3px);
    color:var(--text);
}
.quick-icon {
    flex-shrink:0;
    width:36px;
    height:36px;
    font-size:14px;
}
.quick-card strong {
    display:block;
    font-size:10px;
}
.quick-card small {
    display:block;
    color:var(--muted);
    font-size:8px;
    margin-top:4px;
}
.quick-arrow {
    margin-left:auto;
    color:var(--muted);
    font-size:10px;
}
.quick-heading { margin-top:27px; }
.dashboard-footer {
    display:flex;
    justify-content:space-between;
    gap:10px;
    color:var(--muted);
    font-size:9px;
    letter-spacing:.5px;
    padding:22px 2px 5px;
}
.dashboard-footer i {
    color:var(--green);
    margin-right:5px;
}

/* RESPONSIVE */
@media(max-width:1100px) {
    .kpi-grid { grid-template-columns:repeat(2,1fr); }
    .quick-grid { grid-template-columns:repeat(2,1fr); }
}
@media(max-width:850px) {
    .operations-grid { grid-template-columns:1fr; }
    .hero-graphic { right:3%; opacity:.35; }
    .hero-content { max-width:100%; }
}
@media(max-width:600px) {
    .dash-header {
        align-items:flex-start;
        flex-direction:column;
    }
    .dash-header h2 { font-size:23px; }
    .dash-header-actions { flex-wrap:wrap; }
    .dash-hero { padding:25px 20px; }
    .hero-graphic { display:none; }
    .hero-content h1 { font-size:25px; }
    .kpi-grid { gap:9px; }
    .kpi-card { padding:13px; }
    .kpi-value { font-size:23px; }
    .kpi-code { font-size:7px; }
    .quick-grid { grid-template-columns:1fr; }
    .dashboard-footer { flex-direction:column; }
}

/* PRINT */
@media print {
    .sidebar, .topbar, nav, .dash-header-actions,
    .hero-actions, .panel-link, .movement-button,
    .quick-grid {
        display:none!important;
    }
    body,.stockify-dashboard {
        background:white!important;
        color:#172033!important;
    }
    .dash-panel,.kpi-card {
        background:white!important;
        border:1px solid #ddd!important;
        break-inside:avoid;
    }
    .dash-header h2,.kpi-value,.kpi-label,
    .panel-header h5,.movement-table td {
        color:#172033!important;
    }
    .dash-hero { background:#edf3ff!important; }
    .hero-content h1,.hero-content h1 span,
    .hero-content p {
        color:#172033!important;
    }
}
</style>

@endsection
