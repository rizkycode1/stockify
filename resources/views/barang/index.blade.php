
@extends('layouts.app')

@section('title', 'Inventory Management')
@section('breadcrumb', 'Inventory / Data Barang')

@section('content')

<style>
    .product-photo {
        width:52px;
        height:52px;
        min-width:52px;
        object-fit:cover;
        border-radius:12px;
        border:1px solid #304765;
        background:#1b3760;
    }

    .product-placeholder {
        width:52px;
        height:52px;
        min-width:52px;
        border-radius:12px;
        background:#1b3760;
        color:#75aaff;
        display:grid;
        place-items:center;
        font-size:19px;
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <div class="text-primary fw-bold small mb-2">
            <i class="fa-solid fa-boxes-stacked me-1"></i> INVENTORY CONTROL
        </div>
        <h2 class="fw-bold text-white mb-1">Inventory Management</h2>
        <p class="text-muted mb-0">Kelola seluruh persediaan barang perusahaan.</p>
    </div>

    <a href="{{ route('barang.create') }}" class="btn btn-primary px-4 py-3">
        <i class="fa-solid fa-plus me-2"></i> Tambah Barang
    </a>
</div>

{{-- RINGKASAN --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="enterprise-card p-3 h-100">
            <div class="d-flex justify-content-between">
                <span class="text-muted small">TOTAL JENIS BARANG</span>
                <i class="fa-solid fa-boxes-stacked text-primary"></i>
            </div>
            <h3 class="fw-bold text-white mt-3 mb-1">
                {{ number_format($totalBarang) }}
            </h3>
            <small class="text-muted">Barang terdaftar</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="enterprise-card p-3 h-100">
            <div class="d-flex justify-content-between">
                <span class="text-muted small">TOTAL UNIT STOK</span>
                <i class="fa-solid fa-cubes text-success"></i>
            </div>
            <h3 class="fw-bold text-white mt-3 mb-1">
                {{ number_format($totalStok) }}
            </h3>
            <small class="text-muted">Seluruh unit inventaris</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="enterprise-card p-3 h-100">
            <div class="d-flex justify-content-between">
                <span class="text-muted small">STOK MENIPIS</span>
                <i class="fa-solid fa-triangle-exclamation text-warning"></i>
            </div>
            <h3 class="fw-bold text-white mt-3 mb-1">
                {{ number_format($stokRendah) }}
            </h3>
            <small class="text-muted">Stok maksimal 5 unit</small>
        </div>
    </div>

</div>

{{-- TABEL INVENTARIS --}}
<div class="enterprise-card">

    <div class="p-4 border-bottom" style="border-color:var(--border)!important">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h5 class="text-white fw-bold mb-1">Master Inventory</h5>
                <small class="text-muted">Daftar lengkap persediaan perusahaan</small>
            </div>

            <span class="badge rounded-pill px-3 py-2"
                  style="background:#1c3760;color:#8dbbff">
                <i class="fa-solid fa-database me-1"></i>
                {{ $totalBarang }} Data
            </span>
        </div>

        <form method="GET" action="{{ route('barang.index') }}" class="row g-2 mt-3">

            <div class="col-lg-5">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari nama barang..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-lg-3">
                <select name="kategori_id" class="form-select">
                    <option value="">Semua Kategori</option>

                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>Stok Aman</option>
                    <option value="rendah" {{ request('status') == 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
                </select>
            </div>

            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-rotate"></i>
                </a>
            </div>

        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>NO</th>
                    <th>INFORMASI BARANG</th>
                    <th>KATEGORI</th>
                    <th>SUPPLIER</th>
                    <th>HARGA</th>
                    <th>STOK</th>
                    <th>STATUS</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>

            <tbody>

                @forelse($barangs as $barang)
                    <tr>
                        <td class="text-muted">
                            {{ $barangs->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-3">

                                @if($barang->foto)
                                    <img
                                        src="{{ asset('storage/' . $barang->foto) }}"
                                        alt="{{ $barang->nama_barang }}"
                                        class="product-photo">
                                @else
                                    <div class="product-placeholder">
                                        <i class="fa-solid fa-box"></i>
                                    </div>
                                @endif

                                <div>
                                    <div class="text-white fw-bold">
                                        {{ $barang->nama_barang }}
                                    </div>
                                    <small class="text-muted">
                                        ID: #{{ str_pad($barang->id, 4, '0', STR_PAD_LEFT) }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        <td class="text-muted">
                            {{ $barang->kategori->nama_kategori ?? 'Belum dikategorikan' }}
                        </td>

                        <td class="text-muted">
                            {{ $barang->supplier->nama_supplier ?? 'Belum ada supplier' }}
                        </td>

                        <td class="text-white fw-semibold">
                            Rp {{ number_format($barang->harga, 0, ',', '.') }}
                        </td>

                        <td class="text-white fw-bold">
                            {{ number_format($barang->stok) }}
                        </td>

                        <td>
                            @if($barang->stok == 0)
                                <span class="badge bg-danger bg-opacity-25 text-danger px-3 py-2">Habis</span>
                            @elseif($barang->stok <= 5)
                                <span class="badge bg-warning bg-opacity-25 text-warning px-3 py-2">Rendah</span>
                            @else
                                <span class="badge bg-success bg-opacity-25 text-success px-3 py-2">Aman</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('barang.edit', $barang->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('barang.destroy', $barang->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                            <h6 class="text-white">Data barang tidak ditemukan</h6>
                            <p class="text-muted mb-0">Coba ubah pencarian atau filter.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <div class="p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <small class="text-muted">
            Menampilkan {{ $barangs->firstItem() ?? 0 }}
            - {{ $barangs->lastItem() ?? 0 }}
            dari {{ $barangs->total() }} data
        </small>

        {{ $barangs->links() }}
    </div>

</div>

@endsection
