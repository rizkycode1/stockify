
@extends('layouts.app')

@section('title', 'Supplier Management')

@section('content')
<style>
    .supplier-hero {
        background: linear-gradient(120deg, #14294b, #10203a 65%, #172f55);
        border: 1px solid #29466f;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 25px;
    }

    .supplier-card {
        background: #111c30;
        border: 1px solid #24334d;
        border-radius: 16px;
        padding: 21px;
        height: 100%;
    }

    .supplier-icon {
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: #1b3760;
        color: #65a3ff;
        font-size: 19px;
    }

    .supplier-panel {
        background: #111c30;
        border: 1px solid #24334d;
        border-radius: 16px;
        overflow: hidden;
    }

    .supplier-search {
        background: #0c1424 !important;
        border: 1px solid #293a55 !important;
        color: #edf3ff !important;
        border-radius: 10px;
        padding: 11px 14px;
    }

    .supplier-search::placeholder {
        color: #8292aa;
    }

    .supplier-table {
        color: #edf3ff;
        margin-bottom: 0;
    }

    .supplier-table th {
        background: #16233a;
        color: #91a5c3;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 16px;
        border-bottom: 1px solid #293a55;
        white-space: nowrap;
    }

    .supplier-table td {
        padding: 17px 16px;
        border-color: #24334d;
        vertical-align: middle;
    }

    .supplier-table tbody tr:hover {
        background: #16243a;
    }

    .supplier-avatar {
        width: 39px;
        height: 39px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        background: #1d3c67;
        color: #8bbaff;
        font-weight: 800;
    }

    .supplier-action {
        width: 34px;
        height: 34px;
        display: inline-grid;
        place-items: center;
        border-radius: 9px;
        text-decoration: none;
        border: 1px solid #344965;
        background: #1a2940;
        color: #8ebaff;
    }

    .supplier-action:hover {
        background: #24518c;
        color: white;
    }

    .supplier-delete {
        background: #351d2b;
        color: #ff8195;
        border-color: #633047;
    }

    .supplier-delete:hover {
        background: #a52f4c;
        color: white;
    }

    .supplier-badge {
        background: #173b35;
        color: #5ce0b1;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .supplier-empty {
        padding: 55px 15px !important;
        text-align: center;
        color: #91a5c3;
    }
</style>

@php
    $totalSupplier = $suppliers->count();
    $punyaTelepon = $suppliers->filter(fn($s) => filled($s->telepon))->count();
    $punyaAlamat = $suppliers->filter(fn($s) => filled($s->alamat))->count();
@endphp

<div class="supplier-hero">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="text-info small fw-bold mb-2">
                <i class="fa fa-building me-1"></i> PROCUREMENT MANAGEMENT
            </div>
            <h2 class="fw-bold mb-2 text-white">Supplier Directory</h2>
            <p class="mb-0" style="color:#a9bdd9">
                Kelola informasi dan data seluruh pemasok perusahaan.
            </p>
        </div>

        <a href="{{ route('supplier.create') }}" class="btn btn-primary px-4 py-3">
            <i class="fa fa-plus me-2"></i> Tambah Supplier
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="supplier-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">TOTAL SUPPLIER</div>
                    <h2 class="fw-bold mb-1">{{ $totalSupplier }}</h2>
                    <small class="text-secondary">Pemasok terdaftar</small>
                </div>
                <div class="supplier-icon">
                    <i class="fa fa-building"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="supplier-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">KONTAK TERSEDIA</div>
                    <h2 class="fw-bold mb-1">{{ $punyaTelepon }}</h2>
                    <small class="text-secondary">Supplier dengan telepon</small>
                </div>
                <div class="supplier-icon">
                    <i class="fa fa-phone"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="supplier-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small text-secondary mb-2">ALAMAT TERCATAT</div>
                    <h2 class="fw-bold mb-1">{{ $punyaAlamat }}</h2>
                    <small class="text-secondary">Supplier dengan alamat</small>
                </div>
                <div class="supplier-icon">
                    <i class="fa fa-location-dot"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="supplier-panel">
    <div class="p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="fw-bold mb-1">Daftar Pemasok</h5>
            <small class="text-secondary">Informasi supplier yang terdaftar dalam sistem</small>
        </div>

        <div style="width:280px;max-width:100%">
            <div class="position-relative">
                <i class="fa fa-search position-absolute"
                   style="left:14px;top:14px;color:#8292aa"></i>
                <input type="text" id="searchSupplier"
                       class="form-control supplier-search ps-5"
                       placeholder="Cari nama, telepon, alamat...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table supplier-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Supplier</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="supplierTable">
                @forelse($suppliers as $supplier)
                    <tr class="supplier-row">
                        <td class="text-secondary">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="supplier-avatar">
                                    {{ strtoupper(substr($supplier->nama_supplier, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold">
                                        {{ $supplier->nama_supplier }}
                                    </div>
                                    <small class="text-secondary">
                                        Supplier #{{ $supplier->id }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-secondary">
                                <i class="fa fa-phone me-2"></i>
                                {{ $supplier->telepon ?: 'Belum tersedia' }}
                            </span>
                        </td>

                        <td style="min-width:180px">
                            {{ $supplier->alamat ?: 'Belum tersedia' }}
                        </td>

                        <td>
                            <span class="supplier-badge">
                                <i class="fa fa-circle-check me-1"></i>
                                Terdaftar
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('supplier.edit', $supplier->id) }}"
                                   class="supplier-action"
                                   title="Edit Supplier">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('supplier.destroy', $supplier->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="supplier-action supplier-delete"
                                            title="Hapus Supplier">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="supplier-empty">
                            <i class="fa fa-building fa-3x mb-3 d-block"></i>
                            <h5>Belum Ada Supplier</h5>
                            <p class="mb-3">Tambahkan pemasok pertama ke sistem.</p>
                            <a href="{{ route('supplier.create') }}"
                               class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i> Tambah Supplier
                            </a>
                        </td>
                    </tr>
                @endforelse

                <tr id="noSearchResult" style="display:none">
                    <td colspan="6" class="supplier-empty">
                        Supplier tidak ditemukan.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="p-3 border-top d-flex justify-content-between flex-wrap gap-2"
         style="border-color:#24334d !important">
        <small class="text-secondary">
            <i class="fa fa-database me-1"></i>
            Total {{ $totalSupplier }} supplier terdaftar
        </small>
        <small class="text-secondary">STOCKIFY PROCUREMENT SYSTEM</small>
    </div>
</div>

<script>
    document.getElementById('searchSupplier').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('.supplier-row');
        let visible = 0;

        rows.forEach(row => {
            const cocok = row.textContent.toLowerCase().includes(keyword);
            row.style.display = cocok ? '' : 'none';

            if (cocok) visible++;
        });

        const noResult = document.getElementById('noSearchResult');
        if (noResult) {
            noResult.style.display = visible === 0 && rows.length > 0 ? '' : 'none';
        }
    });
</script>
@endsection
