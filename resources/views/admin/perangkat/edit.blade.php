@extends('layouts.admin')
@section('title', 'Edit Perangkat Desa')

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

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.perangkat.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Struktur Organisasi
    </a>
    <h4 class="fw-bold text-dark">Edit Data Anggota</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.perangkat.update', $perangkat->id) }}" method="POST" enctype="multipart/form-data" id="perangkatForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control form-control-lg @error('nama') is-invalid @enderror" value="{{ old('nama', $perangkat->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $perangkat->jabatan) }}" required>
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">NIP / Nomor Pegawai <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $perangkat->nip) }}">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Pengaturan Tampil</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small">Urutan Hirarki <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $perangkat->urutan) }}" min="1" required>
                            <small class="text-muted" style="font-size: 0.7rem;">Contoh: 1 (Kepala Desa), 2 (Sekretaris), dst.</small>
                            @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Foto Profil / Pas Foto</label>
                            <div class="text-center p-3 border border-dashed rounded mb-2 bg-white" id="imagePreviewContainer" style="border-width: 2px; cursor: pointer;" onclick="document.getElementById('foto').click()" title="Klik untuk import gambar">
                                @if($perangkat->foto)
                                    <img id="imagePreview" src="{{ Storage::disk('s3')->url('images/perangkat/' . $perangkat->foto) }}" alt="Preview" class="img-fluid mt-2 rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover; margin: 0 auto;">
                                @else
                                    <i class="bi bi-person-bounding-box display-4 text-muted" id="uploadIcon"></i>
                                    <p class="text-muted small mt-2 mb-0" id="uploadText">Klik untuk pilih pas foto (3x4 atau 1:1)</p>
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid mt-2 rounded-circle d-none shadow-sm" style="width: 120px; height: 120px; object-fit: cover; margin: 0 auto;">
                                @endif
                            </div>
                            
                            <div class="text-center mb-2">
                                <small class="text-primary"><i class="bi bi-info-circle me-1"></i>Klik area di atas untuk import gambar. Anda dapat menggeser/zoom agar posisi pas.</small>
                            </div>

                            <input class="form-control d-none" type="file" id="foto" name="foto" accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Biarkan kosong jika tidak ingin mengubah foto saat ini.</small>
                            @error('foto') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if($perangkat->foto)
                            <div class="form-check mt-3 d-flex justify-content-center">
                                <input class="form-check-input me-2" type="checkbox" id="hapus_foto" name="hapus_foto" value="1">
                                <label class="form-check-label text-danger small fw-bold" for="hapus_foto">
                                    Hapus foto saat ini (kosongkan)
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" style="background-color: #c9963a; border-color: #c9963a; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);">
                        <i class="bi bi-save me-2"></i>Update Data
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
                <h5 class="modal-title" id="cropModalLabel">Sesuaikan Posisi Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container" style="max-height: 400px; width: 100%; display: flex; justify-content: center; background-color: #f8f9fa;">
                    <img id="imageToCrop" src="" style="max-width: 100%; max-height: 400px; display: block;">
                </div>
                <p class="text-muted text-center mt-3 small"><i class="bi bi-arrows-move me-1"></i>Geser gambar atau gunakan scroll mouse untuk zoom agar wajah/posisi pas di tengah kotak.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelCropBtn">Batal</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn" style="background-color: #c9963a; border-color: #c9963a;">Potong & Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    const fotoInput = document.getElementById('foto');
    const imagePreview = document.getElementById('imagePreview');
    const uploadIcon = document.getElementById('uploadIcon');
    const uploadText = document.getElementById('uploadText');
    
    // Cropper elements
    const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));
    const imageToCrop = document.getElementById('imageToCrop');
    let cropper;

    fotoInput.addEventListener('change', function(e) {
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
            aspectRatio: 1, // 1:1 untuk lingkaran/persegi
            viewMode: 1,
            dragMode: 'move', // Default drag adalah menggeser gambar
            autoCropArea: 0.8,
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
        // Jika dibatalkan dan preview masih menggunakan URL objek blob atau kosong, reset input
        // Kita biarkan saja karena ini form edit, preview aslinya masih ada.
        // Tapi kita perlu mengosongkan input file jika user batal agar tidak terupload file asli yg belum dicrop.
        if (!imagePreview.src.startsWith('blob:')) {
            fotoInput.value = '';
        }
    });

    document.getElementById('cropImageBtn').addEventListener('click', function() {
        if (cropper) {
            // Dapatkan hasil potongan gambar (canvas)
            const canvas = cropper.getCroppedCanvas({
                width: 600,
                height: 600,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            // Ubah canvas menjadi file blob
            canvas.toBlob(function(blob) {
                // Buat file baru dari blob
                const fileName = fotoInput.files[0] ? fotoInput.files[0].name : 'cropped_image.jpg';
                const file = new File([blob], fileName, { type: 'image/jpeg', lastModified: new Date().getTime() });
                
                // Gunakan DataTransfer untuk mengganti file di input file
                const container = new DataTransfer();
                container.items.add(file);
                fotoInput.files = container.files;

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
