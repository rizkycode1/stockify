
@extends('layouts.app')

@section('title', 'Riwayat Barang Keluar')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <div class="text-primary fw-bold small mb-2">
                <i class="fa-solid fa-arrow-up-from-bracket me-1"></i>
                INVENTORY CONTROL
            </div>
            <h3 class="fw-bold mb-1">Riwayat Barang Keluar</h3>
            <p class="text-muted mb-0">
                Pantau seluruh transaksi pengeluaran barang dari gudang.
            </p>
        </div>

        <a href="{{ route('barang-keluar.create') }}" class="btn btn-primary px-4">
            <i class="fa-solid fa-plus me-2"></i>Tambah Barang Keluar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100"
                 style="background:#151d2b; border-radius:15px; color:white;">
                <div class="card-body p-4">
                    <div class="text-secondary small mb-2">Total Transaksi</div>
                    <h3 class="fw-bold mb-0">
                        {{ $barangKeluars->total() }}
                    </h3>
                    <small class="text-secondary">Seluruh catatan barang keluar</small>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100"
                 style="background:#151d2b; border-radius:15px; color:white;">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3"
                         style="background:rgba(13,110,253,.15);">
                        <i class="fa-solid fa-box-open fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Kontrol Pengeluaran Stok</h6>
                        <p class="text-secondary small mb-0">
                            Setiap transaksi yang tersimpan otomatis mengurangi stok barang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm"
         style="background:#151d2b; border-radius:15px; color:white;">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1">Data Transaksi</h5>
                    <p class="text-secondary small mb-0">
                        Daftar pengeluaran barang yang tercatat.
                    </p>
                </div>
                <span class="badge bg-primary">
                    {{ $barangKeluars->total() }} Transaksi
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr class="text-secondary small">
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Keluar</th>
                            <th>Tanggal</th>
                            <th>Tujuan / Penerima</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($barangKeluars as $index => $item)
                            <tr>
                                <td>
                                    {{ $barangKeluars->firstItem() + $index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $item->barang->nama_barang ?? 'Barang dihapus' }}
                                </td>

                                <td>
                                    <span class="badge bg-danger bg-opacity-25 text-danger px-3 py-2">
                                        -{{ $item->jumlah }} unit
                                    </span>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ $item->tujuan ?? '-' }}
                                </td>

                                <td>
                                    <span class="text-secondary">
                                        {{ $item->keterangan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fa-solid fa-box-open fa-3x text-secondary mb-3"></i>
                                    <h6 class="fw-bold">Belum Ada Transaksi</h6>
                                    <p class="text-secondary small">
                                        Belum ada barang yang dikeluarkan dari gudang.
                                    </p>
                                    <a href="{{ route('barang-keluar.create') }}"
                                       class="btn btn-primary btn-sm">
                                        Tambah Transaksi Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $barangKeluars->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
