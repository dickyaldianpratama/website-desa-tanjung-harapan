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
                            <div class="d-flex gap-2 position-relative" style="min-width: 120px;">
                                @if($item->status == 'pending')
                                    <form action="{{ route('admin.komentar.approve', $item->id) }}" method="POST" class="d-inline position-relative form-approve">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Setujui agar tampil di publik">
                                            <i class="bi bi-check-lg"></i> Setujui
                                        </button>
                                        
                                        <!-- Animasi Jari & Notif -->
                                        <div class="pointer-hint" style="position: absolute; right: 105%; top: 50%; transform: translateY(-50%); display: flex; align-items: center; white-space: nowrap; pointer-events: none;">
                                            <span class="badge bg-danger pulse-anim me-2" style="font-size: 0.65rem; padding: 4px 8px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">Wajib Cek!</span>
                                            <i class="bi bi-hand-index-fill text-warning bounce-horizontal" style="font-size: 1.3rem; transform: rotate(90deg);"></i>
                                        </div>
                                    </form>
                                @endif
                                <form action="{{ route('admin.komentar.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
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

@push('styles')
<style>
    @keyframes pulseRed {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    @keyframes bounceHorizontal {
        0%, 100% { transform: rotate(90deg) translateY(0); }
        50% { transform: rotate(90deg) translateY(-8px); }
    }
    .pulse-anim {
        animation: pulseRed 2s infinite;
    }
    .bounce-horizontal {
        animation: bounceHorizontal 1.5s infinite ease-in-out;
    }
    
    /* Make sure form layout doesn't clip the absolute tooltip */
    .table-responsive {
        overflow-x: visible !important;
        overflow-y: visible !important;
    }
</style>
@endpush

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
