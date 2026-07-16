@extends('layouts.admin')
@section('title', 'Tambah Perangkat Desa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.perangkat.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Struktur Organisasi
    </a>
    <h4 class="fw-bold text-dark">Tambah Anggota Baru</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.perangkat.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso, S.E." required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" placeholder="Contoh: Sekretaris Desa" required>
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">NIP / Nomor Pegawai <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" placeholder="Masukkan NIP jika ada">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Pengaturan Tampil</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Urutan Hirarki <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $nextUrutan) }}" min="1" required>
                            <small class="text-muted" style="font-size: 0.7rem;">Contoh: 1 (Kepala Desa), 2 (Sekretaris), dst.</small>
                            @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Foto Profil / Pas Foto</label>
                            <div class="text-center p-3 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('foto').click()">
                                <i class="bi bi-person-bounding-box display-4 text-muted" id="uploadIcon"></i>
                                <p class="text-muted small mt-2 mb-0" id="uploadText">Klik untuk pilih pas foto (3x4 atau 1:1)</p>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-2 rounded-circle d-none shadow-sm" style="width: 120px; height: 120px; object-fit: cover; margin: 0 auto;">
                            </div>
                            <input class="form-control d-none" type="file" id="foto" name="foto" accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Maksimal 2MB (JPG/PNG). Dianjurkan foto resmi berlatar belakang rapi.</small>
                            @error('foto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: #c9963a; border-color: #c9963a; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);">
                        <i class="bi bi-save me-2"></i>Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const fotoInput = document.getElementById('foto');
    const imagePreview = document.getElementById('imagePreview');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    
    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');
                if(uploadIcon) uploadIcon.classList.add('d-none');
                if(uploadText) uploadText.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "#";
            imagePreview.classList.add('d-none');
            if(uploadIcon) uploadIcon.classList.remove('d-none');
            if(uploadText) uploadText.classList.remove('d-none');
        }
    });
</script>
@endpush
@endsection
