@extends('layouts.app')

@section('title', 'Data Kependudukan - ' . ucfirst($kategori))

@push('styles')
<style>
/* CSS Sidebar Navigasi Statistik */
.nav-statistik-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    overflow: hidden;
}
.nav-statistik-header {
    background: #3b2314; /* Coklat Tua */
    color: #fff;
    padding: 15px 20px;
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 10px;
}
.nav-statistik-header i {
    color: var(--gold, #C9963A);
}
.nav-statistik-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.nav-statistik-item {
    border-bottom: 1px solid #f0f0f0;
}
.nav-statistik-item:last-child {
    border-bottom: none;
}
.nav-statistik-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    color: #333;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    transition: all 0.3s ease;
}
.nav-statistik-link:hover {
    background: #faf8f5;
    color: var(--gold, #C9963A);
}
.nav-statistik-link.active {
    color: var(--gold, #C9963A);
    font-weight: 600;
}
.nav-statistik-sublist {
    list-style: none;
    padding: 10px 0 10px 0;
    margin: 0;
    background: #fdfbf9;
    border-left: 3px solid var(--gold, #C9963A);
}
.nav-statistik-subitem a {
    display: block;
    padding: 8px 20px 8px 40px;
    color: #555;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}
.nav-statistik-subitem a:hover {
    color: var(--gold, #C9963A);
}
.nav-statistik-subitem a.active {
    font-weight: 600;
    color: #3b2314;
}

/* CSS Konten Statistik */
.statistik-content-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 30px;
    min-height: 500px;
}
.statistik-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    color: #003366; /* Warna biru sesuai gambar "Jumlah dan Persentase Penduduk..." */
    font-size: 1.4rem;
    line-height: 1.4;
    margin-bottom: 25px;
}

.alert-rekapitulasi {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    padding: 20px;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    color: #856404;
}

/* Custom Nav Pills for Dusun Tabs */
.dusun-tabs-wrapper .nav-pills .nav-link {
    background: #f8f9fa;
    color: #555;
    transition: all 0.3s ease;
}
.dusun-tabs-wrapper .nav-pills .nav-link:hover {
    background: #e9ecef;
}
.dusun-tabs-wrapper .nav-pills .nav-link.active {
    background: var(--gold, #C9963A);
    color: #fff;
    box-shadow: 0 4px 10px rgba(201,150,58,0.3);
}
.dusun-tabs-wrapper::-webkit-scrollbar {
    display: none;
}

@media (max-width: 768px) {
    .iframe-container {
        height: 450px !important;
    }
    .statistik-title {
        font-size: 1.1rem;
    }
}
</style>
@endpush

@section('content')
<div class="container py-5 mt-4">
    <div class="row g-4">
        
        <!-- SIDEBAR -->
        <div class="col-lg-4">
            <div class="nav-statistik-card">
                <div class="nav-statistik-header">
                    <i class="bi bi-pie-chart-fill"></i> Navigasi Statistik
                </div>
                <ul class="nav-statistik-list">
                    <li class="nav-statistik-item">
                        <a href="#" class="nav-statistik-link" data-bs-toggle="collapse" data-bs-target="#collapsePenduduk" aria-expanded="true">
                            Statistik Penduduk <i class="bi bi-chevron-up"></i>
                        </a>
                        <ul class="nav-statistik-sublist collapse show" id="collapsePenduduk">
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'wilayah') }}" class="{{ $kategori == 'wilayah' ? 'active' : '' }}">Data Wilayah</a>
                            </li>
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'agama') }}" class="{{ $kategori == 'agama' ? 'active' : '' }}">Agama</a>
                            </li>
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'pekerjaan') }}" class="{{ $kategori == 'pekerjaan' ? 'active' : '' }}">Pekerjaan</a>
                            </li>
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'pendidikan') }}" class="{{ $kategori == 'pendidikan' ? 'active' : '' }}">Pendidikan</a>
                            </li>
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'umur') }}" class="{{ $kategori == 'umur' ? 'active' : '' }}">Umur</a>
                            </li>
                            <li class="nav-statistik-subitem">
                                <a href="{{ route('kependudukan.show', 'perkawinan') }}" class="{{ $kategori == 'perkawinan' ? 'active' : '' }}">Perkawinan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-statistik-item">
                        <a href="#" class="nav-statistik-link">Statistik Keluarga</a>
                    </li>
                    <li class="nav-statistik-item">
                        <a href="#" class="nav-statistik-link">Statistik Bantuan <i class="bi bi-chevron-down"></i></a>
                    </li>
                    <li class="nav-statistik-item">
                        <a href="#" class="nav-statistik-link">Statistik Lainnya <i class="bi bi-chevron-down"></i></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-8">
            <div class="statistik-content-card">
                @php
                    $judul = $kategori == 'wilayah' ? 'Wilayah Dusun' : ucfirst($kategori);
                @endphp
                <h3 class="statistik-title">Jumlah dan Persentase Penduduk Berdasarkan {{ $judul }} di Desa Tanjung Harapan, 2026</h3>
                
                <!-- Tabs untuk Dusun 1, 2, 3, 4 -->
                <div class="dusun-tabs-wrapper">
                    <ul class="nav nav-pills mb-4 flex-nowrap overflow-auto pb-2" id="dusunTab" role="tablist" style="scrollbar-width: none; -ms-overflow-style: none;">
                        @php $i = 0; @endphp
                        @foreach($sheets as $dusun => $link)
                            <li class="nav-item" role="presentation" style="flex-shrink: 0;">
                                <button class="nav-link {{ $i == 0 ? 'active' : '' }} px-4 py-2" id="tab-{{ Str::slug($dusun) }}" data-bs-toggle="tab" data-bs-target="#content-{{ Str::slug($dusun) }}" type="button" role="tab" style="font-family: 'Poppins', sans-serif; font-weight: 600; border-radius: 50px; margin-right: 10px;">
                                    {{ $dusun }}
                                </button>
                            </li>
                            @php $i++; @endphp
                        @endforeach
                    </ul>
                </div>
                
                <div class="tab-content" id="dusunTabContent">
                    @php $i = 0; @endphp
                    @foreach($sheets as $dusun => $link)
                        <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="content-{{ Str::slug($dusun) }}" role="tabpanel">
                            <div class="iframe-container" style="position: relative; width: 100%; height: 600px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
                                <iframe src="{{ $link }}" style="border:0; width:100%; height:100%;" allowfullscreen></iframe>
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
