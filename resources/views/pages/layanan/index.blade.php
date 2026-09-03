@extends('layouts.app')
@section('title', 'Layanan Surat Digital')

@push('styles')
<style>
    .layanan-header {
        background: linear-gradient(135deg, var(--coklat-tua), var(--coklat-muda));
        color: white;
        padding-top: 120px; /* Jarak untuk navbar fixed */
        padding-bottom: 90px;
        text-align: center;
        margin-bottom: -50px;
    }
    .form-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 2;
    }
    @media (max-width: 767.98px) {
        .form-card {
            padding: 1.5rem 1rem; /* Padding lebih kecil di HP */
            margin-left: 10px;
            margin-right: 10px;
        }
        .layanan-header {
            padding-top: 100px;
            padding-bottom: 70px;
        }
        .layanan-header h1 {
            font-size: 1.8rem;
        }
    }
    .btn-submit {
        background: var(--gold);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%; /* Tombol penuh di HP */
    }
    @media (min-width: 768px) {
        .btn-submit {
            width: auto; /* Tombol menyesuaikan teks di PC */
        }
    }
    .btn-submit:hover {
        background: var(--coklat-tua);
    }
    /* Box peringatan KTP */
    .ktp-warning {
        background: #fff8e1;
        border: 1px solid #f9c846;
        border-radius: 8px;
        padding: 0.6rem 0.9rem;
        font-size: 0.85rem;
        color: #7a5800;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 6px;
    }
    .ktp-warning i { margin-top: 2px; flex-shrink: 0; }
</style>
@endpush

@section('content')

<div class="layanan-header">
    <div class="container">
        <h1 class="font-serif fw-bold mb-3">E-Layanan Desa</h1>
        <p class="lead mb-0">Ajukan permohonan surat secara online dengan mudah dan cepat tanpa harus ke balai desa.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <h4 class="font-serif fw-bold mb-4 text-center" style="color: var(--coklat-tua);">Formulir Pengajuan Surat</h4>
                
                <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" id="formLayanan">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Layanan Surat <span class="text-danger">*</span></label>
                        <select name="jenis_layanan" id="jenisLayananSelect" class="form-select @error('jenis_layanan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Pengantar Pembuatan KK Baru" {{ old('jenis_layanan') == 'Pengantar Pembuatan KK Baru' ? 'selected' : '' }}>Pengantar Pembuatan KK Baru</option>
                            <option value="Surat Keterangan Buka Lahan" {{ old('jenis_layanan') == 'Surat Keterangan Buka Lahan' ? 'selected' : '' }}>Surat Keterangan Buka Lahan</option>
                            <option value="Surat Keterangan Domisili" {{ old('jenis_layanan') == 'Surat Keterangan Domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                            <option value="Surat Keterangan Usaha (SKU)" {{ old('jenis_layanan') == 'Surat Keterangan Usaha (SKU)' ? 'selected' : '' }}>Surat Keterangan Usaha (SKU)</option>
                            <option value="Surat Keterangan Tidak Mampu (SKTM)" {{ old('jenis_layanan') == 'Surat Keterangan Tidak Mampu (SKTM)' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu (SKTM)</option>
                            <option value="Lainnya" {{ old('jenis_layanan') == 'Lainnya' ? 'selected' : '' }}>Lainnya...</option>
                        </select>
                        @error('jenis_layanan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Field Lainnya: muncul & wajib hanya jika pilih "Lainnya" --}}
                    <div class="mb-3" id="fieldLainnya" style="display: none;">
                        <label class="form-label fw-semibold">Tuliskan Jenis Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_layanan_lainnya" id="inputLainnya"
                            class="form-control @error('jenis_layanan_lainnya') is-invalid @enderror"
                            value="{{ old('jenis_layanan_lainnya') }}"
                            placeholder="Contoh: Surat Keterangan Kelahiran, Surat Pengantar SKCK, dll."
                            maxlength="150">
                        <div class="form-text text-muted">Wajib diisi jika Anda memilih "Lainnya".</div>
                        @error('jenis_layanan_lainnya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" minlength="16" maxlength="16" pattern="\d{16}" title="NIK harus berupa 16 digit angka" required placeholder="16 Digit NIK">
                            @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required placeholder="Sesuai KTP">
                            @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="no_whatsapp" class="form-control @error('no_whatsapp') is-invalid @enderror" value="{{ old('no_whatsapp') }}" minlength="12" maxlength="12" pattern="\d{12}" title="Nomor WhatsApp harus berupa 12 digit angka" required placeholder="Contoh: 081234567890">
                        <div class="form-text">Nomor yang bisa dihubungi untuk konfirmasi surat.</div>
                        @error('no_whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keperluan / Keterangan Tambahan (Opsional)</label>
                        <textarea name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" rows="3" placeholder="Tuliskan jika ada catatan khusus">{{ old('keperluan') }}</textarea>
                        @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Unggah Foto KTP <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="file_lampiran" id="fileKtp"
                            class="form-control @error('file_lampiran') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg"
                            required>
                        <div class="ktp-warning mt-2">
                            <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                            <span>
                                <strong>Wajib:</strong> Foto KTP harus <strong>jernih</strong>, <strong>jelas terbaca</strong>, dan <strong>tidak rusak/terpotong</strong>.
                                Pengajuan dengan foto KTP buram atau tidak terbaca akan ditolak.<br>
                                <span class="text-muted">Format: JPG / PNG &bull; Maks. 2 MB</span>
                            </span>
                        </div>
                        @error('file_lampiran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn-submit"><i class="bi bi-send-fill me-2"></i> Kirim Permohonan</button>
                    </div>
                </form>
            </div>
            
            <div class="text-center mb-5">
                <p>Sudah pernah mengajukan surat?</p>
                <a href="{{ route('layanan.cek') }}" class="btn btn-outline-dark rounded-pill px-4">Cek Status Surat Anda di Sini</a>
            </div>

            @php
                $alamat = \App\Models\Setting::where('key', 'alamat_desa')->value('value') ?? \App\Models\Setting::where('key', 'alamat')->value('value');
                $telepon = \App\Models\Setting::where('key', 'telepon_desa')->value('value') ?? \App\Models\Setting::where('key', 'telepon')->value('value');
                $email = \App\Models\Setting::where('key', 'email_desa')->value('value') ?? \App\Models\Setting::where('key', 'email')->value('value');
            @endphp
            
            <div class="card border-0 bg-light rounded-4">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold mb-3">Butuh Bantuan Pelayanan?</h6>
                    <div class="d-flex flex-column flex-md-row justify-content-center gap-3 gap-md-5 text-muted small">
                        @if($telepon) <div><i class="bi bi-telephone-fill me-2 text-primary"></i>{{ $telepon }}</div> @endif
                        @if($email) <div><i class="bi bi-envelope-fill me-2 text-primary"></i>{{ $email }}</div> @endif
                    </div>
                    @if($alamat)
                        <div class="text-muted small mt-2"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>{{ $alamat }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const jenisSelect   = document.getElementById('jenisLayananSelect');
    const fieldLainnya  = document.getElementById('fieldLainnya');
    const inputLainnya  = document.getElementById('inputLainnya');

    function toggleLainnya() {
        if (jenisSelect.value === 'Lainnya') {
            fieldLainnya.style.display = 'block';
            inputLainnya.setAttribute('required', 'required');
        } else {
            fieldLainnya.style.display = 'none';
            inputLainnya.removeAttribute('required');
            inputLainnya.value = '';
        }
    }

    jenisSelect.addEventListener('change', toggleLainnya);

    // Jalankan saat halaman load (untuk kasus old input setelah validasi error)
    toggleLainnya();
</script>
@endpush
