@extends('layouts.admin')
@section('title', 'Tulis Berita Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.berita.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
    <h4 class="fw-bold text-dark">Tulis Berita Baru</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required placeholder="Masukkan judul berita yang menarik">
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Berita <span class="text-danger">*</span></label>
                    <!-- Trix Editor Input -->
                    <input id="isi" type="hidden" name="isi" value="{{ old('isi') }}">
                    <trix-editor input="isi" class="trix-content @error('isi') border-danger @enderror" style="min-height: 400px; background: #fff;"></trix-editor>
                    @error('isi') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-gear me-2"></i>Pengaturan Publikasi</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publikasikan Langsung</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" required placeholder="Contoh: Pembangunan, Pengumuman">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-image me-2"></i>Gambar Utama</h6>
                        
                        <div class="mb-3">
                            <div class="text-center p-4 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer">
                                <i class="bi bi-cloud-arrow-up display-4 text-muted"></i>
                                <p class="text-muted small mt-2 mb-0">Klik tombol di bawah untuk memilih gambar</p>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-3 rounded d-none" style="max-height: 200px; width: 100%; object-fit: cover;">
                            </div>
                            <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Maksimal 2MB. Format: JPG, PNG, WEBP</small>
                            @error('gambar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: var(--gold); border-color: var(--gold);">
                        <i class="bi bi-save me-2"></i>Simpan Berita
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
    
    gambarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "#";
            imagePreview.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection
