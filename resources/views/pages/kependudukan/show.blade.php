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
.nav-statistik-subitem .active {
    background: #f8f9fa;
    color: var(--gold, #C9963A);
    font-weight: 600;
}
.nav-statistik-subitem .active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: var(--gold, #C9963A);
}
/* Rotate chevron logic */
.nav-statistik-link[aria-expanded="true"] .bi-chevron-down {
    transform: rotate(180deg);
}
.nav-statistik-link i.bi-chevron-down {
    transition: transform 0.3s ease;
}

/* CSS Konten Statistik */
.statistik-content-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 30px;
}
.statistik-title {
    font-family: 'Poppins', sans-serif;
    color: #003366;
    font-weight: 700;
    margin-bottom: 30px;
    line-height: 1.4;
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
<div class="container py-5 mt-5 pt-5">
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
                            Statistik Penduduk <i class="bi bi-chevron-down"></i>
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
                        <a href="#" class="nav-statistik-link">Statistik Keluarga <i class="bi bi-chevron-down"></i></a>
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
                
                <div class="row g-4 mb-5">
                    @if($kategori == 'wilayah')
                        <!-- DATA WILAYAH -->
                        @php
                            $wilayahData = [
                                ['nama' => 'Dusun 1', 'total' => 148, 'laki' => 82, 'perempuan' => 66, 'kk' => 45],
                                ['nama' => 'Dusun 2', 'total' => 83, 'laki' => 47, 'perempuan' => 36, 'kk' => 45],
                                ['nama' => 'Dusun 3', 'total' => 176, 'laki' => 94, 'perempuan' => 82, 'kk' => 45],
                                ['nama' => 'Dusun 4', 'total' => 212, 'laki' => 108, 'perempuan' => 104, 'kk' => 65],
                            ];
                            $totalPenduduk = array_sum(array_column($wilayahData, 'total'));
                        @endphp
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center align-middle" style="font-family: 'Poppins', sans-serif;">
                                    <thead style="background-color: var(--gold, #C9963A); color: #fff;">
                                        <tr>
                                            <th>Wilayah / Dusun</th>
                                            <th>Laki-Laki</th>
                                            <th>Perempuan</th>
                                            <th>Total Penduduk</th>
                                            <th>Jumlah KK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($wilayahData as $w)
                                        <tr>
                                            <td class="fw-bold text-start">{{ $w['nama'] }}</td>
                                            <td>{{ $w['laki'] }} Jiwa</td>
                                            <td>{{ $w['perempuan'] }} Jiwa</td>
                                            <td class="fw-bold" style="color: #003366;">{{ $w['total'] }} Jiwa</td>
                                            <td>{{ $w['kk'] }} KK</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot style="background-color: #f8f9fa; font-weight: bold;">
                                        <tr>
                                            <td class="text-start">TOTAL KESELURUHAN</td>
                                            <td>{{ array_sum(array_column($wilayahData, 'laki')) }} Jiwa</td>
                                            <td>{{ array_sum(array_column($wilayahData, 'perempuan')) }} Jiwa</td>
                                            <td style="color: #003366;">{{ $totalPenduduk }} Jiwa</td>
                                            <td>{{ array_sum(array_column($wilayahData, 'kk')) }} KK</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    @elseif($kategori == 'agama')
                        <!-- DATA AGAMA -->
                        @php
                            $agamaData = [
                                ['nama' => 'Islam', 'jumlah' => 540, 'color' => '#28a745'],
                                ['nama' => 'Kristen', 'jumlah' => 72, 'color' => '#17a2b8'],
                                ['nama' => 'Katholik', 'jumlah' => 7, 'color' => '#ffc107'],
                                ['nama' => 'Hindu', 'jumlah' => 0, 'color' => '#dc3545'],
                                ['nama' => 'Buddha', 'jumlah' => 0, 'color' => '#6c757d'],
                                ['nama' => 'Konghucu', 'jumlah' => 0, 'color' => '#343a40'],
                            ];
                            $totalAgama = array_sum(array_column($agamaData, 'jumlah'));
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-4">
                                @foreach($agamaData as $a)
                                    @php $persen = $totalAgama > 0 ? round(($a['jumlah'] / $totalAgama) * 100, 1) : 0; @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-family: 'Poppins', sans-serif;">
                                            <span class="fw-bold">{{ $a['nama'] }}</span>
                                            <span class="text-muted">{{ $a['jumlah'] }} Jiwa ({{ $persen }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $a['color'] }};" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($kategori == 'pekerjaan')
                        <!-- DATA PEKERJAAN -->
                        @php
                            $pekerjaanData = [
                                ['nama' => 'Petani / Pekebun', 'jumlah' => 101, 'color' => '#28a745'],
                                ['nama' => 'Mengurus Rumah Tangga', 'jumlah' => 156, 'color' => '#17a2b8'],
                                ['nama' => 'Pelajar / Mahasiswa', 'jumlah' => 73, 'color' => '#ffc107'],
                                ['nama' => 'Wiraswasta / Pedagang', 'jumlah' => 63, 'color' => '#fd7e14'],
                                ['nama' => 'PNS / TNI / POLRI', 'jumlah' => 0, 'color' => '#007bff'],
                                ['nama' => 'Pegawai Swasta', 'jumlah' => 4, 'color' => '#6610f2'],
                                ['nama' => 'Belum / Tidak Bekerja', 'jumlah' => 215, 'color' => '#6c757d'],
                                ['nama' => 'Pekerjaan Lainnya', 'jumlah' => 7, 'color' => '#343a40'],
                            ];
                            $totalPekerjaan = array_sum(array_column($pekerjaanData, 'jumlah'));
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-4 mt-2">
                                @if($totalPekerjaan == 0) <div class="alert alert-info">Grafik akan muncul setelah angka data dimasukkan.</div> @endif
                                @foreach($pekerjaanData as $p)
                                    @php $persen = $totalPekerjaan > 0 ? round(($p['jumlah'] / $totalPekerjaan) * 100, 1) : 0; @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-family: 'Poppins', sans-serif;">
                                            <span class="fw-bold">{{ $p['nama'] }}</span>
                                            <span class="text-muted">{{ $p['jumlah'] }} Jiwa ({{ $persen }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $p['color'] }};" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($kategori == 'pendidikan')
                        <!-- DATA PENDIDIKAN -->
                        @php
                            $pendidikanData = [
                                ['nama' => 'Belum / Tidak Sekolah', 'jumlah' => 169, 'color' => '#6c757d'],
                                ['nama' => 'Belum Tamat SD', 'jumlah' => 89, 'color' => '#dc3545'],
                                ['nama' => 'Tamat SD / Sederajat', 'jumlah' => 190, 'color' => '#fd7e14'],
                                ['nama' => 'SMP / Sederajat', 'jumlah' => 78, 'color' => '#ffc107'],
                                ['nama' => 'SMA / Sederajat', 'jumlah' => 82, 'color' => '#28a745'],
                                ['nama' => 'Diploma (D1-D3)', 'jumlah' => 3, 'color' => '#17a2b8'],
                                ['nama' => 'Sarjana (S1/D4)', 'jumlah' => 8, 'color' => '#007bff'],
                                ['nama' => 'Magister / Doktor', 'jumlah' => 0, 'color' => '#6610f2'],
                            ];
                            $totalPendidikan = array_sum(array_column($pendidikanData, 'jumlah'));
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-4 mt-2">
                                @if($totalPendidikan == 0) <div class="alert alert-info">Grafik akan muncul setelah angka data dimasukkan.</div> @endif
                                @foreach($pendidikanData as $p)
                                    @php $persen = $totalPendidikan > 0 ? round(($p['jumlah'] / $totalPendidikan) * 100, 1) : 0; @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-family: 'Poppins', sans-serif;">
                                            <span class="fw-bold">{{ $p['nama'] }}</span>
                                            <span class="text-muted">{{ $p['jumlah'] }} Jiwa ({{ $persen }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $p['color'] }};" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($kategori == 'umur')
                        <!-- DATA UMUR -->
                        @php
                            $umurData = [
                                ['nama' => '0 - 4 Tahun (Balita)', 'jumlah' => 31, 'color' => '#17a2b8'],
                                ['nama' => '5 - 14 Tahun (Anak-Anak)', 'jumlah' => 103, 'color' => '#28a745'],
                                ['nama' => '15 - 64 Tahun (Produktif)', 'jumlah' => 467, 'color' => '#007bff'],
                                ['nama' => '65+ Tahun (Lansia)', 'jumlah' => 18, 'color' => '#fd7e14'],
                            ];
                            $totalUmur = array_sum(array_column($umurData, 'jumlah'));
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-4 mt-2">
                                @if($totalUmur == 0) <div class="alert alert-info">Grafik akan muncul setelah angka data dimasukkan.</div> @endif
                                @foreach($umurData as $u)
                                    @php $persen = $totalUmur > 0 ? round(($u['jumlah'] / $totalUmur) * 100, 1) : 0; @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-family: 'Poppins', sans-serif;">
                                            <span class="fw-bold">{{ $u['nama'] }}</span>
                                            <span class="text-muted">{{ $u['jumlah'] }} Jiwa ({{ $persen }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $u['color'] }};" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    @elseif($kategori == 'perkawinan')
                        <!-- DATA PERKAWINAN -->
                        @php
                            $perkawinanData = [
                                ['nama' => 'Belum Kawin', 'jumlah' => 294, 'color' => '#17a2b8'],
                                ['nama' => 'Kawin', 'jumlah' => 312, 'color' => '#28a745'],
                                ['nama' => 'Cerai Hidup', 'jumlah' => 2, 'color' => '#fd7e14'],
                                ['nama' => 'Cerai Mati', 'jumlah' => 11, 'color' => '#dc3545'],
                            ];
                            $totalPerkawinan = array_sum(array_column($perkawinanData, 'jumlah'));
                        @endphp
                        <div class="col-12">
                            <div class="card border-0 shadow-sm p-4 mt-2">
                                @if($totalPerkawinan == 0) <div class="alert alert-info">Grafik akan muncul setelah angka data dimasukkan.</div> @endif
                                @foreach($perkawinanData as $p)
                                    @php $persen = $totalPerkawinan > 0 ? round(($p['jumlah'] / $totalPerkawinan) * 100, 1) : 0; @endphp
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1" style="font-family: 'Poppins', sans-serif;">
                                            <span class="fw-bold">{{ $p['nama'] }}</span>
                                            <span class="text-muted">{{ $p['jumlah'] }} Jiwa ({{ $persen }}%)</span>
                                        </div>
                                        <div class="progress" style="height: 12px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $p['color'] }};" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-12 text-center text-muted py-5">
                            Kategori tidak ditemukan.
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
