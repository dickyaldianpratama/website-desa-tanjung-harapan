@extends('layouts.app')
@section('title', 'Data Statistik')

@push('styles')
<style>
    .page-header-bg {
        background: linear-gradient(135deg, var(--coklat-tua) 0%, #1a0f05 100%);
        padding: 80px 0 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .breadcrumb-desa a { color: var(--gold); text-decoration: none; }
    .breadcrumb-desa a:hover { color: #fff; text-decoration: underline; }
    .breadcrumb-item.active { color: #ddd; }

    /* Navigasi Sidebar */
    .nav-statistik-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #eee;
        position: sticky;
        top: 100px;
    }
    .nav-header {
        background: #b71c1c; /* Warna merah seperti referensi */
        color: #fff;
        padding: 15px 20px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Poppins', sans-serif;
    }
    .nav-header-mobile {
        background: #fdf1f1;
        color: #b71c1c;
        padding: 15px 20px;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid #f9e3e3;
    }
    .nav-header-mobile[aria-expanded="true"] i {
        transform: rotate(180deg);
        transition: 0.3s;
    }
    .nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .nav-item-stat {
        border-bottom: 1px solid #f0f0f0;
    }
    .nav-item-stat:last-child { border-bottom: none; }
    
    .nav-link-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        color: #444;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .nav-link-stat:hover, .nav-link-stat.active-parent {
        background: #fcfcfc;
        color: #b71c1c;
    }
    .nav-link-stat i.bi-chevron-down { transition: transform 0.3s; }
    .nav-link-stat[aria-expanded="true"] i.bi-chevron-down { transform: rotate(180deg); }
    .nav-link-stat i.icon-main { width: 25px; text-align: center; margin-right: 8px; color: #666; }
    .nav-link-stat:hover i.icon-main, .nav-link-stat.active-parent i.icon-main { color: #b71c1c; }

    .subnav-list {
        list-style: none;
        padding: 10px 0 10px 45px;
        margin: 0;
        background: #fafafa;
        border-left: 3px solid #b71c1c;
    }
    .subnav-link {
        display: block;
        padding: 8px 15px;
        color: #555;
        text-decoration: none;
        font-size: 0.95rem;
        transition: 0.2s;
        border-radius: 6px 0 0 6px;
    }
    .subnav-link:hover, .subnav-link.active {
        background: #f0f0f0;
        color: #b71c1c;
        font-weight: 600;
    }

    /* Content Area */
    .stat-content-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        padding: 30px;
        border: 1px solid #eee;
    }
    .stat-title-wrap {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }
    .stat-title-icon {
        background: #b71c1c;
        color: #fff;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .stat-title-text {
        font-weight: 700;
        font-size: 1.3rem;
        color: #2c3e50;
        margin: 0;
        line-height: 1.4;
    }

    .table-container {
        border: 1px solid #ebebeb;
        border-radius: 10px;
        overflow: hidden;
    }
    .table-header-custom {
        background: #fdfdfd;
        padding: 15px 20px;
        font-weight: 700;
        border-bottom: 1px solid #ebebeb;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #b71c1c;
    }
    .table-stat { margin: 0; }
    .table-stat thead th {
        background: #111;
        color: #fff;
        border: none;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }
    .table-stat tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f0f0f0;
        color: #444;
    }
    .table-stat tbody tr:last-child td { border-bottom: none; }
    .table-stat tbody tr:hover { background: #fafafa; }
    
    .table-total {
        font-weight: 700;
        color: #b71c1c !important;
        text-align: right;
    }
    .link-dusun {
        color: #1a73e8;
        text-decoration: none;
        font-weight: 500;
    }
    .link-dusun:hover { text-decoration: underline; color: #1152a3; }
</style>
@endpush

@section('content')

<!-- Header -->
<div class="page-header-bg">
    <div class="container position-relative z-1">
        <nav aria-label="breadcrumb" class="breadcrumb-desa mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i> Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Statistik</li>
            </ol>
        </nav>
        <h1 class="display-5 font-serif fw-bold text-white mb-2">Data Statistik Desa</h1>
        <p class="lead text-white-50 mb-0">Kumpulan data administratif dan kependudukan masyarakat desa.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Navigasi -->
        <div class="col-lg-3">
            <div class="nav-statistik-card">
                <!-- Header Desktop -->
                <div class="nav-header d-none d-lg-flex">
                    <i class="bi bi-pie-chart-fill"></i> Navigasi Statistik
                </div>
                
                <!-- Toggle Mobile (Accordion Header) -->
                <a href="#navStatistikMobile" data-bs-toggle="collapse" class="nav-header-mobile d-flex d-lg-none justify-content-between align-items-center">
                    <div>Data Statistik</div>
                    <i class="bi bi-chevron-down"></i>
                </a>

                <div class="collapse d-lg-block" id="navStatistikMobile">
                    <ul class="nav-list">
                        <li class="nav-item-stat">
                            @php $isPenduduk = in_array($jenis, ['agama','pekerjaan','pendidikan','umur','perkawinan','wilayah']); @endphp
                            <a href="#menuPenduduk" class="nav-link-stat {{ $isPenduduk ? 'active-parent' : '' }}" data-bs-toggle="collapse" aria-expanded="{{ $isPenduduk ? 'true' : 'false' }}">
                                <div>Statistik Penduduk</div>
                                <i class="bi bi-chevron-down" style="font-size:0.8rem"></i>
                            </a>
                            <div class="collapse {{ $isPenduduk ? 'show' : '' }}" id="menuPenduduk">
                                <ul class="subnav-list">
                                    <li><a href="{{ route('statistik.show', 'wilayah') }}" class="subnav-link {{ $jenis == 'wilayah' ? 'active' : '' }}">Data Wilayah</a></li>
                                    <li><a href="{{ route('statistik.show', 'agama') }}" class="subnav-link {{ $jenis == 'agama' ? 'active' : '' }}">Agama</a></li>
                                    <li><a href="{{ route('statistik.show', 'pekerjaan') }}" class="subnav-link {{ $jenis == 'pekerjaan' ? 'active' : '' }}">Pekerjaan</a></li>
                                    <li><a href="{{ route('statistik.show', 'pendidikan') }}" class="subnav-link {{ $jenis == 'pendidikan' ? 'active' : '' }}">Pendidikan</a></li>
                                    <li><a href="{{ route('statistik.show', 'umur') }}" class="subnav-link {{ $jenis == 'umur' ? 'active' : '' }}">Umur</a></li>
                                    <li><a href="{{ route('statistik.show', 'perkawinan') }}" class="subnav-link {{ $jenis == 'perkawinan' ? 'active' : '' }}">Perkawinan</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item-stat">
                            <a href="{{ route('statistik.show', 'keluarga') }}" class="nav-link-stat {{ $jenis == 'keluarga' ? 'active-parent' : '' }}">
                                <div>Statistik Keluarga</div>
                            </a>
                        </li>
                        <li class="nav-item-stat">
                            <a href="#" class="nav-link-stat">
                                <div>Statistik Bantuan</div>
                                <i class="bi bi-chevron-down" style="font-size:0.8rem"></i>
                            </a>
                        </li>
                        <li class="nav-item-stat">
                            <a href="#" class="nav-link-stat">
                                <div>Statistik Lainnya</div>
                                <i class="bi bi-chevron-down" style="font-size:0.8rem"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="stat-content-card">
                
                @if($jenis == 'wilayah')
                    <div class="stat-title-wrap">
                        <div class="stat-title-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <h2 class="stat-title-text">Jumlah dan Persentase Penduduk Berdasarkan Wilayah Dusun di {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}, {{ date('Y') }}</h2>
                    </div>

                    <div class="table-container">
                        <div class="table-header-custom">
                            <i class="bi bi-table"></i> Data Wilayah Administratif
                        </div>
                        <div class="table-responsive">
                            <table class="table table-stat">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Wilayah Dusun</th>
                                        <th class="text-center">KK</th>
                                        <th class="text-center">L+P</th>
                                        <th class="text-center">L</th>
                                        <th class="text-center">P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>
                                            <a href="https://docs.google.com/spreadsheets/d/1QEhKsH3GG-UANc32xkpfGXYhulNvAVnHxu8uY66r7EU/edit?gid=2004923148#gid=2004923148" target="_blank" class="link-dusun">Dusun 1 <i class="bi bi-box-arrow-up-right ms-1" style="font-size:0.75rem"></i></a>
                                        </td>
                                        <td class="text-center">82</td>
                                        <td class="text-center">216</td>
                                        <td class="text-center">111</td>
                                        <td class="text-center">105</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>
                                            <a href="https://docs.google.com/spreadsheets/d/1mDNg53Xk2n0yIQ2y7cNwKHsciC4-klgyEAUGkpC8a4o/edit?gid=2004923148#gid=2004923148" target="_blank" class="link-dusun">Dusun 2 <i class="bi bi-box-arrow-up-right ms-1" style="font-size:0.75rem"></i></a>
                                        </td>
                                        <td class="text-center">174</td>
                                        <td class="text-center">440</td>
                                        <td class="text-center">220</td>
                                        <td class="text-center">220</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>
                                            <a href="https://docs.google.com/spreadsheets/d/1MljmMpCDAKDo-LQBuEDSGDkFDkh2x8DEFkxCr3v2olw/edit?gid=2004923148#gid=2004923148" target="_blank" class="link-dusun">Dusun 3 <i class="bi bi-box-arrow-up-right ms-1" style="font-size:0.75rem"></i></a>
                                        </td>
                                        <td class="text-center">196</td>
                                        <td class="text-center">510</td>
                                        <td class="text-center">243</td>
                                        <td class="text-center">267</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>
                                            <a href="https://docs.google.com/spreadsheets/d/1YNNKrbbEVE77nkuERs06RJ-wcC8t2lR4tOBryoaI1PU/edit?gid=285984163#gid=285984163" target="_blank" class="link-dusun">Dusun 4 <i class="bi bi-box-arrow-up-right ms-1" style="font-size:0.75rem"></i></a>
                                        </td>
                                        <td class="text-center">130</td>
                                        <td class="text-center">348</td>
                                        <td class="text-center">163</td>
                                        <td class="text-center">185</td>
                                    </tr>
                                    <tr style="background: #fafafa;">
                                        <td colspan="2" class="table-total">TOTAL</td>
                                        <td class="text-center fw-bold text-danger">582</td>
                                        <td class="text-center fw-bold text-danger">{{ $settings['penduduk_total'] ?? '1514' }}</td>
                                        <td class="text-center fw-bold text-danger">{{ $settings['penduduk_laki'] ?? '737' }}</td>
                                        <td class="text-center fw-bold text-danger">{{ $settings['penduduk_perempuan'] ?? '777' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                @else
                    <!-- Tampilan Placeholder untuk Statistik Lainnya (karena belum ada data detail) -->
                    <div class="stat-title-wrap">
                        <div class="stat-title-icon" style="background:#555"><i class="bi bi-info-circle-fill"></i></div>
                        <h2 class="stat-title-text">Statistik {{ ucfirst($jenis) }}</h2>
                    </div>
                    <div class="text-center py-5">
                        <img src="{{ asset('images/empty-state.svg') }}" onerror="this.style.display='none'" alt="Empty" style="width: 200px; opacity: 0.5; margin-bottom: 20px;">
                        <h4 class="fw-bold text-muted">Data Sedang Diperbarui</h4>
                        <p class="text-muted">Data statistik untuk kategori <strong>{{ ucfirst($jenis) }}</strong> saat ini sedang dalam proses rekapitulasi oleh perangkat desa.</p>
                        <a href="{{ route('statistik.show', 'wilayah') }}" class="btn btn-desa-primary mt-3">Lihat Data Wilayah</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
