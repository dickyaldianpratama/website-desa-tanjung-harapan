@extends('layouts.admin')
@section('title', 'Setting Bagan Struktur')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="mb-1 text-coklat-tua fw-bold">Setting Bagan Struktur</h4>
        <p class="text-muted small mb-0">Kelola gambar bagan struktur organisasi (Perangkat, BPD, PKK, dll)</p>
    </div>
    <div class="d-grid d-md-block">
        <a href="{{ route('admin.bagan.create') }}" class="btn btn-primary px-4 py-2 text-nowrap" style="background: linear-gradient(135deg, #c9963a 0%, #a67828 100%); border: none; border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3); transition: transform 0.2s; text-align: center;">
            <i class="bi bi-plus-lg me-2"></i>Tambah Bagan
        </a>
    </div>
</div>

<div class="card card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Bagan</th>
                        <th>Nama Struktur</th>
                        <th>Urutan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bagans as $index => $bagan)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            @if($bagan->gambar)
                                <img src="{{ Storage::disk('s3')->url('images/struktur/' . $bagan->gambar) }}" alt="{{ $bagan->nama }}" class="img-thumbnail" style="width: 80px; height: 60px; object-fit: contain;">
                            @else
                                <span class="badge bg-secondary">Belum ada gambar</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $bagan->nama }}</td>
                        <td>{{ $bagan->urutan }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.bagan.edit', $bagan->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.bagan.destroy', $bagan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bagan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data bagan struktur. Silakan tambahkan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
