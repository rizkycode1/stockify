
@extends('layouts.app')

@section('title', 'Tambah Supplier')

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
        width: 38px;
        height: 38px;
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
</style>

<div class="supplier-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="small fw-bold text-info mb-2">
                PROCUREMENT MANAGEMENT
            </div>
            <h2 class="fw-bold text-white mb-2">Tambah Supplier</h2>
            <p class="mb-0" style="color:#a9bdd9">
                Daftarkan pemasok baru ke dalam sistem Stockify.
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
                    <i class="fa fa-building"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Informasi Pemasok</h5>
                    <small class="text-secondary">
                        Lengkapi informasi supplier di bawah ini.
                    </small>
                </div>
            </div>

            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">
                        Nama Supplier <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama_supplier"
                           class="form-control"
                           placeholder="Contoh: PT Sumber Makmur"
                           value="{{ old('nama_supplier') }}"
                           required>

                    @error('nama_supplier')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
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
                               placeholder="Contoh: 081234567890"
                               value="{{ old('telepon') }}">
                    </div>

                    @error('telepon')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Alamat Supplier</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="5"
                              placeholder="Masukkan alamat lengkap supplier...">{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <small class="text-danger mt-2 d-block">{{ $message }}</small>
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
                        Simpan Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="info-panel">
            <div class="field-icon">
                <i class="fa fa-circle-info"></i>
            </div>

            <h5 class="fw-bold text-white mb-2">Supplier Information</h5>
            <p class="small mb-3" style="color:#a9bdd9">
                Informasi penting mengenai pengelolaan pemasok.
            </p>

            <div class="info-item">
                <i class="fa fa-check-circle text-success me-2"></i>
                Nama supplier wajib diisi.
            </div>

            <div class="info-item">
                <i class="fa fa-phone text-info me-2"></i>
                Nomor telepon dapat dikosongkan.
            </div>

            <div class="info-item">
                <i class="fa fa-location-dot text-info me-2"></i>
                Alamat dapat ditambahkan kapan saja.
            </div>

            <div class="info-item">
                <i class="fa fa-box text-info me-2"></i>
                Supplier dapat dihubungkan dengan data barang.
            </div>

            <div class="mt-4 p-3 rounded-3"
                 style="background:#1a3455">
                <small class="text-info fw-bold">
                    <i class="fa fa-lightbulb me-1"></i> TIPS
                </small>
                <p class="small mb-0 mt-2" style="color:#c1d0e5">
                    Gunakan nama perusahaan yang jelas agar mudah ditemukan
                    ketika mengelola persediaan barang.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
