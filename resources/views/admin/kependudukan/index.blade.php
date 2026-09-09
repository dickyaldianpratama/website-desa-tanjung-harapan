@extends('layouts.admin')
@section('title', 'Data Kependudukan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-admin">
            <div class="card-header">
                <i class="bi bi-people-fill me-2"></i> Pengaturan Data Kependudukan
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.kependudukan.update') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold mb-3"><i class="bi bi-123"></i> Statistik Utama</h6>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Total Jiwa</label>
                            <input type="number" class="form-control" name="penduduk_total" value="{{ $settings['penduduk_total'] ?? '' }}" placeholder="Contoh: 1514">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Laki-Laki</label>
                            <input type="number" class="form-control" name="penduduk_laki" value="{{ $settings['penduduk_laki'] ?? '' }}" placeholder="Contoh: 737">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Perempuan</label>
                            <input type="number" class="form-control" name="penduduk_perempuan" value="{{ $settings['penduduk_perempuan'] ?? '' }}" placeholder="Contoh: 777">
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-link-45deg"></i> Link Tombol Statistik (Tautan Halaman)</h6>
                    <p class="text-muted small mb-3">Kosongkan jika tombol belum ingin diarahkan ke mana-mana (bisa diisi dengan "#").</p>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Lihat Statistik Keluarga</label>
                            <input type="text" class="form-control" name="link_statistik_keluarga" value="{{ $settings['link_statistik_keluarga'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Agama</label>
                            <input type="text" class="form-control" name="link_agama" value="{{ $settings['link_agama'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Pekerjaan</label>
                            <input type="text" class="form-control" name="link_pekerjaan" value="{{ $settings['link_pekerjaan'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Pendidikan</label>
                            <input type="text" class="form-control" name="link_pendidikan" value="{{ $settings['link_pendidikan'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Umur</label>
                            <input type="text" class="form-control" name="link_umur" value="{{ $settings['link_umur'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Perkawinan</label>
                            <input type="text" class="form-control" name="link_perkawinan" value="{{ $settings['link_perkawinan'] ?? '#' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Link Wilayah</label>
                            <input type="text" class="form-control" name="link_wilayah" value="{{ $settings['link_wilayah'] ?? '#' }}">
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 mt-4"><i class="bi bi-megaphone"></i> Running Text (Teks Berjalan Beranda)</h6>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Teks Berjalan</label>
                        <input type="text" class="form-control" name="running_text_kependudukan" value="{{ $settings['running_text_kependudukan'] ?? 'Selamat Datang di Website Resmi Pemerintah Desa Tanjung Harapan' }}">
                        <div class="form-text">Teks ini akan muncul berjalan di halaman utama bagian Kependudukan.</div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-simpan-gradient px-4">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.btn-simpan-gradient {
    background: linear-gradient(135deg, var(--gold, #C9963A) 0%, #a87928 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(201, 150, 58, 0.4);
    transition: all 0.3s ease;
}
.btn-simpan-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(201, 150, 58, 0.6);
    color: #fff;
    background: linear-gradient(135deg, #a87928 0%, var(--gold, #C9963A) 100%);
}
.btn-simpan-gradient:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(201, 150, 58, 0.4);
}
</style>
@endpush
@endsection
