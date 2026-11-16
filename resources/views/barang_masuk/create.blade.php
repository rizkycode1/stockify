
@extends('layouts.app')

@section('title', 'Catat Barang Masuk')

@section('content')
<style>
    .inbound-header {
        background: linear-gradient(120deg, #14294b, #10203a 65%, #17345b);
        border: 1px solid #29466f;
        border-radius: 18px;
        padding: 27px;
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

    .form-control, .form-select {
        background-color: #0c1424 !important;
        border: 1px solid #293a55 !important;
        color: #edf3ff !important;
        border-radius: 10px !important;
        padding: 12px 14px;
    }

    .form-select option {
        background: #111c30;
        color: #edf3ff;
    }

    .form-control:focus, .form-select:focus {
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

    .stock-preview {
        background: #0c1424;
        border: 1px solid #293a55;
        border-radius: 13px;
        padding: 17px;
        margin-top: 18px;
    }

    .stock-number {
        color: #65a3ff;
        font-size: 25px;
        font-weight: 800;
    }
</style>

<div class="inbound-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <div class="small fw-bold text-info mb-2">
                <i class="fa fa-box-open me-1"></i> INVENTORY OPERATIONS
            </div>
            <h2 class="fw-bold text-white mb-2">Catat Barang Masuk</h2>
            <p class="mb-0" style="color:#a9bdd9">
                Tambahkan persediaan baru ke dalam inventaris gudang.
            </p>
        </div>

        <a href="{{ route('barang-masuk.index') }}"
           class="btn btn-outline-light">
            <i class="fa fa-arrow-left me-2"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="form-panel">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="field-icon mb-0">
                    <i class="fa fa-truck-ramp-box"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Informasi Penerimaan</h5>
                    <small class="text-secondary">
                        Lengkapi data barang yang diterima.
                    </small>
                </div>
            </div>

            <form action="{{ route('barang-masuk.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label">
                        Pilih Barang <span class="text-danger">*</span>
                    </label>

                    <select name="barang_id" id="barangSelect"
                            class="form-select" required>
                        <option value="">-- Pilih Barang --</option>

                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}"
                                    data-stok="{{ $barang->stok }}"
                                    @selected(old('barang_id') == $barang->id)>
                                {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                            </option>
                        @endforeach
                    </select>

                    @error('barang_id')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror

                    <div class="stock-preview" id="stockPreview" style="display:none">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-secondary d-block">STOK SAAT INI</small>
                                <span class="stock-number" id="currentStock">0</span>
                                <small class="text-secondary"> unit</small>
                            </div>

                            <div class="text-end">
                                <small class="text-secondary d-block">ESTIMASI STOK AKHIR</small>
                                <span class="stock-number" id="finalStock">0</span>
                                <small class="text-secondary"> unit</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Jumlah Barang Masuk <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           name="jumlah"
                           id="jumlahMasuk"
                           class="form-control"
                           min="1"
                           placeholder="Masukkan jumlah barang"
                           required
                           value="{{ old('jumlah') }}">

                    @error('jumlah')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Tanggal Penerimaan <span class="text-danger">*</span>
                    </label>

                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           required
                           value="{{ old('tanggal', date('Y-m-d')) }}">

                    @error('tanggal')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Keterangan</label>

                    <textarea name="keterangan"
                              class="form-control"
                              rows="4"
                              placeholder="Contoh: Pembelian dari supplier atau penerimaan stok baru...">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <small class="text-danger mt-2 d-block">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3"
                     style="border-top:1px solid #24334d">
                    <a href="{{ route('barang-masuk.index') }}"
                       class="btn btn-outline-secondary px-4">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa fa-floppy-disk me-2"></i>
                        Simpan Transaksi
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

            <h5 class="fw-bold text-white mb-2">Inbound Information</h5>
            <p class="small mb-3" style="color:#a9bdd9">
                Panduan pencatatan penerimaan barang.
            </p>

            <div class="info-item">
                <i class="fa fa-box text-info me-2"></i>
                Pilih barang yang akan ditambahkan stoknya.
            </div>

            <div class="info-item">
                <i class="fa fa-plus-circle text-success me-2"></i>
                Masukkan jumlah unit yang diterima.
            </div>

            <div class="info-item">
                <i class="fa fa-calendar text-info me-2"></i>
                Catat tanggal penerimaan barang.
            </div>

            <div class="info-item">
                <i class="fa fa-note-sticky text-info me-2"></i>
                Tambahkan keterangan jika diperlukan.
            </div>

            <div class="mt-4 p-3 rounded-3"
                 style="background:#1a3455">
                <small class="text-info fw-bold">
                    <i class="fa fa-lightbulb me-1"></i> PERHATIAN
                </small>
                <p class="small mb-0 mt-2" style="color:#c1d0e5">
                    Setelah transaksi disimpan, jumlah stok barang akan
                    bertambah secara otomatis melalui sistem.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const barangSelect = document.getElementById('barangSelect');
    const jumlahMasuk = document.getElementById('jumlahMasuk');
    const stockPreview = document.getElementById('stockPreview');
    const currentStock = document.getElementById('currentStock');
    const finalStock = document.getElementById('finalStock');

    function updateStockPreview() {
        const selected = barangSelect.options[barangSelect.selectedIndex];

        if (!selected || !selected.value) {
            stockPreview.style.display = 'none';
            return;
        }

        const stok = parseInt(selected.dataset.stok) || 0;
        const jumlah = parseInt(jumlahMasuk.value) || 0;

        currentStock.textContent = stok.toLocaleString('id-ID');
        finalStock.textContent = (stok + jumlah).toLocaleString('id-ID');

        stockPreview.style.display = 'block';
    }

    barangSelect.addEventListener('change', updateStockPreview);
    jumlahMasuk.addEventListener('input', updateStockPreview);

    updateStockPreview();
</script>
@endsection
