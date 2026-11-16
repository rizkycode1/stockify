
@extends('layouts.app')

@section('title', 'Edit Kategori')

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

    .form-control {
        background:#0b1425 !important;
        border:1px solid #2a3b58 !important;
        color:#edf3ff !important;
        border-radius:10px !important;
        padding:12px 14px !important;
    }

    .form-control:focus {
        border-color:#3984ff !important;
        box-shadow:0 0 0 3px rgba(57,132,255,.12) !important;
    }

    .form-control::placeholder {
        color:#667995;
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
        padding:22px;
        height:100%;
    }

    .info-icon {
        width:43px;
        height:43px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#1d4175;
        color:#78b1ff;
        border-radius:12px;
        margin-bottom:16px;
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

    .info-label {
        color:#8b9bb5;
        font-size:11px;
        margin-bottom:5px;
    }

    .info-value {
        color:#edf3ff;
        font-size:13px;
        font-weight:700;
        overflow-wrap:anywhere;
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
        .category-title { font-size:21px; }
    }
</style>

<div class="category-header">
    <div>
        <div class="text-uppercase small mb-2"
             style="color:#65a3ff;letter-spacing:2px;font-weight:700;">
            INVENTORY / MASTER DATA
        </div>

        <h3 class="category-title">Edit Kategori</h3>

        <p class="category-subtitle">
            Perbarui informasi kategori barang dalam sistem Stockify.
        </p>
    </div>

    <a href="{{ route('kategori.index') }}" class="btn-back">
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

<form action="{{ route('kategori.update', $kategori->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="edit-card">
                <div class="section-title">
                    <i class="fas fa-folder-open field-icon"></i>
                    Informasi Kategori
                </div>

                <div class="section-desc">
                    Perbarui nama dan deskripsi kategori.
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-tag field-icon"></i>
                        Nama Kategori <span class="required-mark">*</span>
                    </label>

                    <input type="text"
                           name="nama_kategori"
                           class="form-control"
                           placeholder="Masukkan nama kategori"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           required>

                    <div class="input-help">
                        Gunakan nama kategori yang jelas dan mudah dikenali.
                    </div>

                    @error('nama_kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="form-label">
                        <i class="fas fa-align-left field-icon"></i>
                        Deskripsi Kategori
                    </label>

                    <textarea name="deskripsi"
                              class="form-control"
                              rows="5"
                              placeholder="Masukkan deskripsi kategori...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>

                    <div class="input-help">
                        Deskripsi bersifat opsional.
                    </div>

                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 flex-wrap mb-4">
                <a href="{{ route('kategori.index') }}" class="btn-back">
                    Batal
                </a>

                <button type="submit" class="btn-update">
                    <i class="fas fa-save me-2"></i>
                    Update Kategori
                </button>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="info-panel">

                <div class="info-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                <h6>Detail Kategori Saat Ini</h6>

                <p>
                    Informasi kategori yang sedang kamu perbarui.
                </p>

                <hr style="border-color:#345174;">

                <div class="mb-3">
                    <div class="info-label">ID Kategori</div>
                    <div class="info-value">#{{ $kategori->id }}</div>
                </div>

                <div class="mb-3">
                    <div class="info-label">Nama Kategori</div>
                    <div class="info-value">
                        {{ $kategori->nama_kategori }}
                    </div>
                </div>

                <div class="mb-3">
                    <div class="info-label">Deskripsi</div>
                    <div class="info-value">
                        {{ $kategori->deskripsi ?: 'Belum ada deskripsi' }}
                    </div>
                </div>

                <hr style="border-color:#345174;">

                <p class="mb-0">
                    <i class="fas fa-shield-alt me-2"
                       style="color:#22c58b;"></i>
                    Pastikan perubahan sudah benar sebelum menyimpan.
                </p>

            </div>
        </div>

    </div>
</form>

@endsection
