@extends('layouts.app')
@section('title', 'Cek Status Layanan')

@push('styles')
<style>
    .cek-header {
        background: linear-gradient(135deg, var(--coklat-tua), var(--coklat-muda));
        color: white;
        padding-top: 120px;
        padding-bottom: 70px;
        text-align: center;
    }
    .status-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 2rem;
        margin-top: -40px;
        position: relative;
        z-index: 2;
    }
    @media (max-width: 767.98px) {
        .cek-header {
            padding-top: 100px;
            padding-bottom: 60px;
        }
        .cek-header h1 {
            font-size: 1.8rem;
        }
        .status-card {
            padding: 1.5rem 1rem;
            margin-left: 10px;
            margin-right: 10px;
        }
    }
    .status-badge {
        font-size: 1.1rem;
        padding: 0.5rem 1.5rem;
        border-radius: 30px;
        font-weight: bold;
        display: inline-block;
        margin-top: 5px;
    }
    .status-pending { background: #ffeeba; color: #856404; }
    .status-diproses { background: #b8daff; color: #004085; }
    .status-selesai { background: #c3e6cb; color: #155724; }
    .status-ditolak { background: #f5c6cb; color: #721c24; }
</style>
@endpush

@section('content')

<div class="cek-header">
    <div class="container">
        <h1 class="font-serif fw-bold mb-2">Cek Status Layanan</h1>
        <p class="lead mb-0">Lacak proses permohonan surat Anda melalui Nomor Tiket.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="status-card">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        {!! session('success') !!}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('layanan.cekStatus') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="input-group input-group-lg">
                        <input type="text" name="nomor_tiket" class="form-control" placeholder="Masukkan Nomor Tiket (Contoh: SRT-202608-001)" value="{{ request('nomor_tiket', old('nomor_tiket')) }}" required>
                        <button class="btn btn-dark px-4" type="submit">Cari <i class="bi bi-search ms-1"></i></button>
                    </div>
                </form>

                @if(isset($layanan))
                <div class="card border-0 bg-light mt-4 mb-5">
                    <div class="card-body p-4">
                        <h5 class="fw-bold border-bottom pb-3 mb-4">Hasil Pencarian: <br class="d-md-none"> <span class="text-primary text-nowrap">{{ $layanan->nomor_tiket }}</span></h5>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Pemohon</div>
                            <div class="col-sm-8 fw-semibold">{{ $layanan->nama_lengkap }} ({{ substr($layanan->nik, 0, 6) }}**********)</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Jenis Surat</div>
                            <div class="col-sm-8 fw-semibold">{{ $layanan->jenis_layanan }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Tanggal Pengajuan</div>
                            <div class="col-sm-8 fw-semibold">{{ $layanan->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 text-muted pt-2">Status Saat Ini</div>
                            <div class="col-sm-8">
                                @if($layanan->status === 'pending')
                                    <span class="status-badge status-pending">Pending (Menunggu Antrean)</span>
                                @elseif($layanan->status === 'diproses')
                                    <span class="status-badge status-diproses">Sedang Diproses Desa</span>
                                @elseif($layanan->status === 'selesai')
                                    <span class="status-badge status-selesai"><i class="bi bi-check-circle-fill me-1"></i> Selesai (Bisa Diunduh)</span>
                                @else
                                    <span class="status-badge status-ditolak"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                @endif
                            </div>
                        </div>

                        @if($layanan->catatan_admin)
                        <div class="alert {{ $layanan->status === 'ditolak' ? 'alert-danger' : 'alert-info' }} mb-4">
                            <strong>Catatan dari Desa:</strong><br>
                            {{ $layanan->catatan_admin }}
                        </div>
                        @endif
                        
                        <div class="d-flex flex-column flex-md-row gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('layanan.cetakTiket', $layanan->nomor_tiket) }}" target="_blank" class="btn btn-outline-dark">
                                <i class="bi bi-printer me-1"></i> Cetak/Simpan Tiket
                            </a>
                            @if($layanan->status === 'selesai')
                            <a href="{{ route('layanan.cetakSurat', $layanan->nomor_tiket) }}" target="_blank" class="btn btn-success">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Unduh / Cetak Surat Resmi
                            </a>
                            @endif
                        </div>

                    </div>
                </div>
                @endif

            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="bi bi-arrow-left me-1"></i> Kembali Buat Pengajuan Baru</a>
            </div>
        </div>
    </div>
</div>

@endsection
