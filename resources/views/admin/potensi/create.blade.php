@extends('layouts.admin')
@section('title', 'Tambah Potensi Desa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.potensi.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Potensi Desa
    </a>
    <h4 class="fw-bold text-dark">Tambah Potensi Baru</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.potensi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Potensi <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Contoh: Wisata Air Terjun Curug Cilember" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Deskripsi Lengkap <span class="text-danger">*</span></label>
                    <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi') }}">
                    <trix-editor input="deskripsi" class="trix-content @error('deskripsi') border-danger @enderror" placeholder="Ceritakan detail menarik tentang potensi ini..."></trix-editor>
                    @error('deskripsi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Tambahan</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Contoh: Pariwisata, Pertanian" required>
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Foto/Gambar <span class="text-danger">*</span></label>
                            <div class="text-center p-3 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('gambar').click()" title="Klik untuk import gambar">
                                <i class="bi bi-cloud-arrow-up display-4 text-muted" id="uploadIcon"></i>
                                <p class="text-muted small mt-2 mb-0" id="uploadText">Klik untuk pilih gambar (16:9)</p>
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-2 rounded d-none" style="width: 100%; max-height: 200px; object-fit: cover;">
                            </div>
                            
                            <div class="text-center mb-2">
                                <small class="text-primary"><i class="bi bi-info-circle me-1"></i>Klik area di atas untuk memilih gambar.</small>
                            </div>

                            <input class="form-control d-none" type="file" id="gambar" name="gambar" accept="image/*" required>
                            <small class="text-muted" style="font-size: 0.75rem;">Maksimal 3MB (JPG/PNG)</small>
                            @error('gambar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: #10b981; border-color: #10b981; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                        <i class="bi bi-save me-2"></i>Simpan Potensi
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for Cropper -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Sesuaikan Posisi Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container" style="max-height: 400px; width: 100%; display: flex; justify-content: center; background-color: #f8f9fa;">
                    <img id="imageToCrop" src="" style="max-width: 100%; max-height: 400px; display: block;">
                </div>
                <p class="text-muted text-center mt-3 small"><i class="bi bi-arrows-move me-1"></i>Geser gambar atau gunakan scroll mouse untuk zoom agar sesuai kotak potong.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelCropBtn">Batal</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn" style="background-color: #10b981; border-color: #10b981;">Potong & Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    const gambarInput = document.getElementById('gambar');
    const imagePreview = document.getElementById('imagePreview');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    
    // Cropper elements
    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
    const imageToCrop = document.getElementById('imageToCrop');
    let cropper;

    gambarInput.addEventListener('change', function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Tampilkan modal cropper
                imageToCrop.src = e.target.result;
                cropModal.show();
            }
            reader.readAsDataURL(file);
        }
    });

    // Inisialisasi Cropper saat modal terbuka
    document.getElementById('cropModal').addEventListener('shown.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 16 / 9, // 16:9 untuk potensi/berita
            viewMode: 1,
            dragMode: 'move', // Default drag adalah menggeser gambar
            autoCropArea: 0.9,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: false, // Kotak crop diam, gambar yang digeser
            cropBoxResizable: false, // Kotak crop tidak bisa diubah ukurannya
            toggleDragModeOnDblclick: false,
        });
    });

    // Bersihkan cropper saat modal tertutup (batal)
    document.getElementById('cropModal').addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        if (!imagePreview.src.startsWith('blob:')) {
            gambarInput.value = '';
        }
    });

    document.getElementById('cropImageBtn').addEventListener('click', function() {
        if (cropper) {
            // Dapatkan hasil potongan gambar (canvas)
            const canvas = cropper.getCroppedCanvas({
                width: 1200,
                height: 675, // 16:9 
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Ubah canvas menjadi file blob
            canvas.toBlob(function(blob) {
                // Buat file baru dari blob
                const fileName = gambarInput.files[0] ? gambarInput.files[0].name : 'cropped_image.jpg';
                const file = new File([blob], fileName, { type: 'image/jpeg', lastModified: new Date().getTime() });
                
                // Gunakan DataTransfer untuk mengganti file di input file
                const container = new DataTransfer();
                container.items.add(file);
                gambarInput.files = container.files;

                // Update Preview
                const croppedUrl = URL.createObjectURL(blob);
                imagePreview.src = croppedUrl;
                imagePreview.classList.remove('d-none');
                if(uploadIcon) uploadIcon.classList.add('d-none');
                if(uploadText) uploadText.classList.add('d-none');

                // Tutup modal
                cropModal.hide();
            }, 'image/jpeg', 0.9);
        }
    });
</script>
@endpush
@endsection
