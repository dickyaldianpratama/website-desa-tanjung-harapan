@extends('layouts.admin')
@section('title', 'Pengaturan Website')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #f1f5f9;
    }
    .header-icon {
        width: 48px;
        height: 48px;
        background: rgba(201, 150, 58, 0.1);
        color: #c9963a;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .setting-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    .setting-card-header {
        background: #f8fafc;
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .setting-card-body {
        padding: 2rem;
    }
</style>

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="bi bi-gear-fill"></i>
        </div>
        <div>
            <h4 class="fw-bold text-dark mb-1">Pengaturan Website</h4>
            <p class="text-muted small mb-0">Atur profil, kontak, dan tautan sosial media desa.</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.setting.update') }}" method="POST">
    @csrf
    
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-7">
            <!-- Profil Desa -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-bank text-primary"></i> Identitas Desa
                </div>
                <div class="setting-card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Nama Desa <span class="text-danger">*</span></label>
                            <input type="text" name="nama_desa" class="form-control" value="{{ $settings['nama_desa'] ?? 'Desa Sukamaju' }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Nama Kecamatan</label>
                            <input type="text" name="nama_kecamatan" class="form-control" value="{{ $settings['nama_kecamatan'] ?? 'Kampar Kiri' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Nama Kabupaten</label>
                            <input type="text" name="nama_kabupaten" class="form-control" value="{{ $settings['nama_kabupaten'] ?? 'Kampar' }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap Kantor Desa</label>
                        <textarea name="alamat_desa" class="form-control" rows="2">{{ $settings['alamat_desa'] ?? '' }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tentang Desa (Singkat untuk Footer)</label>
                        <textarea name="tentang_desa" class="form-control" rows="2" placeholder="Deskripsi singkat yang akan muncul di bagian bawah (footer) website.">{{ $settings['tentang_desa'] ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Sejarah Singkat Desa (Untuk Halaman Profil)</label>
                        <textarea name="sejarah_desa" class="form-control" rows="4">{{ $settings['sejarah_desa'] ?? '' }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Visi Desa</label>
                            <textarea name="visi_desa" class="form-control" rows="2">{{ $settings['visi_desa'] ?? '' }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Misi Desa (Pisahkan dengan Enter/Baris Baru)</label>
                            <textarea name="misi_desa" class="form-control" rows="4">{{ $settings['misi_desa'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik & Wilayah -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-bar-chart-fill text-warning"></i> Data Statistik & Wilayah
                </div>
                <div class="setting-card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Luas Wilayah</label>
                            <input type="text" name="luas_wilayah" class="form-control" value="{{ $settings['luas_wilayah'] ?? '± 1.544 Ha' }}" placeholder="Contoh: ± 1.544 Ha atau 46.266 M">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jumlah Penduduk (Jiwa)</label>
                            <input type="text" name="jumlah_penduduk" class="form-control" value="{{ $settings['jumlah_penduduk'] ?? '0' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Jumlah KK</label>
                            <input type="text" name="jumlah_kk" class="form-control" value="{{ $settings['jumlah_kk'] ?? '0' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Jumlah Dusun</label>
                            <input type="text" name="jumlah_dusun" class="form-control" value="{{ $settings['jumlah_dusun'] ?? '4' }}">
                        </div>
                    </div>
                    
                    <hr class="my-4 text-muted">
                    <h6 class="fw-bold mb-3"><i class="bi bi-compass text-primary me-2"></i>Batas Wilayah</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Batas Utara</label>
                            <input type="text" name="batas_utara" class="form-control" value="{{ $settings['batas_utara'] ?? 'Desa Sungai Paku / Desa Sungai Sarik' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Batas Selatan</label>
                            <input type="text" name="batas_selatan" class="form-control" value="{{ $settings['batas_selatan'] ?? 'Desa Teluk Paman' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Batas Timur</label>
                            <input type="text" name="batas_timur" class="form-control" value="{{ $settings['batas_timur'] ?? 'Desa Kuntu / Desa Kuntu Darussalam' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Batas Barat</label>
                            <input type="text" name="batas_barat" class="form-control" value="{{ $settings['batas_barat'] ?? 'Hutan Lindung / Desa Siabu' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peta & Lokasi -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-map-fill text-danger"></i> Lokasi & Peta
                </div>
                <div class="setting-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam Pelayanan</label>
                        <input type="text" name="jam_kerja" class="form-control" value="{{ $settings['jam_kerja'] ?? 'Senin - Jumat, 08:00 - 15:00 WIB' }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">
                            Link Embed Google Maps Kantor Desa
                        </label>

                        {{-- Input URL --}}
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                            <input type="url" name="link_map" id="linkMapInput"
                                   class="form-control"
                                   value="{{ $settings['link_map'] ?? '' }}"
                                   placeholder="https://www.google.com/maps/embed?pb=...">
                        </div>

                        {{-- Validator badge --}}
                        <div id="mapUrlStatus" class="mt-1" style="font-size:.78rem; display:none;"></div>

                        {{-- Panduan cara dapat URL embed --}}
                        <div class="mt-3 p-3 rounded-3" style="background:#fff8ec; border:1.5px solid rgba(201,150,58,.35); font-size:.82rem;">
                            <div class="fw-bold mb-2" style="color:#b07d20;">
                                <i class="bi bi-info-circle-fill me-1"></i>
                                Cara Mendapatkan Link Embed yang Benar
                            </div>

                            {{-- Langkah-langkah --}}
                            <ol class="mb-2 ps-3" style="line-height:1.9; color:#555;">
                                <li>Buka <a href="https://maps.google.com" target="_blank" class="text-warning fw-bold">maps.google.com</a> di browser.</li>
                                <li>Cari lokasi kantor desa Anda.</li>
                                <li>Klik tombol <strong>Bagikan</strong> (ikon Share).</li>
                                <li>Pilih tab <strong>"Sematkan Peta"</strong> (Embed a map).</li>
                                <li>Klik <strong>"Salin HTML"</strong> — lalu ambil <strong>hanya bagian <code>src="..."</code></strong>.</li>
                                <li>Paste URL tersebut ke kolom di atas.</li>
                            </ol>
                        </div>

                        {{-- Script validator real-time --}}
                        <script>
                        (function(){
                            const inp = document.getElementById('linkMapInput');
                            const status = document.getElementById('mapUrlStatus');
                            if (!inp) return;
                            function validate(val) {
                                if (!val) { status.style.display='none'; return; }
                                status.style.display = 'block';
                                if (val.includes('/maps/embed')) {
                                    status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>URL valid! Format embed sudah benar.</span>';
                                    inp.style.borderColor = '#198754';
                                } else {
                                    status.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i><strong>URL tidak valid!</strong> Ini bukan link embed. Ikuti panduan.</span>';
                                    inp.style.borderColor = '#dc3545';
                                }
                            }
                            inp.addEventListener('input', e => validate(e.target.value));
                            validate(inp.value); // cek saat halaman load
                        })();
                        </script>
                    </div>
                </div>
            </div>

            <!-- Kontak Desa -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-telephone-fill text-success"></i> Kontak & Bantuan
                </div>
                <div class="setting-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nomor Telepon / WhatsApp Desa</label>
                        <input type="text" name="telepon_desa" class="form-control" value="{{ $settings['telepon_desa'] ?? '' }}" placeholder="Contoh: 08123456789">
                        <small class="text-muted">Digunakan untuk tombol hubungi kami.</small>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Email Desa</label>
                        <input type="email" name="email_desa" class="form-control" value="{{ $settings['email_desa'] ?? '' }}" placeholder="Contoh: admin@desasukamaju.id">
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-5">
            <!-- Sosial Media -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-share-fill" style="color: var(--gold);"></i> Sosial Media
                </div>
                <div class="setting-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-facebook" style="color: #1877F2;"></i> Link Facebook</label>
                        <input type="url" name="link_facebook" class="form-control" value="{{ $settings['link_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-instagram" style="color: #E4405F;"></i> Link Instagram</label>
                        <input type="url" name="link_instagram" class="form-control" value="{{ $settings['link_instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold"><i class="bi bi-youtube" style="color: #FF0000;"></i> Link YouTube</label>
                        <input type="url" name="link_youtube" class="form-control" value="{{ $settings['link_youtube'] ?? '' }}" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>

            {{-- ══ NOMOR TELEPON PENTING ══ --}}
            <div class="setting-card mb-4">
                <div class="setting-card-header">
                    <i class="bi bi-telephone-fill text-danger"></i> Nomor Telepon Penting
                    <span class="badge ms-auto" style="background:rgba(201,150,58,.15);color:#b07d20;font-size:.72rem;">
                        Tampil di Halaman Kontak
                    </span>
                </div>
                <div class="setting-card-body">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Tambahkan nomor darurat / penting yang ditampilkan di halaman Kontak. Klik <strong>+ Tambah Baris</strong> untuk menambah entri baru.
                    </p>

                    {{-- Daftar baris kontak --}}
                    <div id="teleponList">
                        @php
                            $teleponPenting = json_decode($settings['telepon_penting'] ?? '[]', true);
                            if (empty($teleponPenting)) {
                                $teleponPenting = [
                                    ['jabatan'=>'Kepala Dusun 1',    'nomor'=>'', 'ikon'=>'bi-person-badge-fill'],
                                    ['jabatan'=>'Kepala Dusun 2',    'nomor'=>'', 'ikon'=>'bi-person-badge-fill'],
                                    ['jabatan'=>'Bhabinkamtibmas',   'nomor'=>'', 'ikon'=>'bi-shield-fill-check'],
                                    ['jabatan'=>'Babinsa',           'nomor'=>'', 'ikon'=>'bi-shield-shaded'],
                                    ['jabatan'=>'Puskesmas Terdekat','nomor'=>'', 'ikon'=>'bi-hospital-fill'],
                                ];
                            }
                        @endphp

                        @foreach($teleponPenting as $i => $tp)
                        <div class="telepon-row d-flex gap-2 align-items-center mb-2" data-index="{{ $i }}">
                            {{-- Pilih Ikon --}}
                            <select name="telepon_ikon[]"
                                    class="form-select form-select-sm ikon-select"
                                    style="width:52px;flex-shrink:0;padding:0.35rem 0.3rem;font-size:1rem;text-align:center;"
                                    title="Pilih ikon">
                                @php
                                    $ikonOptions = [
                                        'bi-person-badge-fill'  => '👤',
                                        'bi-shield-fill-check'  => '🛡️',
                                        'bi-shield-shaded'      => '⚔️',
                                        'bi-hospital-fill'      => '🏥',
                                        'bi-telephone-fill'     => '📞',
                                        'bi-fire'               => '🔥',
                                        'bi-heart-pulse-fill'   => '❤️',
                                        'bi-building-fill'      => '🏢',
                                        'bi-people-fill'        => '👥',
                                        'bi-car-front-fill'     => '🚗',
                                    ];
                                @endphp
                                @foreach($ikonOptions as $val => $emoji)
                                    <option value="{{ $val }}" {{ ($tp['ikon'] ?? '') === $val ? 'selected' : '' }}>{{ $emoji }}</option>
                                @endforeach
                            </select>

                            {{-- Nama Jabatan --}}
                            <input type="text"
                                   name="telepon_jabatan[]"
                                   class="form-control form-control-sm"
                                   placeholder="Nama jabatan / instansi"
                                   value="{{ $tp['jabatan'] ?? '' }}"
                                   style="flex:1;">

                            {{-- Nomor Telepon --}}
                            <input type="text"
                                   name="telepon_nomor[]"
                                   class="form-control form-control-sm"
                                   placeholder="0812-xxxx-xxxx"
                                   value="{{ $tp['nomor'] ?? '' }}"
                                   style="flex:1;">

                            {{-- Hapus --}}
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger hapus-row"
                                    title="Hapus baris ini"
                                    style="flex-shrink:0;width:34px;height:34px;padding:0;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    {{-- Tombol Tambah --}}
                    <button type="button" id="btnTambahTelepon"
                            class="btn btn-sm btn-outline-warning mt-1 w-100"
                            style="border-style:dashed;border-radius:10px;font-size:.82rem;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Nomor Baru
                    </button>

                    {{-- Template baris baru (hidden) --}}
                    <template id="teleponRowTemplate">
                        <div class="telepon-row d-flex gap-2 align-items-center mb-2">
                            <select name="telepon_ikon[]"
                                    class="form-select form-select-sm ikon-select"
                                    style="width:52px;flex-shrink:0;padding:0.35rem 0.3rem;font-size:1rem;text-align:center;">
                                <option value="bi-telephone-fill">📞</option>
                                <option value="bi-person-badge-fill">👤</option>
                                <option value="bi-shield-fill-check">🛡️</option>
                                <option value="bi-shield-shaded">⚔️</option>
                                <option value="bi-hospital-fill">🏥</option>
                                <option value="bi-fire">🔥</option>
                                <option value="bi-heart-pulse-fill">❤️</option>
                                <option value="bi-building-fill">🏢</option>
                                <option value="bi-people-fill">👥</option>
                                <option value="bi-car-front-fill">🚗</option>
                            </select>
                            <input type="text" name="telepon_jabatan[]"
                                   class="form-control form-control-sm"
                                   placeholder="Nama jabatan / instansi"
                                   style="flex:1;">
                            <input type="text" name="telepon_nomor[]"
                                   class="form-control form-control-sm"
                                   placeholder="0812-xxxx-xxxx"
                                   style="flex:1;">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger hapus-row"
                                    style="flex-shrink:0;width:34px;height:34px;padding:0;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn text-white w-100 py-3 fw-bold"
                        style="background:linear-gradient(135deg,var(--gold) 0%,var(--gold-light) 100%);border-radius:12px;font-size:1.1rem;box-shadow:0 4px 15px rgba(201,150,58,.3);">
                    <i class="bi bi-save me-2"></i> Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        customClass: { popup: 'rounded-3' }
    });
    @endif

    // ── Tambah baris nomor telepon baru ──
    document.getElementById('btnTambahTelepon').addEventListener('click', function () {
        const template = document.getElementById('teleponRowTemplate');
        const clone    = template.content.cloneNode(true);
        document.getElementById('teleponList').appendChild(clone);
    });

    // ── Hapus baris (event delegation) ──
    document.getElementById('teleponList').addEventListener('click', function (e) {
        const btn = e.target.closest('.hapus-row');
        if (!btn) return;
        const row = btn.closest('.telepon-row');
        // Minimal 1 baris tetap ada
        const allRows = document.querySelectorAll('.telepon-row');
        if (allRows.length <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Bisa Dihapus',
                text: 'Harus ada minimal 1 nomor telepon penting.',
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
            });
            return;
        }
        row.style.transition = 'opacity .2s';
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 200);
    });
</script>
@endpush
@endsection
