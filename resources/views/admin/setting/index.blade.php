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
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Desa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_desa" class="form-control" value="{{ $settings['nama_desa'] ?? 'Desa Sukamaju' }}" required>
                        <small class="text-muted">Contoh: Desa Sukamaju</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Lengkap Kantor Desa</label>
                        <textarea name="alamat_desa" class="form-control" rows="3">{{ $settings['alamat_desa'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jam Pelayanan</label>
                        <input type="text" name="jam_kerja" class="form-control" value="{{ $settings['jam_kerja'] ?? 'Senin - Jumat, 08:00 - 15:00 WIB' }}">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Tentang Desa (Singkat untuk Footer)</label>
                        <textarea name="tentang_desa" class="form-control" rows="3" placeholder="Deskripsi singkat yang akan muncul di bagian bawah (footer) website.">{{ $settings['tentang_desa'] ?? '' }}</textarea>
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

            <div class="mt-4">
                <button type="submit" class="btn text-white w-100 py-3 fw-bold" style="background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); border-radius: 12px; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);">
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
</script>
@endpush
@endsection
