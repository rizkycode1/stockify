
@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')

<style>
    .edit-header {
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:15px;
        margin-bottom:25px;
    }

    .edit-title {
        color:#edf3ff;
        font-size:25px;
        font-weight:800;
        margin:0;
    }

    .edit-subtitle {
        color:#8b9bb5;
        font-size:13px;
        margin-top:7px;
    }

    .edit-card {
        background:#111c30;
        border:1px solid #24334d;
        border-radius:17px;
        padding:25px;
        margin-bottom:20px;
    }

    .section-title {
        color:#edf3ff;
        font-size:16px;
        font-weight:700;
        margin-bottom:5px;
    }

    .section-desc {
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

    .field-icon {
        color:#65a3ff;
        margin-right:7px;
    }

    .input-help {
        color:#71839f;
        font-size:11px;
        margin-top:7px;
    }

    .info-panel {
        background:linear-gradient(135deg,#142b50,#101d34);
        border:1px solid #294c7d;
        border-radius:15px;
        padding:20px;
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

    .info-panel h6 {
        color:#edf3ff;
        font-weight:700;
    }

    .info-panel p {
        color:#9eb0ca;
        font-size:12px;
        line-height:1.7;
    }

    .info-value {
        color:#edf3ff;
        font-size:13px;
        font-weight:700;
    }

    .btn-update {
        background:#3984ff;
        color:white;
        border:0;
        border-radius:10px;
        padding:12px 22px;
        font-weight:700;
    }

    .btn-update:hover {
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
        .edit-card { padding:18px; }
        .edit-title { font-size:21px; }
    }
</style>

<div class="edit-header">
    <div>
        <div class="text-uppercase small mb-2"
             style="color:#65a3ff;letter-spacing:2px;font-weight:700;">
            INVENTORY / MASTER DATA
        </div>

        <h3 class="edit-title">Edit Informasi Barang</h3>

        <p class="edit-subtitle">
            Perbarui informasi dan persediaan barang dalam sistem Stockify.
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

<form action="{{ route('barang.update', $barang->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="edit-card">
                <div class="section-title">
                    <i class="fas fa-box-open field-icon"></i>
                    Informasi Barang
                </div>

                <div class="section-desc">
                    Perbarui identitas barang yang tersimpan.
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Nama Barang <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang', $barang->nama_barang) }}"
                           placeholder="Masukkan nama barang"
                           required>

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
                                    {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-help">Kategori bersifat opsional.</div>
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
                                    {{ old('supplier_id', $barang->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>

                        <div class="input-help">Supplier bersifat opsional.</div>
                    </div>
                </div>
            </div>

            <div class="edit-card">
                <div class="section-title">
                    <i class="fas fa-coins field-icon"></i>
                    Informasi Persediaan
                </div>

                <div class="section-desc">
                    Perbarui harga dan jumlah stok barang.
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            Harga Barang (Rp) <span class="required-mark">*</span>
                        </label>

                        <input type="number"
                               name="harga"
                               class="form-control"
                               value="{{ old('harga', $barang->harga) }}"
                               min="0"
                               required>

                        @error('harga')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Stok <span class="required-mark">*</span>
                        </label>

                        <input type="number"
                               name="stok"
                               class="form-control"
                               value="{{ old('stok', $barang->stok) }}"
                               min="0"
                               required>

                        @error('stok')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        <div class="input-help">
                            Pastikan jumlah stok sesuai kondisi persediaan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 flex-wrap mb-4">
                <a href="{{ route('barang.index') }}" class="btn-back">
                    Batal
                </a>

                <button type="submit" class="btn-update">
                    <i class="fas fa-save me-2"></i>
                    Update Barang
                </button>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="info-panel">
                <div class="info-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                <h6>Detail Data Saat Ini</h6>

                <p>
                    Informasi barang yang sedang kamu perbarui.
                </p>

                <hr style="border-color:#345174;">

                <div class="mb-3">
                    <div class="small" style="color:#8b9bb5;">ID Barang</div>
                    <div class="info-value">#{{ $barang->id }}</div>
                </div>

                <div class="mb-3">
                    <div class="small" style="color:#8b9bb5;">Nama Barang</div>
                    <div class="info-value">{{ $barang->nama_barang }}</div>
                </div>

                <div class="mb-3">
                    <div class="small" style="color:#8b9bb5;">Stok Saat Ini</div>
                    <div class="info-value">{{ number_format($barang->stok) }} Unit</div>
                </div>

                <div class="mb-3">
                    <div class="small" style="color:#8b9bb5;">Harga Saat Ini</div>
                    <div class="info-value">
                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                    </div>
                </div>

                <hr style="border-color:#345174;">

                <p class="mb-0">
                    <i class="fas fa-shield-alt me-2" style="color:#22c58b;"></i>
                    Pastikan perubahan data sudah benar sebelum menekan tombol Update Barang.
                </p>
            </div>
        </div>

    </div>
</form>

@endsection
