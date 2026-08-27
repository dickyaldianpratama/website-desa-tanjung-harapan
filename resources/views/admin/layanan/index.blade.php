@extends('layouts.admin')

@section('title', 'E-Layanan (Surat Digital)')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-serif fw-bold mb-1" style="color: var(--coklat-tua);">Permohonan Surat</h2>
        <p class="text-muted mb-0">Kelola antrean permohonan surat dari warga desa.</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No Tiket / Tanggal</th>
                        <th width="20%">Pemohon</th>
                        <th width="25%">Jenis Surat</th>
                        <th width="15%">Status</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanans as $index => $item)
                        <tr>
                            <td>{{ $layanans->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-primary">{{ $item->nomor_tiket }}</div>
                                <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->nama_lengkap }}</div>
                                <small class="text-muted">NIK: {{ $item->nik }}</small>
                            </td>
                            <td>{{ $item->jenis_layanan }}</td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                @elseif($item->status == 'diproses')
                                    <span class="badge bg-info px-3 py-2 rounded-pill">Diproses</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Selesai</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.layanan.show', $item->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">Detail & Proses</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada permohonan surat masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $layanans->links() }}
        </div>
    </div>
</div>

@endsection
