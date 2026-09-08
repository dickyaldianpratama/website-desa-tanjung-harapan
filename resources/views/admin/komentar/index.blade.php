@extends('layouts.admin')

@section('title', 'Kelola Komentar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 mb-0 text-gray-800">Komentar Pengunjung</h2>
        <p class="text-muted">Kelola komentar masuk untuk berita dan kegiatan desa.</p>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Pengirim</th>
                        <th width="30%">Komentar</th>
                        <th width="20%">Artikel</th>
                        <th width="10%">Status</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($komentars as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $item->nama }}</strong><br>
                            <small class="text-muted">{{ $item->email ?: 'Tidak ada email' }}</small><br>
                            <small class="text-muted"><i class="bi bi-telephone-fill"></i> {{ $item->no_hp }}</small>
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($item->isi, 100) }}</td>
                        <td>
                            <a href="{{ route('berita.show', $item->berita->slug) }}" target="_blank" class="text-decoration-none">
                                {{ \Illuminate\Support\Str::limit($item->berita->judul, 40) }}
                                <i class="bi bi-box-arrow-up-right ms-1 small"></i>
                            </a>
                        </td>
                        <td>
                            @if($item->status == 'pending')
                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Approved</span>
                            @endif
                        </td>
                        <td>
                            {{ $item->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($item->status == 'pending')
                                    <form action="{{ route('admin.komentar.approve', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.komentar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
            },
            order: [[5, 'desc']]
        });
    });
</script>
@endpush
