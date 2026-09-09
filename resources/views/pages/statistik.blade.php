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

    .page-statistik-wrapper {
        font-family: 'Poppins', sans-serif !important;
        font-size: 0.9rem;
    }

    /* Navigasi Sidebar */
    .nav-statistik-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(84, 58, 20, 0.08); /* Shadow tema coklat lembut */
        overflow: hidden;
        border: none;
        position: sticky;
        top: 100px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .nav-statistik-card:hover {
        box-shadow: 0 12px 35px rgba(84, 58, 20, 0.12);
    }
    .nav-header {
        background: linear-gradient(135deg, var(--coklat-tua) 0%, #3a250b 100%);
        color: #fff;
        padding: 15px 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: 0.5px;
    }
    .nav-header-mobile {
        background: #faf8f5;
        color: var(--coklat-tua);
        padding: 12px 20px;
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid #f0eae1;
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
        border-bottom: 1px solid #f9f9f9;
    }
    .nav-item-stat:last-child { border-bottom: none; }
    
    .nav-link-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        color: #555;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .nav-link-stat:hover, .nav-link-stat.active-parent {
        background: #faf8f5;
        color: var(--coklat-tua);
        padding-left: 25px; /* Efek bergeser halus */
    }
    .nav-link-stat i.bi-chevron-down { transition: transform 0.3s; }
    .nav-link-stat[aria-expanded="true"] i.bi-chevron-down { transform: rotate(180deg); }
    .nav-link-stat i.icon-main { width: 25px; text-align: center; margin-right: 8px; color: #888; transition: 0.3s; }
    .nav-link-stat:hover i.icon-main, .nav-link-stat.active-parent i.icon-main { color: var(--gold); }

    .subnav-list {
        list-style: none;
        padding: 8px 0 8px 45px;
        margin: 0;
        background: #fafafa;
        border-left: 3px solid var(--gold);
    }
    .subnav-link {
        display: block;
        padding: 6px 15px;
        color: #666;
        text-decoration: none;
        font-size: 0.85rem;
        transition: 0.3s ease;
        border-radius: 6px 0 0 6px;
    }
    .subnav-link:hover, .subnav-link.active {
        background: #fdfaf5;
        color: var(--coklat-tua);
        font-weight: 600;
        transform: translateX(4px);
    }

    /* Content Area */
    .stat-content-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 25px rgba(84, 58, 20, 0.08);
        padding: 25px;
        border: none;
        transition: box-shadow 0.3s ease;
    }
    .stat-content-card:hover {
        box-shadow: 0 12px 35px rgba(84, 58, 20, 0.12);
    }
    .stat-title-wrap {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .stat-title-icon {
        background: linear-gradient(135deg, var(--gold) 0%, #a87928 100%);
        color: #fff;
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(201, 150, 58, 0.3);
    }
    .stat-title-text {
        font-weight: 600;
        font-size: 1.15rem;
        color: var(--coklat-tua);
        margin: 0;
        line-height: 1.4;
    }

    .table-container {
        border: 1px solid #f0eae1;
        border-radius: 8px;
        overflow: hidden;
    }
    .table-header-custom {
        background: #faf8f5;
        padding: 12px 20px;
        font-weight: 600;
        border-bottom: 1px solid #f0eae1;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--coklat-tua);
    }
    .table-stat { margin: 0; font-size: 0.85rem; }
    .table-stat thead th {
        background: var(--coklat-tua);
        color: #fff;
        border: none;
        padding: 12px 15px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-stat tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #f0eae1;
        color: #555;
    }
    .table-stat tbody tr:last-child td { border-bottom: none; }
    .table-stat tbody tr:hover { background: #fafafa; }
    
    .table-total {
        font-weight: 600;
        color: var(--coklat-tua) !important;
        text-align: right;
    }
</style>
@endpush

@section('content')
<div class="page-statistik-wrapper">

<!-- Header -->
<div class="page-header-bg">
    <div class="container position-relative z-1">
        <nav aria-label="breadcrumb" class="breadcrumb-desa mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bi bi-house-door-fill"></i> Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Statistik</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">Data Statistik Desa</h1>
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
                                        <td class="fw-medium text-dark">Dusun 1</td>
                                        <td class="text-center">82</td>
                                        <td class="text-center">216</td>
                                        <td class="text-center">111</td>
                                        <td class="text-center">105</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td class="fw-medium text-dark">Dusun 2</td>
                                        <td class="text-center">174</td>
                                        <td class="text-center">440</td>
                                        <td class="text-center">220</td>
                                        <td class="text-center">220</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td class="fw-medium text-dark">Dusun 3</td>
                                        <td class="text-center">196</td>
                                        <td class="text-center">510</td>
                                        <td class="text-center">243</td>
                                        <td class="text-center">267</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td class="fw-medium text-dark">Dusun 4</td>
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

</div>
@endsection
