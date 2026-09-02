@extends('layouts.admin')
@section('title', 'Edit Bagan Struktur')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.bagan.index') }}" class="btn btn-sm btn-light border">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card card-admin">
    <div class="card-header">
        <h5 class="mb-0">Edit Bagan Struktur</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.bagan.update', $bagan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold">Nama Struktur</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $bagan->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Urutan Tampil</label>
                    <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $bagan->urutan) }}" required min="1">
                    @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Ganti Gambar Bagan (Opsional)</label>
                @if($bagan->gambar)
                    <div class="mb-3">
                        <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                @endif
                <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                <div class="form-text mt-2 text-muted">
                    Format: JPG, PNG, WEBP (Max 5MB). Biarkan kosong jika tidak ingin mengubah gambar.
                </div>
                @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr class="opacity-25 my-4">
            
            <div class="text-end">
                <button type="submit" class="btn btn-sm-gold px-4 py-2" style="font-size: 1rem;">
                    <i class="bi bi-save me-1"></i> Perbarui Bagan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
