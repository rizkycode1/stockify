
@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<style>
    .create-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:25px;
    }

    .create-title {
        font-size:25px;
        font-weight:800;
        color:#edf3ff;
        margin:0;
    }

    .create-subtitle {
        color:#8b9bb5;
        font-size:13px;
        margin-top:7px;
    }

    .form-card {
        background:#111c30;
        border:1px solid #24334d;
        border-radius:17px;
        padding:25px;
        margin-bottom:20px;
    }

    .form-section-title {
        color:#edf3ff;
        font-size:16px;
        font-weight:700;
        margin-bottom:5px;
    }

    .form-section-desc {
        color:#8b9bb5;
        font-size:12px;
        margin-bottom:23px;
    }

    .form-label {
        color:#cbd7eb;
        font-size:13px;
        font-weight:600;
        margin-bottom:9px;
    }

    .form-control, .form-select {
        background:#0b1425 !important;
        border:1px solid #2a3b58 !important;
        color:#edf3ff !important;
        border-radius:10px !important;
        padding:12px 14px !important;
        min-height:47px;
    }

    .form-control:focus, .form-select:focus {
        border-color:#3984ff !important;
        box-shadow:0 0 0 3px rgba(57,132,255,.12) !important;
    }

    .form-control::placeholder {
        color:#667995;
    }

    .form-select option {
        background:#111c30;
        color:white;
    }

    .input-help {
        color:#71839f;
        font-size:11px;
        margin-top:7px;
    }

    .field-icon {
        color:#65a3ff;
        margin-right:7px;
    }

    .info-panel {
        background:linear-gradient(135deg,#142b50,#101d34);
        border:1px solid #294c7d;
        border-radius:15px;
        padding:20px;
        height:100%;
    }

    .info-panel h6 {
        color:#edf3ff;
        font-weight:700;
    }

    .info-panel p {
        color:#9eb0ca;
        font-size:12px;
        line-height:1.7;
        margin-bottom:0;
    }

    .info-icon {
        width:42px;
        height:42px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#1d4175;
        color:#78b1ff;
        border-radius:12px;
        margin-bottom:15px;
        font-size:18px;
    }

    .btn-save {
        background:#3984ff;
        color:white;
        border:0;
        border-radius:10px;
        padding:12px 22px;
        font-weight:700;
    }

    .btn-save:hover {
        background:#246bd8;
        color:white;
    }

    .btn-back {
        background:#1b2940;
        color:#cbd7eb;
        border:1px solid #30415e;
        border-radius:10px;
        padding:12px 20px;
        text-decoration:none;
        font-weight:600;
    }

    .btn-back:hover {
        background:#263955;
        color:white;
    }

    .required-mark {
        color:#ff647c;
    }

    @media(max-width:768px) {
        .form-card { padding:18px; }
        .create-title { font-size:21px; }
    }
</style>

<div class="create-header">
    <div>
        <div class="text-uppercase small mb-2" style="color:#65a3ff;letter-spacing:2px;font-weight:700;">
            INVENTORY / MASTER DATA
        </div>

        <h3 class="create-title">Tambah Barang Baru</h3>

        <p class="create-subtitle">
            Daftarkan barang baru ke dalam sistem inventaris Stockify.
        </p>
    </div>

    <a href="{{ route('barang.index') }}" class="btn-back">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data yang dimasukkan.</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('barang.store') }}" method="POST">
    @csrf

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="form-card">
                <div class="form-section-title">
                    <i class="fas fa-box-open field-icon"></i>
                    Informasi Barang
                </div>

                <div class="form-section-desc">
                    Masukkan identitas dan informasi utama barang.
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Nama Barang <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           placeholder="Contoh: Laptop ASUS Vivobook"
                           value="{{ old('nama_barang') }}"
                           required>

                    <div class="input-help">
                        Gunakan nama barang yang jelas dan mudah dikenali.
                    </div>

                    @error('nama_barang')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-layer-group field-icon"></i>
                            Kategori
                        </label>

                        <select name="kategori_id" class="form-select">
                            <option value="">Tanpa Kategori</option>

                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-help">Opsional</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="fas fa-truck field-icon"></i>
                            Supplier
                        </label>

                        <select name="supplier_id" class="form-select">
                            <option value="">Tanpa Supplier</option>

                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-help">Opsional</div>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-section-title">
                    <i class="fas fa-coins field-icon"></i>
                    Informasi Persediaan
                </div>

                <div class="form-section-desc">
                    Tentukan harga dan jumlah stok awal barang.
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            Harga Barang (Rp) <span class="required-mark">*</span>
                        </label>

                        <input type="number"
                               name="harga"
                               class="form-control"
                               placeholder="Contoh: 2500000"
                               value="{{ old('harga') }}"
                               min="0"
                               required>

                        <div class="input-help">
                            Masukkan harga dalam rupiah.
                        </div>

                        @error('harga')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Stok Awal <span class="required-mark">*</span>
                        </label>

                        <input type="number"
                               name="stok"
                               class="form-control"
                               placeholder="Contoh: 10"
                               value="{{ old('stok', 0) }}"
                               min="0"
                               required>

                        <div class="input-help">
                            Jumlah barang yang tersedia saat didaftarkan.
                        </div>

                        @error('stok')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 flex-wrap mb-4">
                <a href="{{ route('barang.index') }}" class="btn-back">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>
                    Simpan Barang
                </button>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="info-panel">
                <div class="info-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>

                <h6>Panduan Pengisian</h6>

                <p>
                    Lengkapi informasi barang dengan benar agar data inventaris
                    mudah dikelola dan dipantau.
                </p>

                <hr style="border-color:#345174;margin:20px 0;">

                <div class="mb-3">
                    <div class="fw-bold text-white small mb-1">
                        <i class="fas fa-check-circle me-2" style="color:#22c58b;"></i>
                        Nama Barang
                    </div>
                    <p>Isi dengan nama barang yang spesifik.</p>
                </div>

                <div class="mb-3">
                    <div class="fw-bold text-white small mb-1">
                        <i class="fas fa-check-circle me-2" style="color:#22c58b;"></i>
                        Kategori & Supplier
                    </div>
                    <p>Keduanya bersifat opsional dan boleh dikosongkan.</p>
                </div>

                <div class="mb-3">
                    <div class="fw-bold text-white small mb-1">
                        <i class="fas fa-check-circle me-2" style="color:#22c58b;"></i>
                        Harga Barang
                    </div>
                    <p>Masukkan harga barang dalam satuan rupiah.</p>
                </div>

                <div>
                    <div class="fw-bold text-white small mb-1">
                        <i class="fas fa-check-circle me-2" style="color:#22c58b;"></i>
                        Stok Awal
                    </div>
                    <p>Stok bisa dimulai dari angka 0.</p>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection
