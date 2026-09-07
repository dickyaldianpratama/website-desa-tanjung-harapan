@extends('layouts.admin')
@section('title', 'Riwayat Absensi')

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
    .riwayat-table { min-width: 700px; }
    .riwayat-table th { background: var(--coklat-tua); color: #fff; font-size: .75rem; font-weight: 600; text-align: center; padding: .5rem .3rem; }
    .riwayat-table td { font-size: .78rem; text-align: center; padding: .4rem .3rem; }
    .riwayat-table .td-nama { text-align: left; font-weight: 600; white-space: nowrap; color: var(--coklat-tua); font-size: .82rem; }
    .riwayat-table .td-jabatan { text-align: left; font-size: .72rem; color: #94a3b8; }

    .badge-h  { background: #dcfce7; color: #15803d; border-radius: 4px; padding: 1px 5px; font-size: .72rem; font-weight: 700; }
    .badge-i  { background: #fef3c7; color: #b45309; border-radius: 4px; padding: 1px 5px; font-size: .72rem; font-weight: 700; }
    .badge-bl { background: #f1f5f9; color: #64748b; border-radius: 4px; padding: 1px 5px; font-size: .72rem; font-weight: 600; }

    .rekap-cell { font-weight: 700; font-size: .82rem; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div style="width:44px;height:44px;background:rgba(201,150,58,.1);color:var(--gold);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold" style="color:var(--coklat-tua)">Riwayat Absensi</h5>
            <small class="text-muted">
                {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
            </small>
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <form method="GET" action="{{ route('admin.absensi.riwayat') }}" class="d-flex gap-2 align-items-center">
            <select name="bulan" class="form-select form-select-sm" style="border-radius:10px;min-width:120px">
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::createFromDate(2000,$m,1)->translatedFormat('F') }}
                </option>
                @endforeach
            </select>
            <select name="tahun" class="form-select form-select-sm" style="border-radius:10px;min-width:90px">
                @foreach(range(now()->year - 2, now()->year) as $y)
                <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm" style="background:var(--gold);color:#fff;border-radius:10px;font-weight:600">
                <i class="bi bi-search me-1"></i>Tampilkan
            </button>
        </form>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:10px">
            <i class="bi bi-calendar-check me-1"></i>Input Hari Ini
        </a>
    </div>
</div>

<div class="card-admin">
    <div class="card-header">
        <i class="bi bi-table me-2" style="color:var(--gold)"></i>
        Rekap Absensi — {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 riwayat-table">
                <thead>
                    <tr>
                        <th style="width:30px">#</th>
                        <th style="text-align:left;min-width:160px">Nama</th>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            <th>{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}</th>
                        @endfor
                        <th style="background:#1a3a1a">H</th>
                        <th style="background:#3a3010">I</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perangkats as $i => $p)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="td-nama">{{ $p->nama }}</div>
                            <div class="td-jabatan">{{ $p->jabatan }}</div>
                        </td>
                        @for($d = 1; $d <= $daysInMonth; $d++)
                            @php
                                $day = str_pad($d, 2, '0', STR_PAD_LEFT);
                                $st  = $absensiMatrix[$p->id][$day] ?? null;
                            @endphp
                            <td>
                                @if($st === 'hadir')
                                    <span class="badge-h">H</span>
                                @elseif($st === 'izin')
                                    <span class="badge-i">I</span>
                                @else
                                    <span class="badge-bl">-</span>
                                @endif
                            </td>
                        @endfor
                        <td class="rekap-cell" style="color:#15803d;background:#f0fdf4">{{ $rekap[$p->id]['hadir'] }}</td>
                        <td class="rekap-cell" style="color:#b45309;background:#fffbeb">{{ $rekap[$p->id]['izin'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-3" style="background:#f8fafc;border-radius:0 0 12px 12px;font-size:.8rem;color:#64748b">
        <span class="badge-h">H</span> = Hadir &nbsp;
        <span class="badge-i">I</span> = Izin &nbsp;
        <span class="badge-bl">-</span> = Belum / Tidak ada data
    </div>
</div>

@endsection
