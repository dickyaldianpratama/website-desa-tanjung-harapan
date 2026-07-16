@extends('layouts.admin')
@section('title', 'Manajemen APBDes')

@section('content')
<div class="card-admin mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-wallet2 me-2 text-gold"></i>Data APBDes</span>
        <a href="{{ route('admin.apbdes.create') }}" class="btn btn-sm btn-light fw-bold" style="color: var(--coklat-tua)">
            + Tambah Data
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8f9fa;">
                    <tr>
                        <th class="ps-4">Tahun</th>
                        <th>Uraian</th>
                        <th>Jenis</th>
                        <th class="text-end">Anggaran (Rp)</th>
                        <th class="text-end">Realisasi (Rp)</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apbdes as $item)
                        <tr>
                            <td class="ps-4 fw-bold">{{ $item->tahun }}</td>
                            <td>{{ $item->uraian }}</td>
                            <td>
                                @if($item->jenis == 'pendapatan')
                                    <span class="badge bg-success">Pendapatan</span>
                                @else
                                    <span class="badge bg-danger">Belanja</span>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($item->realisasi, 0, ',', '.') }}</td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.apbdes.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.apbdes.destroy', $item->id) }}" method="POST" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data APBDes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-delete');
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endpush
