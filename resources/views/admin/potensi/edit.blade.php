@extends('layouts.admin')
@section('title', 'Edit Potensi Desa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.potensi.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Potensi Desa
    </a>
    <h4 class="fw-bold text-dark">Edit Potensi</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.potensi.update', $potensi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Potensi <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" value="{{ old('judul', $potensi->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                    <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi', $potensi->deskripsi) }}">
                    <trix-editor input="deskripsi" class="trix-content @error('deskripsi') border-danger @enderror"></trix-editor>
                    @error('deskripsi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Tambahan</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $potensi->kategori) }}" required>
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Foto/Gambar</label>
                            <div class="text-center p-3 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('gambar').click()">
                                @if($potensi->gambar)
                                    <img id="imagePreview" src="{{ asset('images/potensi/' . $potensi->gambar) }}" alt="Preview" class="img-fluid rounded" style="width: 100%; max-height: 200px; object-fit: cover;">
                                @else
                                    <i class="bi bi-cloud-arrow-up display-4 text-muted" id="uploadIcon"></i>
                                    <p class="text-muted small mt-2 mb-0" id="uploadText">Klik untuk upload foto</p>
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-2 rounded d-none" style="width: 100%; max-height: 200px; object-fit: cover;">
                                @endif
                            </div>
                            <input class="form-control d-none" type="file" id="gambar" name="gambar" accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah foto</small>
                            @error('gambar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: #10b981; border-color: #10b981; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        <i class="bi bi-save me-2"></i>Update Potensi
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
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
        }
    });
</script>
@endpush
@endsection
