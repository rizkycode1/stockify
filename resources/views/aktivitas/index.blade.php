
@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('content')
<div class="audit-page">

    {{-- HEADER --}}
    <div class="audit-header">
        <div>
            <div class="audit-eyebrow">
                <i class="fas fa-shield-halved"></i> SYSTEM SECURITY & MONITORING
            </div>
            <h2>Audit <span>Center</span></h2>
            <p>Pantau seluruh aktivitas dan perubahan data dalam sistem Stockify.</p>
        </div>

        <div class="audit-status">
            <span class="online-dot"></span>
            SYSTEM MONITORING ACTIVE
        </div>
    </div>

    {{-- STATISTICS --}}
    <div class="audit-stats">
        <div class="audit-stat">
            <div class="audit-stat-icon blue">
                <i class="fas fa-list-check"></i>
            </div>
            <div>
                <small>Total Aktivitas</small>
                <h3>{{ number_format($aktivitas->total()) }}</h3>
                <span>Seluruh catatan sistem</span>
            </div>
        </div>

        <div class="audit-stat">
            <div class="audit-stat-icon green">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <small>Halaman Saat Ini</small>
                <h3>{{ $aktivitas->count() }}</h3>
                <span>Catatan ditampilkan</span>
            </div>
        </div>

        <div class="audit-stat">
            <div class="audit-stat-icon purple">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <small>Halaman</small>
                <h3>{{ $aktivitas->currentPage() }}</h3>
                <span>Dari {{ $aktivitas->lastPage() }} halaman</span>
            </div>
        </div>
    </div>

    {{-- AUDIT LOG --}}
    <div class="audit-panel">

        <div class="audit-panel-header">
            <div>
                <h5><i class="fas fa-terminal"></i> System Activity Logs</h5>
                <p>Rekaman aktivitas pengguna secara kronologis</p>
            </div>

            <span class="audit-label">AUDIT RECORDS</span>
        </div>

        <div class="audit-table-wrap">
            <table class="audit-table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>PENGGUNA</th>
                        <th>JENIS AKTIVITAS</th>
                        <th>DESKRIPSI</th>
                        <th>TANGGAL & WAKTU</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($aktivitas as $item)
                    <tr>
                        <td class="audit-number">
                            {{ $aktivitas->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="audit-user">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $item->user->name ?? 'Pengguna dihapus' }}</strong>
                                    <small>System User</small>
                                </div>
                            </div>
                        </td>

                        <td>
                            @php
                                $action = strtolower($item->action);
                                $actionClass = match($action) {
                                    'create', 'created', 'store' => 'created',
                                    'update', 'updated', 'edit' => 'updated',
                                    'delete', 'deleted', 'destroy' => 'deleted',
                                    default => 'other',
                                };

                                $actionIcon = match($actionClass) {
                                    'created' => 'fa-plus',
                                    'updated' => 'fa-pen',
                                    'deleted' => 'fa-trash',
                                    default => 'fa-bolt',
                                };
                            @endphp

                            <span class="action-badge {{ $actionClass }}">
                                <i class="fas {{ $actionIcon }}"></i>
                                {{ ucfirst($item->action) }}
                            </span>
                        </td>

                        <td class="audit-description">
                            {{ $item->description }}
                        </td>

                        <td>
                            <div class="audit-time">
                                <strong>{{ $item->created_at->format('d M Y') }}</strong>
                                <small>
                                    <i class="far fa-clock"></i>
                                    {{ $item->created_at->format('H:i:s') }}
                                </small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="audit-empty">
                                <i class="fas fa-folder-open"></i>
                                <h5>Belum Ada Aktivitas</h5>
                                <p>Aktivitas pengguna akan muncul di halaman ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($aktivitas->hasPages())
        <div class="audit-pagination">
            <div>
                Menampilkan
                <strong>{{ $aktivitas->firstItem() ?? 0 }}</strong>
                sampai
                <strong>{{ $aktivitas->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $aktivitas->total() }}</strong> aktivitas
            </div>

            {{ $aktivitas->links() }}
        </div>
        @endif

    </div>

    {{-- FOOTER --}}
    <div class="audit-footer">
        <span><i class="fas fa-lock"></i> STOCKIFY SECURITY MONITORING</span>
        <span>Audit Center · {{ now()->format('d M Y') }}</span>
    </div>

</div>

<style>
.audit-page { color:var(--text); }

.audit-header {
    display:flex; justify-content:space-between;
    align-items:center; gap:20px; margin-bottom:26px;
}

.audit-eyebrow {
    color:var(--blue-light); font-size:10px;
    font-weight:800; letter-spacing:1.8px; margin-bottom:9px;
}

.audit-header h2 {
    font-size:28px; font-weight:800; margin:0;
}

.audit-header h2 span { color:var(--blue-light); }

.audit-header p {
    color:var(--muted); font-size:13px; margin:7px 0 0;
}

.audit-status {
    padding:10px 14px; border-radius:9px;
    background:#22c58b12; border:1px solid #22c58b30;
    color:#35d6a0; font-size:10px; font-weight:800;
    letter-spacing:.5px; white-space:nowrap;
}

.online-dot {
    display:inline-block; width:7px; height:7px;
    border-radius:50%; background:#22c58b;
    margin-right:7px;
}

.audit-stats {
    display:grid; grid-template-columns:repeat(3,1fr);
    gap:16px; margin-bottom:22px;
}

.audit-stat {
    display:flex; align-items:center; gap:15px;
    background:var(--panel); border:1px solid var(--border);
    border-radius:14px; padding:20px;
}

.audit-stat-icon {
    width:45px; height:45px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    border-radius:12px; font-size:17px;
}

.audit-stat-icon.blue { background:#3984ff20; color:#65a3ff; }
.audit-stat-icon.green { background:#22c58b20; color:#22c58b; }
.audit-stat-icon.purple { background:#a78bfa20; color:#a78bfa; }

.audit-stat small { color:var(--muted); font-size:11px; }
.audit-stat h3 { font-size:24px; font-weight:800; margin:4px 0; }
.audit-stat span { color:var(--muted); font-size:10px; }

.audit-panel {
    background:var(--panel); border:1px solid var(--border);
    border-radius:15px; overflow:hidden;
}

.audit-panel-header {
    padding:20px 22px; display:flex;
    justify-content:space-between; align-items:center;
    border-bottom:1px solid var(--border); gap:12px;
}

.audit-panel-header h5 {
    font-size:14px; font-weight:800; margin:0;
}

.audit-panel-header h5 i {
    color:var(--blue-light); margin-right:8px;
}

.audit-panel-header p {
    color:var(--muted); font-size:11px; margin:5px 0 0;
}

.audit-label {
    color:var(--blue-light); background:#3984ff18;
    padding:7px 10px; border-radius:7px;
    font-size:9px; font-weight:800; letter-spacing:1px;
}

.audit-table-wrap { overflow-x:auto; }

.audit-table {
    width:100%; border-collapse:collapse; min-width:850px;
}

.audit-table thead { background:#ffffff05; }

.audit-table th {
    padding:15px 17px; text-align:left;
    color:var(--muted); font-size:10px;
    letter-spacing:.7px; font-weight:800;
}

.audit-table td {
    padding:15px 17px;
    border-top:1px solid var(--border);
    font-size:12px; vertical-align:middle;
}

.audit-table tbody tr:hover { background:#ffffff05; }

.audit-number { color:var(--muted); }

.audit-user {
    display:flex; align-items:center; gap:10px;
}

.user-avatar {
    width:35px; height:35px; border-radius:10px;
    background:#3984ff20; color:#80b5ff;
    display:flex; align-items:center; justify-content:center;
    font-weight:800;
}

.audit-user strong {
    display:block; font-size:12px;
}

.audit-user small, .audit-time small {
    display:block; color:var(--muted);
    font-size:10px; margin-top:4px;
}

.action-badge {
    display:inline-flex; align-items:center; gap:6px;
    padding:7px 10px; border-radius:7px;
    font-size:10px; font-weight:800;
}

.action-badge.created { color:#35d6a0; background:#22c58b18; }
.action-badge.updated { color:#82b5ff; background:#3984ff20; }
.action-badge.deleted { color:#ff8496; background:#ff647c18; }
.action-badge.other { color:#c4a7ff; background:#a78bfa20; }

.audit-description {
    color:var(--muted)!important;
    max-width:320px; white-space:normal;
    line-height:1.6;
}

.audit-time strong { font-size:11px; }
.audit-time small i { margin-right:4px; }

.audit-empty {
    padding:55px 15px; text-align:center;
}

.audit-empty > i {
    color:var(--muted); font-size:35px; margin-bottom:15px;
}

.audit-empty h5 { font-weight:800; font-size:15px; }
.audit-empty p { color:var(--muted); font-size:12px; }

.audit-pagination {
    padding:17px 21px; border-top:1px solid var(--border);
    display:flex; justify-content:space-between;
    align-items:center; gap:15px; flex-wrap:wrap;
    color:var(--muted); font-size:11px;
}

.audit-pagination strong { color:var(--text); }
.audit-pagination nav { margin:0; }

.audit-footer {
    display:flex; justify-content:space-between;
    gap:10px; color:var(--muted);
    font-size:9px; letter-spacing:.6px;
    padding:17px 2px;
}

.audit-footer i { color:var(--green); margin-right:5px; }

@media(max-width:800px) {
    .audit-stats { grid-template-columns:1fr; }
    .audit-header { align-items:flex-start; flex-direction:column; }
}

@media(max-width:500px) {
    .audit-header h2 { font-size:23px; }
    .audit-footer { flex-direction:column; }
}

@media print {
    .sidebar, .topbar, nav { display:none!important; }
    body, .audit-page { background:white!important; color:#172033!important; }
    .audit-stat, .audit-panel {
        background:white!important; border:1px solid #ddd!important;
        break-inside:avoid;
    }
    .audit-stat h3, .audit-panel-header h5,
    .audit-table td, .audit-user strong { color:#172033!important; }
    .audit-table th, .audit-description { color:#555!important; }
}
</style>
@endsection
