
@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<style>
    .supplier-header {
        background: linear-gradient(120deg, #14294b, #10203a);
        border: 1px solid #29466f;
        border-radius: 17px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .form-panel {
        background: #111c30;
        border: 1px solid #24334d;
        border-radius: 17px;
        padding: 27px;
    }

    .info-panel {
        background: linear-gradient(145deg, #142a49, #101c30);
        border: 1px solid #29466f;
        border-radius: 17px;
        padding: 24px;
        height: 100%;
    }

    .form-control {
        background: #0c1424 !important;
        border: 1px solid #293a55 !important;
        color: #edf3ff !important;
        border-radius: 10px !important;
        padding: 12px 14px;
    }

    .form-control:focus {
        border-color: #3984ff !important;
        box-shadow: 0 0 0 3px rgba(57,132,255,.13) !important;
    }

    .form-control::placeholder {
        color: #71839e;
    }

    .form-label {
        color: #dce7f8;
        font-weight: 600;
        font-size: 13px;
        margin-bottom: 9px;
    }

    .field-icon {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 11px;
        background: #1c3c66;
        color: #80b5ff;
        margin-bottom: 13px;
    }

    .info-item {
        border-bottom: 1px solid #29466f;
        padding: 15px 0;
        color: #c1d0e5;
        font-size: 13px;
    }

    .info-item:last-child {
        border-bottom: 0;
    }

    .supplier-id {
        background: #1a3455;
        border: 1px solid #31527b;
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
    }
</style>

<div class="supplier-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="small fw-bold text-info mb-2">
                PROCUREMENT MANAGEMENT
            </div>
            <h2 class="fw-bold text-white mb-2">Edit Supplier</h2>
            <p class="mb-0" style="color:#a9bdd9">
                Perbarui informasi pemasok yang sudah terdaftar.
            </p>
        </div>

        <a href="{{ route('supplier.index') }}" class="btn btn-outline-light">
            <i class="fa fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-panel">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="field-icon mb-0">
                    <i class="fa fa-pen-to-square"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Perbarui Informasi</h5>
                    <small class="text-secondary">
                        Ubah informasi supplier sesuai data terbaru.
                    </small>
                </div>
            </div>

            <form action="{{ route('supplier.update', $supplier->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">
                        Nama Supplier <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="nama_supplier"
                           class="form-control"
                           placeholder="Masukkan nama supplier"
                           value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                           required>

                    @error('nama_supplier')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Nomor Telepon</label>

                    <div class="input-group">
                        <span class="input-group-text"
                              style="background:#1a2940;border-color:#293a55;color:#80b5ff">
                            <i class="fa fa-phone"></i>
                        </span>

                        <input type="text"
                               name="telepon"
                               class="form-control"
                               placeholder="Masukkan nomor telepon"
                               value="{{ old('telepon', $supplier->telepon) }}">
                    </div>

                    @error('telepon')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Alamat Supplier</label>

                    <textarea name="alamat"
                              class="form-control"
                              rows="5"
                              placeholder="Masukkan alamat lengkap supplier">{{ old('alamat', $supplier->alamat) }}</textarea>

                    @error('alamat')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3"
                     style="border-top:1px solid #24334d">
                    <a href="{{ route('supplier.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa fa-floppy-disk me-2"></i>
                        Update Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="info-panel">
            <div class="field-icon">
                <i class="fa fa-building"></i>
            </div>

            <h5 class="fw-bold text-white mb-2">Supplier Details</h5>
            <p class="small mb-3" style="color:#a9bdd9">
                Informasi supplier yang sedang kamu edit.
            </p>

            <div class="info-item">
                <small class="d-block text-secondary mb-1">ID SUPPLIER</small>
                <strong class="text-white">#{{ $supplier->id }}</strong>
            </div>

            <div class="info-item">
                <small class="d-block text-secondary mb-1">NAMA SUPPLIER</small>
                <strong class="text-white">{{ $supplier->nama_supplier }}</strong>
            </div>

            <div class="info-item">
                <small class="d-block text-secondary mb-1">NOMOR TELEPON</small>
                <strong class="text-white">
                    {{ $supplier->telepon ?: 'Belum tersedia' }}
                </strong>
            </div>

            <div class="info-item">
                <small class="d-block text-secondary mb-1">ALAMAT</small>
                <strong class="text-white">
                    {{ $supplier->alamat ?: 'Belum tersedia' }}
                </strong>
            </div>

            <div class="supplier-id">
                <small class="text-info fw-bold">
                    <i class="fa fa-shield-halved me-1"></i> DATA MANAGEMENT
                </small>
                <p class="small mb-0 mt-2" style="color:#c1d0e5">
                    Pastikan informasi yang diperbarui sudah benar sebelum
                    menyimpan perubahan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
