
@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="text-primary fw-bold small mb-2">
                <i class="fa-solid fa-arrow-up-from-bracket me-1"></i>
                INVENTORY CONTROL
            </div>
            <h3 class="fw-bold mb-1">Barang Keluar</h3>
            <p class="text-muted mb-0">Catat pengeluaran barang dari gudang Stockify.</p>
        </div>

        <a href="{{ route('barang-keluar.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0">
            <strong>Periksa kembali data:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm"
                 style="background:#151d2b; border-radius:16px; color:#fff;">

                <div class="card-body p-4">
                    <h5 class="fw-bold mb-1">Informasi Transaksi</h5>
                    <p class="text-secondary small mb-4">
                        Lengkapi informasi barang yang akan dikeluarkan.
                    </p>

                    @if ($barangs->isNotEmpty())
                        <form action="{{ route('barang-keluar.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Pilih Barang</label>
                                <select name="barang_id" id="barang_id"
                                        class="form-select bg-dark text-white border-secondary"
                                        required>
                                    <option value="">-- Pilih barang --</option>

                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                                data-stok="{{ $barang->stok }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }}
                                            — Stok: {{ $barang->stok }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jumlah Keluar</label>
                                    <input type="number" name="jumlah" id="jumlah"
                                           class="form-control bg-dark text-white border-secondary"
                                           min="1" value="{{ old('jumlah', 1) }}" required>
                                    <small class="text-secondary" id="batasStok">
                                        Pilih barang untuk melihat stok tersedia.
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Keluar</label>
                                    <input type="date" name="tanggal"
                                           class="form-control bg-dark text-white border-secondary"
                                           value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Tujuan / Penerima</label>
                                <input type="text" name="tujuan"
                                       class="form-control bg-dark text-white border-secondary"
                                       placeholder="Contoh: Bagian Produksi"
                                       value="{{ old('tujuan') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea name="keterangan" rows="4"
                                          class="form-control bg-dark text-white border-secondary"
                                          placeholder="Tambahkan keterangan transaksi...">{{ old('keterangan') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('barang-keluar.index') }}"
                                   class="btn btn-outline-secondary">
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>
                                    Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="fa-solid fa-box-open fa-3x text-secondary mb-3"></i>
                            <h5>Belum Ada Stok Tersedia</h5>
                            <p class="text-secondary">
                                Semua barang memiliki stok kosong. Tambahkan stok masuk terlebih dahulu.
                            </p>
                            <a href="{{ route('barang-masuk.create') }}"
                               class="btn btn-primary">
                                Tambah Barang Masuk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3"
                 style="background:#151d2b; border-radius:16px; color:#fff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 p-3"
                             style="background:rgba(13,110,253,.15);">
                            <i class="fa-solid fa-boxes-stacked text-primary fa-xl"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Stok Tersedia</div>
                            <h4 class="fw-bold mb-0" id="stokTersedia">-</h4>
                        </div>
                    </div>
                    <p class="text-secondary small mb-0">
                        Stok akan otomatis berkurang setelah transaksi berhasil disimpan.
                    </p>
                </div>
            </div>

            <div class="card border-0 shadow-sm"
                 style="background:#151d2b; border-radius:16px; color:#fff;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fa-solid fa-circle-info text-info me-2"></i>
                        Informasi
                    </h6>
                    <ul class="text-secondary small ps-3 mb-0">
                        <li class="mb-2">Jumlah keluar minimal 1 barang.</li>
                        <li class="mb-2">Jumlah tidak boleh melebihi stok tersedia.</li>
                        <li class="mb-2">Stok otomatis berkurang setelah disimpan.</li>
                        <li>Transaksi tercatat dalam riwayat barang keluar.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const pilihanBarang = document.getElementById('barang_id');
    const inputJumlah = document.getElementById('jumlah');
    const stokTersedia = document.getElementById('stokTersedia');
    const batasStok = document.getElementById('batasStok');

    function updateStok() {
        const option = pilihanBarang.options[pilihanBarang.selectedIndex];
        const stok = option ? option.dataset.stok : '';

        if (stok !== '') {
            stokTersedia.textContent = stok + ' unit';
            inputJumlah.max = stok;
            batasStok.textContent = 'Maksimal ' + stok + ' unit tersedia.';

            if (parseInt(inputJumlah.value || 0) > parseInt(stok)) {
                inputJumlah.value = stok;
            }
        } else {
            stokTersedia.textContent = '-';
            inputJumlah.removeAttribute('max');
            batasStok.textContent = 'Pilih barang untuk melihat stok tersedia.';
        }
    }

    pilihanBarang.addEventListener('change', updateStok);
    updateStok();
</script>
@endsection
