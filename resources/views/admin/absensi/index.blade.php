@extends('layouts.admin')
@section('title', 'Absensi Perangkat Desa')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #f1f5f9;
    }
    .stat-absensi {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .stat-absensi .item {
        text-align: center;
        background: #fff;
        border-radius: 12px;
        padding: .6rem 1.2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        min-width: 80px;
    }
    .stat-absensi .item .num { font-size: 1.6rem; font-weight: 800; line-height: 1; }
    .stat-absensi .item .lbl { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
    .stat-absensi .item.hadir .num  { color: #16a34a; }
    .stat-absensi .item.hadir .lbl  { color: #16a34a; }
    .stat-absensi .item.izin  .num  { color: #d97706; }
    .stat-absensi .item.izin  .lbl  { color: #d97706; }
    .stat-absensi .item.belum .num  { color: #64748b; }
    .stat-absensi .item.belum .lbl  { color: #64748b; }

    .absensi-table th { background: var(--coklat-tua); color: #fff; font-weight: 600; font-size: .82rem; }
    .absensi-table td { vertical-align: middle; font-size: .875rem; }
    .absensi-table tr:hover { background: #f8fafc; }

    .perangkat-info { display: flex; align-items: center; gap: .75rem; }
    .perangkat-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        object-fit: cover; flex-shrink: 0;
        border: 2px solid var(--cream);
    }
    .perangkat-avatar-placeholder {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--cream); color: var(--coklat-tua);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; flex-shrink: 0;
    }

    /* Status radio pills */
    .status-pills { display: flex; gap: .4rem; flex-wrap: wrap; }
    .status-pill input[type=radio] { display: none; }
    .status-pill label {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .3rem .75rem;
        border-radius: 20px;
        border: 1.5px solid #e2e8f0;
        font-size: .78rem; font-weight: 600;
        cursor: pointer; transition: all .2s;
        color: #64748b;
        white-space: nowrap;
    }
    .status-pill input[value="hadir"]:checked + label { background: #dcfce7; border-color: #16a34a; color: #15803d; }
    .status-pill input[value="izin"]:checked  + label { background: #fef3c7; border-color: #d97706; color: #b45309; }
    .status-pill input[value="belum"]:checked + label { background: #f1f5f9; border-color: #94a3b8; color: #475569; }
    .status-pill label:hover { background: #f8fafc; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;background:rgba(201,150,58,.1);color:var(--gold);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">
            <i class="bi bi-person-check"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold" style="color:var(--coklat-tua)">Absensi Perangkat Desa</h5>
            <small class="text-muted">{{ $tanggal->translatedFormat('l, d F Y') }}</small>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        {{-- Filter Tanggal --}}
        <form method="GET" action="{{ route('admin.absensi.index') }}" class="d-flex gap-2 align-items-center">
            <input type="date" name="tanggal" class="form-control form-control-sm" style="border-radius:10px"
                   value="{{ $tanggal->format('Y-m-d') }}">
            <button class="btn btn-sm" style="background:var(--gold);color:#fff;border-radius:10px;font-weight:600">
                <i class="bi bi-search me-1"></i>Cari
            </button>
        </form>
        <a href="{{ route('admin.absensi.riwayat') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
            <i class="bi bi-clock-history me-1"></i>Riwayat
        </a>
    </div>
</div>

{{-- Ringkasan --}}
<div class="stat-absensi mb-4">
    <div class="item hadir">
        <div class="num">{{ $ringkasan['hadir'] }}</div>
        <div class="lbl">Hadir</div>
    </div>
    <div class="item izin">
        <div class="num">{{ $ringkasan['izin'] }}</div>
        <div class="lbl">Izin</div>
    </div>
    <div class="item belum">
        <div class="num">{{ $ringkasan['belum'] }}</div>
        <div class="lbl">Belum</div>
    </div>
</div>

{{-- Form Absensi --}}
<form method="POST" action="{{ route('admin.absensi.store') }}">
    @csrf
    <input type="hidden" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}">

    <div class="card-admin">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-person-lines-fill me-2" style="color:var(--gold)"></i>Daftar Perangkat</span>
            <button type="submit" class="btn-sm-gold">
                <i class="bi bi-check-circle me-1"></i>Simpan Absensi
            </button>
        </div>
        <div class="p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 absensi-table">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Perangkat</th>
                            <th>Status Kehadiran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($perangkats as $i => $p)
                        @php $currentStatus = $absensiMap[$p->id] ?? 'belum'; @endphp
                        <tr>
                            <td class="text-muted fw-semibold">{{ $i + 1 }}</td>
                            <td>
                                <div class="perangkat-info">
                                    @if($p->foto)
                                        <img src="{{ Storage::disk('s3')->url('images/perangkat/' . $p->foto) }}"
                                             class="perangkat-avatar" alt="{{ $p->nama }}"
                                             onerror="this.outerHTML='<div class=\'perangkat-avatar-placeholder\'>{{ strtoupper(substr($p->nama,0,1)) }}</div>'">
                                    @else
                                        <div class="perangkat-avatar-placeholder">{{ strtoupper(substr($p->nama, 0, 1)) }}</div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold" style="font-size:.875rem;color:var(--coklat-tua)">{{ $p->nama }}</div>
                                        <div style="font-size:.75rem;color:#94a3b8">{{ $p->jabatan }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="status-pills">
                                    <div class="status-pill">
                                        <input type="radio" name="absensi[{{ $p->id }}][status]"
                                               id="hadir_{{ $p->id }}" value="hadir"
                                               {{ $currentStatus === 'hadir' ? 'checked' : '' }}>
                                        <label for="hadir_{{ $p->id }}">
                                            <i class="bi bi-check-circle-fill"></i> Hadir
                                        </label>
                                    </div>
                                    <div class="status-pill">
                                        <input type="radio" name="absensi[{{ $p->id }}][status]"
                                               id="izin_{{ $p->id }}" value="izin"
                                               {{ $currentStatus === 'izin' ? 'checked' : '' }}>
                                        <label for="izin_{{ $p->id }}">
                                            <i class="bi bi-info-circle-fill"></i> Izin
                                        </label>
                                    </div>
                                    <div class="status-pill">
                                        <input type="radio" name="absensi[{{ $p->id }}][status]"
                                               id="belum_{{ $p->id }}" value="belum"
                                               {{ $currentStatus === 'belum' ? 'checked' : '' }}>
                                        <label for="belum_{{ $p->id }}">
                                            <i class="bi bi-dash-circle-fill"></i> Belum
                                        </label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text"
                                       name="absensi[{{ $p->id }}][keterangan]"
                                       class="form-control form-control-sm"
                                       style="border-radius:8px;font-size:.8rem"
                                       placeholder="Keterangan (opsional)"
                                       value="{{ $keteranganMap[$p->id] ?? '' }}"
                                       maxlength="200">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-3 border-top d-flex justify-content-between align-items-center" style="background:#f8fafc;border-radius:0 0 12px 12px">
            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Data absensi akan disimpan untuk tanggal {{ $tanggal->translatedFormat('d F Y') }}</small>
            <button type="submit" class="btn btn-sm fw-bold px-4"
                    style="background:var(--coklat-tua);color:#fff;border-radius:10px">
                <i class="bi bi-check-lg me-1"></i>Simpan Semua
            </button>
        </div>
    </div>
</form>

@endsection
