@extends('layouts.admin')
@section('title', 'Tambah Banner')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.slider.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Manajemen Slider
    </a>
    <h4 class="fw-bold text-dark">Tambah Banner Baru</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Banner <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Contoh: Selamat Datang di Desa Kami" maxlength="60">
                    <small class="text-muted" style="font-size: 0.75rem;">Maksimal 60 karakter agar tampilan teks tidak merusak desain.</small>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Teks Subtitle <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="3" placeholder="Teks kecil di bawah judul..." maxlength="150">{{ old('subtitle') }}</textarea>
                    <small class="text-muted" style="font-size: 0.75rem;">Maksimal 150 karakter.</small>
                    @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Gambar Banner <span class="text-danger">*</span></label>
                    <div class="text-center p-4 border border-dashed rounded mb-2 bg-light" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('gambar').click()">
                        <i class="bi bi-images display-4 text-muted" id="uploadIcon"></i>
                        <p class="text-muted small mt-2 mb-0" id="uploadText">Klik di sini untuk memilih gambar banner (Rasio ideal 16:9)</p>
                        <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-3 rounded d-none" style="width: 100%; max-height: 400px; object-fit: cover;">
                    </div>
                    <input class="form-control d-none" type="file" id="gambar" name="gambar" accept="image/*" required>
                    <small class="text-muted">Maksimal 3MB. Format yang didukung: JPG, PNG, WEBP.</small>
                    @error('gambar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-sliders me-2"></i>Pengaturan Tampil</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Status Banner</label>
                            <select name="aktif" class="form-select @error('aktif') is-invalid @enderror">
                                <option value="1" {{ old('aktif', '1') == '1' ? 'selected' : '' }}>Aktif (Ditampilkan)</option>
                                <option value="0" {{ old('aktif') == '0' ? 'selected' : '' }}>Tidak Aktif (Disembunyikan)</option>
                            </select>
                            @error('aktif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $nextUrutan) }}" min="1" required>
                            <small class="text-muted" style="font-size: 0.7rem;">Banner dengan urutan terkecil akan tampil lebih dulu (1, 2, 3..)</small>
                            @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: var(--gold); border-color: var(--gold); font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.4);">
                        <i class="bi bi-save me-2"></i>Simpan Banner
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Image Preview Script
    const gambarInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('imagePreview');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    
    gambarInput.addEventListener('change', function() {
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
