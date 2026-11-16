
@extends('layouts.app')

@section('title', 'Inventory Inbound')

@section('content')
<style>
    .inbound-hero {
        background: linear-gradient(120deg, #14294b, #10203a 65%, #17345b);
        border: 1px solid #29466f;
        border-radius: 18px;
        padding: 27px;
        margin-bottom: 25px;
    }

    .inbound-card {
        background: #111c30;
        border: 1px solid #24334d;
        border-radius: 16px;
        padding: 21px;
        height: 100%;
    }

    .inbound-icon {
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: #1b3760;
        color: #65a3ff;
        font-size: 19px;
    }

    .inbound-panel {
        background: #111c30;
        border: 1px solid #24334d;
        border-radius: 16px;
        overflow: hidden;
    }

    .inbound-search {
        background: #0c1424 !important;
        border: 1px solid #293a55 !important;
        color: #edf3ff !important;
        border-radius: 10px;
        padding: 11px 14px;
    }

    .inbound-search::placeholder {
        color: #8292aa;
    }

    .inbound-table {
        color: #edf3ff;
        margin-bottom: 0;
    }

    .inbound-table th {
        background: #16233a;
        color: #91a5c3;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px;
        border-bottom: 1px solid #293a55;
        white-space: nowrap;
    }

    .inbound-table td {
        padding: 17px 16px;
        border-color: #24334d;
        vertical-align: middle;
    }

    .inbound-table tbody tr:hover {
        background: #16243a;
    }

    .inbound-avatar {
        width: 39px;
        height: 39px;
        display: grid;
        place-items: center;
        border-radius: 11px;
        background: #1d3c67;
        color: #8bbaff;
    }

    .inbound-badge {
        display: inline-block;
        background: #173b35;
        color: #5ce0b1;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .inbound-action {
        width: 34px;
        height: 34px;
        display: inline-grid;
        place-items: center;
        border-radius: 9px;
        border: 1px solid #344965;
        background: #1a2940;
        color: #8ebaff;
        text-decoration: none;
    }

    .inbound-action:hover {
        background: #24518c;
        color: white;
    }

    .inbound-delete {
        background: #351d2b;
        color: #ff8195;
        border-color: #633047;
    }

    .inbound-delete:hover {
        background: #a52f4c;
        color: white;
    }

    .inbound-empty {
        padding: 55px 15px !important;
        text-align: center;
        color: #91a5c3;
    }
</style>

@php
    $totalTransaksi = $barangMasuks->count();
    $totalJumlah = $barangMasuks->sum('jumlah');
    $transaksiHariIni = $barangMasuks->filter(function ($item) {
        return \Carbon\Carbon::parse($item->tanggal)->isToday();
    })->count();
@endphp

<div class="inbound-hero">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="small fw-bold text-info mb-2">
                <i class="fa fa-box-open me-1"></i> INVENTORY OPERATIONS
            </div>
            <h2 class="fw-bold text-white mb-2">Barang Masuk</h2>
            <p class="mb-0" style="color:#a9bdd9">
                Pantau dan kelola seluruh transaksi penambahan persediaan.
            </p>
        </div>

        <a href="{{ route('barang-masuk.create') }}"
           class="btn btn-primary px-4 py-3">
            <i class="fa fa-plus me-2"></i> Catat Barang Masuk
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0">
        <i class="fa fa-circle-check me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger border-0">
        <i class="fa fa-circle-exclamation me-2"></i>
        {{ session('error') }}
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="inbound-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">TOTAL TRANSAKSI</div>
                    <h2 class="fw-bold mb-1">{{ $totalTransaksi }}</h2>
                    <small class="text-secondary">Catatan barang masuk</small>
                </div>
                <div class="inbound-icon">
                    <i class="fa fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="inbound-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">TOTAL UNIT MASUK</div>
                    <h2 class="fw-bold mb-1">{{ number_format($totalJumlah) }}</h2>
                    <small class="text-secondary">Akumulasi jumlah barang</small>
                </div>
                <div class="inbound-icon">
                    <i class="fa fa-boxes-stacked"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="inbound-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">TRANSAKSI HARI INI</div>
                    <h2 class="fw-bold mb-1">{{ $transaksiHariIni }}</h2>
                    <small class="text-secondary">Pencatatan hari ini</small>
                </div>
                <div class="inbound-icon">
                    <i class="fa fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="inbound-panel">
    <div class="p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="fw-bold mb-1">Riwayat Penerimaan Barang</h5>
            <small class="text-secondary">
                Daftar seluruh aktivitas barang masuk ke gudang.
            </small>
        </div>

        <div style="width:290px;max-width:100%">
            <div class="position-relative">
                <i class="fa fa-search position-absolute"
                   style="left:14px;top:14px;color:#8292aa"></i>

                <input type="text"
                       id="searchInbound"
                       class="form-control inbound-search ps-5"
                       placeholder="Cari nama barang atau keterangan...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table inbound-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Informasi Barang</th>
                    <th>Jumlah Masuk</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="inboundTable">
                @forelse($barangMasuks as $item)
                    <tr class="inbound-row">
                        <td class="text-secondary">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="inbound-avatar">
                                    <i class="fa fa-box"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">
                                        {{ $item->barang->nama_barang ?? 'Barang tidak ditemukan' }}
                                    </div>
                                    <small class="text-secondary">
                                        Transaksi #{{ $item->id }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="fw-bold text-success">
                                +{{ number_format($item->jumlah) }}
                            </span>
                            <small class="text-secondary"> unit</small>
                        </td>

                        <td>
                            <span class="text-secondary">
                                <i class="fa fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </span>
                        </td>

                        <td>
                            {{ $item->keterangan ?: '-' }}
                        </td>

                        <td>
                            <span class="inbound-badge">
                                <i class="fa fa-check-circle me-1"></i>
                                Tercatat
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('barang-masuk.edit', $item->id) }}"
                                   class="inbound-action"
                                   title="Edit transaksi">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('barang-masuk.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus transaksi ini? Stok barang akan dikurangi sesuai jumlah transaksi.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inbound-action inbound-delete"
                                            title="Hapus transaksi">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="inbound-empty">
                            <i class="fa fa-box-open fa-3x mb-3 d-block"></i>
                            <h5>Belum Ada Transaksi</h5>
                            <p class="mb-3">
                                Belum ada riwayat barang masuk yang tercatat.
                            </p>
                            <a href="{{ route('barang-masuk.create') }}"
                               class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i>
                                Catat Barang Masuk
                            </a>
                        </td>
                    </tr>
                @endforelse

                <tr id="inboundNoResult" style="display:none">
                    <td colspan="7" class="inbound-empty">
                        Data transaksi tidak ditemukan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="p-3 border-top d-flex justify-content-between flex-wrap gap-2"
         style="border-color:#24334d !important">
        <small class="text-secondary">
            <i class="fa fa-database me-1"></i>
            {{ $totalTransaksi }} transaksi tercatat
        </small>
        <small class="text-secondary">STOCKIFY INVENTORY OPERATIONS</small>
    </div>
</div>

<script>
    document.getElementById('searchInbound').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('.inbound-row');
        let visible = 0;

        rows.forEach(row => {
            const cocok = row.textContent.toLowerCase().includes(keyword);
            row.style.display = cocok ? '' : 'none';

            if (cocok) visible++;
        });

        const noResult = document.getElementById('inboundNoResult');

        if (noResult) {
            noResult.style.display =
                visible === 0 && rows.length > 0 ? '' : 'none';
        }
    });
</script>
@endsection
