@extends('layouts.admin')
@section('title', 'Tambah Fasilitas')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-light border me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="mb-1 text-coklat-tua fw-bold">Tambah Fasilitas</h4>
        <p class="text-muted small mb-0">Input data fasilitas desa baru</p>
    </div>
</div>

<div class="card card-admin border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Fasilitas <span class="text-danger">*</span></label>
                    <input type="text" name="nama_fasilitas" class="form-control @error('nama_fasilitas') is-invalid @enderror" value="{{ old('nama_fasilitas') }}" placeholder="Contoh: Masjid Raya An-Nur" required maxlength="150">
                    @error('nama_fasilitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <!-- Menggunakan datalist agar bisa pilih atau ketik sendiri -->
                        <input type="text" name="kategori" list="kategoriOptions" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}" placeholder="Pilih atau ketik kategori baru" required maxlength="100">
                        <datalist id="kategoriOptions">
                            @foreach($kategoriList as $kat)
                                <option value="{{ $kat }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-text">Bisa pilih dari list, atau ketik manual kategori baru.</div>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi / Info Tambahan (Opsional)</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" maxlength="400" placeholder="Contoh: Terletak di Dusun 1, diresmikan tahun 2020...">{{ old('deskripsi') }}</textarea>
                <div class="form-text text-muted">Maksimal 400 karakter agar tampilan pop-up / modal tetap rapi.</div>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Foto Fasilitas <span class="text-danger">*</span></label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp" required>
                <div class="form-text">Format: JPG, PNG, WEBP. Maksimal 3 MB.</div>
                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4">
            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light border px-4">Reset</button>
                <button type="submit" class="btn btn-sm-gold px-4">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
