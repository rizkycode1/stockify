
@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')

<style>
    .category-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:25px;
    }

    .category-title {
        color:#edf3ff;
        font-size:25px;
        font-weight:800;
        margin:0;
    }

    .category-subtitle {
        color:#8b9bb5;
        font-size:13px;
        margin-top:7px;
    }

    .category-card {
        background:#111c30;
        border:1px solid #24334d;
        border-radius:16px;
        padding:20px;
        height:100%;
    }

    .category-card-label {
        color:#8b9bb5;
        font-size:12px;
        margin-bottom:10px;
    }

    .category-card-value {
        color:#edf3ff;
        font-size:27px;
        font-weight:800;
    }

    .category-icon {
        width:43px;
        height:43px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#1b3761;
        color:#70aaff;
        font-size:17px;
    }

    .category-table-card {
        background:#111c30;
        border:1px solid #24334d;
        border-radius:16px;
        overflow:hidden;
    }

    .category-table-top {
        padding:20px;
        border-bottom:1px solid #24334d;
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
    }

    .category-table-title {
        color:#edf3ff;
        font-weight:700;
        font-size:16px;
        margin:0;
    }

    .category-search {
        background:#0b1425;
        border:1px solid #2a3b58;
        border-radius:9px;
        color:#edf3ff;
        padding:10px 13px;
        min-width:230px;
        outline:none;
    }

    .category-search:focus {
        border-color:#3984ff;
    }

    .category-table {
        color:#cbd7eb;
        margin:0;
        min-width:650px;
    }

    .category-table thead th {
        background:#0d1729;
        color:#8b9bb5;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:1px;
        font-weight:700;
        padding:16px 20px;
        border-bottom:1px solid #24334d;
        white-space:nowrap;
    }

    .category-table tbody td {
        padding:17px 20px;
        border-bottom:1px solid #202e45;
        vertical-align:middle;
        font-size:13px;
    }

    .category-table tbody tr:hover {
        background:#17253c;
    }

    .category-table tbody tr:last-child td {
        border-bottom:0;
    }

    .category-name {
        color:#edf3ff;
        font-weight:700;
    }

    .category-number {
        width:30px;
        height:30px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:#1b3761;
        color:#79b2ff;
        border-radius:9px;
        font-size:12px;
        font-weight:700;
    }

    .category-description {
        color:#9aabc3;
        max-width:300px;
    }

    .category-badge {
        background:#173b35;
        color:#52d6a9;
        border:1px solid #225b4e;
        padding:6px 10px;
        border-radius:20px;
        font-size:11px;
        font-weight:700;
    }

    .action-btn {
        width:34px;
        height:34px;
        display:inline-flex;
        justify-content:center;
        align-items:center;
        border-radius:9px;
        text-decoration:none;
        border:1px solid transparent;
        transition:.2s;
    }

    .action-edit {
        color:#70aaff;
        background:#19345a;
        border-color:#294d7b;
    }

    .action-edit:hover {
        background:#26518a;
        color:white;
    }

    .action-delete {
        color:#ff8293;
        background:#482533;
        border-color:#713448;
    }

    .action-delete:hover {
        background:#773047;
        color:white;
    }

    .category-empty {
        padding:55px 20px !important;
        text-align:center;
        color:#8b9bb5;
    }

    .category-empty i {
        font-size:35px;
        color:#45638c;
        margin-bottom:15px;
    }

    .btn-category {
        background:#3984ff;
        color:white;
        border:0;
        border-radius:10px;
        padding:12px 18px;
        text-decoration:none;
        font-weight:700;
    }

    .btn-category:hover {
        background:#246bd8;
        color:white;
    }

    @media(max-width:768px) {
        .category-title { font-size:21px; }
        .category-search { width:100%; min-width:0; }
        .category-table-top { align-items:stretch; }
    }
</style>

<div class="category-header">
    <div>
        <div class="text-uppercase small mb-2"
             style="color:#65a3ff;letter-spacing:2px;font-weight:700;">
            INVENTORY / MASTER DATA
        </div>

        <h3 class="category-title">Manajemen Kategori</h3>

        <p class="category-subtitle">
            Kelola dan kelompokkan seluruh barang inventaris perusahaan.
        </p>
    </div>

    <a href="{{ route('kategori.create') }}" class="btn-category">
        <i class="fas fa-plus me-2"></i>Tambah Kategori
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="category-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="category-card-label">Total Kategori</div>
                    <div class="category-card-value">
                        {{ $kategoris->count() }}
                    </div>
                </div>
                <div class="category-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <div class="small mt-3" style="color:#8b9bb5;">
                <i class="fas fa-database me-1"></i>
                Kategori tersimpan dalam sistem
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="category-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="category-card-label">Kategori Terdaftar</div>
                    <div class="category-card-value">
                        {{ $kategoris->whereNotNull('nama_kategori')->count() }}
                    </div>
                </div>
                <div class="category-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
            <div class="small mt-3" style="color:#8b9bb5;">
                <i class="fas fa-check-circle me-1"></i>
                Data kategori yang tersedia
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="category-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="category-card-label">Kategori dengan Deskripsi</div>
                    <div class="category-card-value">
                        {{ $kategoris->filter(fn($item) => filled($item->deskripsi))->count() }}
                    </div>
                </div>
                <div class="category-icon">
                    <i class="fas fa-align-left"></i>
                </div>
            </div>
            <div class="small mt-3" style="color:#8b9bb5;">
                <i class="fas fa-info-circle me-1"></i>
                Kategori yang memiliki keterangan
            </div>
        </div>
    </div>
</div>

<div class="category-table-card">

    <div class="category-table-top">
        <div>
            <h5 class="category-table-title">Daftar Kategori</h5>
            <div class="small mt-1" style="color:#8b9bb5;">
                Informasi seluruh kategori barang
            </div>
        </div>

        <input type="text"
               id="searchKategori"
               class="category-search"
               placeholder="Cari nama kategori...">
    </div>

    <div class="table-responsive">
        <table class="table category-table align-middle">
            <thead>
                <tr>
                    <th style="width:75px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody id="kategoriTable">
                @forelse($kategoris as $kategori)
                    <tr>
                        <td>
                            <span class="category-number">
                                {{ $loop->iteration }}
                            </span>
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="category-icon" style="width:36px;height:36px;">
                                    <i class="fas fa-folder"></i>
                                </div>
                                <span class="category-name">
                                    {{ $kategori->nama_kategori }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="category-description">
                                {{ $kategori->deskripsi ?: 'Belum ada deskripsi' }}
                            </div>
                        </td>

                        <td>
                            <span class="category-badge">
                                <i class="fas fa-check-circle me-1"></i>
                                Aktif
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('kategori.edit', $kategori->id) }}"
                                   class="action-btn action-edit"
                                   title="Edit kategori">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('kategori.destroy', $kategori->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="action-btn action-delete"
                                            title="Hapus kategori">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="category-empty">
                            <i class="fas fa-folder-open d-block"></i>
                            <div class="fw-bold text-white mb-2">
                                Belum Ada Kategori
                            </div>
                            <div class="small mb-3">
                                Mulai dengan menambahkan kategori pertama.
                            </div>
                            <a href="{{ route('kategori.create') }}"
                               class="btn-category">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Kategori
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2"
         style="border-top:1px solid #24334d;">
        <span class="small" style="color:#8b9bb5;">
            Total {{ $kategoris->count() }} kategori
        </span>

        <span class="small" style="color:#8b9bb5;">
            <i class="fas fa-shield-alt me-1"></i>
            Stockify Inventory System
        </span>
    </div>
</div>

<script>
    document.getElementById('searchKategori').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('#kategoriTable tr');

        rows.forEach(function (row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>

@endsection
