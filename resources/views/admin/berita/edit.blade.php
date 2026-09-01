@extends('layouts.admin')
@section('title', 'Edit Berita')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.berita.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Berita
    </a>
    <h4 class="fw-bold text-dark">Edit Berita</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control form-control-lg @error('judul') is-invalid @enderror" value="{{ old('judul', $berita->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Berita <span class="text-danger">*</span></label>
                    <!-- Trix Editor Input -->
                    <input id="isi" type="hidden" name="isi" value="{{ old('isi', $berita->isi) }}">
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
                                <option value="publish" {{ old('status', $berita->status) == 'publish' ? 'selected' : '' }}>Publikasikan Langsung</option>
                                <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Kategori</label>
                            <input type="text" name="kategori" list="kategori-list" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $berita->kategori) }}" required placeholder="Ketik atau pilih kategori...">
                            <datalist id="kategori-list">
                                @if(isset($kategoris) && count($kategoris) > 0)
                                    @foreach($kategoris as $kat)
                                        @if($kat)
                                            <option value="{{ $kat }}"></option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="Pembangunan"></option>
                                    <option value="Pengumuman"></option>
                                    <option value="Kegiatan"></option>
                                @endif
                            </datalist>
                            <small class="text-muted" style="font-size: 0.75rem;">Pilih dari daftar atau ketik kategori baru yang Anda inginkan bebas.</small>
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="text-muted small">
                            <i class="bi bi-calendar-event me-1"></i> Dibuat: {{ $berita->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-image me-2"></i>Gambar Utama</h6>
                        
                        <div class="mb-3">
                            <div class="text-center p-4 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('gambar').click()" title="Klik untuk import gambar">
                                @if($berita->gambar)
                                    <img id="imagePreview" src="{{ Storage::disk('s3')->url('images/berita/' . $berita->gambar) }}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                                @else
                                    <i class="bi bi-cloud-arrow-up display-4 text-muted" id="uploadIcon"></i>
                                    <p class="text-muted small mt-2 mb-0" id="uploadText">Klik area ini untuk memilih gambar baru</p>
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-3 rounded d-none shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover;">
                                @endif
                            </div>
                            
                            <div class="text-center mb-2">
                                <small class="text-primary"><i class="bi bi-info-circle me-1"></i>Klik area di atas untuk import gambar. Anda dapat menggeser/zoom agar posisi pas (kiri, kanan, tengah, dll).</small>
                            </div>

                            <input class="form-control d-none" type="file" id="gambar" name="gambar" accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah gambar saat ini.</small>
                            @error('gambar') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: var(--gold); border-color: var(--gold); font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
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
                <h5 class="modal-title" id="cropModalLabel">Sesuaikan Posisi Gambar Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container" style="max-height: 400px; width: 100%; display: flex; justify-content: center; background-color: #f8f9fa;">
                    <img id="imageToCrop" src="" style="max-width: 100%; max-height: 400px; display: block;">
                </div>
                <p class="text-muted text-center mt-3 small"><i class="bi bi-arrows-move me-1"></i>Geser gambar atau gunakan scroll mouse untuk zoom agar subjek pas di tengah kotak (16:9).</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelCropBtn">Batal</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn" style="background-color: #c9963a; border-color: #c9963a;">Potong & Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- Cropper.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<style>
    .img-container img {
        display: block;
        max-width: 100%;
    }
</style>
@endpush

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
            aspectRatio: 16 / 9, // Rasio standar berita/thumbnail
            viewMode: 1,
            dragMode: 'move', // Default drag adalah menggeser gambar
            autoCropArea: 1,
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
                height: 675,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Ubah canvas menjadi file blob
            canvas.toBlob(function(blob) {
                // Buat file baru dari blob
                const fileName = gambarInput.files[0] ? gambarInput.files[0].name : 'berita_image.jpg';
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
