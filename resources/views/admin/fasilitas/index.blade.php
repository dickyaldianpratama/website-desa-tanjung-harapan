@extends('layouts.admin')
@section('title', 'Data Fasilitas Desa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1 text-coklat-tua fw-bold">Data Fasilitas Desa</h4>
        <p class="text-muted small mb-0">Kelola daftar fasilitas umum (Kesehatan, Pendidikan, Masjid, Lapangan, dll)</p>
    </div>
    <a href="{{ route('admin.fasilitas.create') }}" class="btn btn-sm-gold">
        <i class="bi bi-plus-lg me-1"></i> Tambah Fasilitas
    </a>
</div>

<div class="card card-admin">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Foto</th>
                        <th>Nama Fasilitas</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fasilitas as $index => $item)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            @if($item->foto)
                                <img src="{{ Storage::disk('s3')->url('images/fasilitas/' . $item->foto) }}" alt="{{ $item->nama_fasilitas }}" class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                            @else
                                <span class="badge bg-secondary">Tidak ada</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $item->nama_fasilitas }}</td>
                        <td>
                            <span class="badge border px-2 py-1" style="background-color: #fdfbf7; color: #3D1F0A; border-color: #C9963A !important;">{{ $item->kategori }}</span>
                        </td>
                        <td>
                            <span class="text-muted small d-inline-block text-truncate" style="max-width: 200px;">
                                {{ $item->deskripsi ?: '-' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn btn-sm btn-light border btn-action me-1" title="Edit">
                                <i class="bi bi-pencil-fill text-primary"></i>
                            </a>
                            <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border btn-action" title="Hapus">
                                    <i class="bi bi-trash-fill text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            Belum ada data fasilitas desa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
