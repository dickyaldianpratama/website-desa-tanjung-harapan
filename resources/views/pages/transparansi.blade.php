@extends('layouts.app')
@section('title', 'Transparansi Desa')

@push('styles')
<style>
    body {
        background-color: #f8fafc; /* Ultra soft blue-grey */
    }

    /* OVERRIDE NAVBAR */
    .navbar {
        background-color: var(--coklat-tua) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    /* ─── PREMIUM DASHBOARD CARDS ─── */
    .premium-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.03);
        border: none;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .premium-card:hover {
        transform: translateY(-2px);
    }
    
    /* Typography perombakan */
    .premium-title {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: var(--coklat-tua);
        margin-bottom: 0.5rem;
        font-size: clamp(1.2rem, 3vw, 1.6rem); /* Responsive */
        letter-spacing: -0.5px;
    }
    .premium-subtitle {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 2rem;
        letter-spacing: 0.3px;
    }

    /* ─── SUMMARY WIDGETS (Angka Besar) ─── */
    .stat-widget {
        margin-bottom: 2rem;
    }
    .stat-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: clamp(1.8rem, 4vw, 2.2rem); /* Responsive */
        font-weight: 800;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }
    .stat-val-green { color: #10b981; }
    .stat-val-red { color: #f43f5e; }

    /* ─── FLOATING ROW TABLE (APBDes) ─── */
    .table-floating {
        border-collapse: separate;
        border-spacing: 0 12px;
        width: 100%;
        margin-top: -12px;
    }
    .table-floating th {
        border: none;
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0 1.5rem 0.5rem;
        white-space: nowrap; /* Prevent wrapping */
    }
    .table-floating td {
        background: #ffffff;
        padding: 1.25rem 1.5rem;
        border: none;
        vertical-align: middle;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        white-space: nowrap; /* Prevent wrapping */
    }
    .table-floating tr td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .table-floating tr td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .table-floating tbody tr {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .table-floating tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 8px 25px rgba(0,0,0,0.04);
        position: relative;
        z-index: 5;
    }

    /* ─── BLT HIGHLIGHT CARD (Aesthetic Gradient) ─── */
    .blt-showcase {
        background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
        border-radius: 24px;
        padding: 3rem 2rem;
        position: relative;
        overflow: hidden;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 2rem;
    }
    .blt-showcase::after {
        content: '💖';
        position: absolute;
        right: -10%;
        top: -20%;
        font-size: 15rem;
        opacity: 0.05;
        transform: rotate(-15deg);
    }
    .blt-big-number {
        font-size: clamp(2.5rem, 8vw, 4rem); /* Responsive */
        font-weight: 900;
        color: var(--coklat-tua);
        line-height: 1;
        letter-spacing: -3px;
    }

    /* ─── IOS STYLE SEGMENTED CONTROL (Tabs) ─── */
    .ios-tabs-container {
        background-color: #f1f5f9;
        padding: 0.35rem;
        border-radius: 12px;
        display: inline-flex;
        margin-bottom: 2rem;
        position: relative;
        max-width: 100%;
        overflow-x: auto; /* Swipeable tabs */
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Hide scrollbar Firefox */
    }
    .ios-tabs-container::-webkit-scrollbar { display: none; } /* Hide scrollbar Chrome/Safari */
    .ios-tabs-container .nav-pills { flex-wrap: nowrap; }
    
    .ios-tabs-container .nav-item {
        position: relative;
        z-index: 2;
    }
    .ios-tabs-container .nav-link {
        color: #64748b;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
        border: none;
    }
    .ios-tabs-container .nav-link.active {
        color: var(--coklat-tua);
        background: linear-gradient(135deg, var(--gold) 0%, #f59e0b 100%);
        box-shadow: 0 4px 15px rgba(201, 150, 58, 0.4);
        font-weight: 800;
    }

    /* ─── SLIM GLOW LINE PROGRESS BARS ─── */
    .prog-item {
        margin-bottom: 2rem;
    }
    .prog-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 0.6rem;
    }
    .prog-title {
        font-weight: 700;
        color: #334155;
        font-size: 1.05rem;
        margin-bottom: 0;
    }
    .prog-percent {
        font-weight: 800;
        color: var(--gold);
        font-size: 1.2rem;
        letter-spacing: -0.5px;
    }
    .slim-progress-track {
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }
    .slim-progress-fill {
        height: 100%;
        background: var(--gold);
        border-radius: 10px;
        position: relative;
        box-shadow: 0 0 10px rgba(201, 150, 58, 0.5);
        /* Animations */
        width: var(--target-width);
        animation: fillBar 1.5s cubic-bezier(0.1, 0.7, 0.1, 1) forwards;
    }
    .slim-progress-fill.success {
        background: #10b981;
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
    }
    
    /* Shimmer Effect Inside the Fill */
    .slim-progress-fill::after {
        content: '';
        position: absolute;
        top: 0; left: 0; bottom: 0; right: 0;
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
        animation: shimmer 2s infinite linear;
    }

    @keyframes fillBar {
        0% { width: 0; }
        100% { width: var(--target-width); }
    }
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }

    /* Soft Pastel Badges */
    .badge-soft {
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .badge-soft-success { background: #dcfce7; color: #059669; }
    .badge-soft-warning { background: #fef3c7; color: #d97706; }
    .badge-soft-primary { background: #dbeafe; color: #2563eb; }
    
    /* ─── EMOJI WATERMARKS ─── */
    .watermark-emoji {
        position: absolute;
        font-size: 15rem;
        opacity: 0.03;
        z-index: 0;
        pointer-events: none;
        user-select: none;
    }
    .watermark-apbdes { top: -20%; right: -5%; transform: rotate(-10deg); font-size: 18rem; opacity: 0.04; }
    .watermark-kependudukan { bottom: -10%; left: -10%; transform: rotate(15deg); font-size: 16rem; }
    .watermark-pembangunan { bottom: -15%; right: -10%; transform: rotate(-5deg); font-size: 14rem; opacity: 0.05; }
    
    /* Ensure content stays above watermark */
    .premium-card > *:not(.watermark-emoji) { position: relative; z-index: 2; }
    
    /* ─── MOBILE RESPONSIVE TWEAKS ─── */
    @media (max-width: 768px) {
        .premium-card { padding: 1.5rem; }
        .blt-showcase { flex-direction: column; text-align: center; padding: 2rem 1.5rem; }
        .blt-showcase .d-flex { justify-content: center; }
        .blt-divider { width: 100% !important; height: 1px !important; margin: 1.5rem 0; }
        .watermark-emoji { display: none; } /* Hide oversized emoji on narrow screens to prevent mess */
    }

</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="container mt-5 pt-5" data-aos="fade-up">
    <div class="text-center mb-5 mt-4">
        <span class="badge bg-gold text-dark mb-3 px-4 py-2" style="border-radius: 30px; letter-spacing: 2px;">
            <i class="bi bi-gem me-1"></i> RUANG PUBLIK
        </span>
        <h1 class="display-4 fw-black mb-3" style="color: var(--coklat-tua); font-family:'Playfair Display', serif;">Transparansi Desa</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Keterbukaan informasi Anggaran, Demografi, dan Program Kerja secara presisi dan estetis.</p>
    </div>
</div>

<div class="container pb-5" data-aos="fade-up" data-aos-delay="100">
    
    <!-- SECTION 1: APBDES -->
    <div class="premium-card">
        <div class="watermark-emoji watermark-apbdes">🌾</div>
        <div class="row align-items-center">
            
            <!-- APBDes Summary (Left) -->
            <div class="col-lg-4 pe-lg-5">
                <h2 class="premium-title">Ringkasan APBDes</h2>
                <p class="premium-subtitle">Tahun Anggaran {{ $tahun }}</p>
                
                @php
                    $pendapatan = $apbdes->where('jenis', 'pendapatan')->sum('anggaran');
                    $belanja = $apbdes->where('jenis', 'belanja')->sum('anggaran');
                    if($pendapatan == 0) $pendapatan = 1500000000;
                    if($belanja == 0) $belanja = 1450000000;
                @endphp
                
                <div class="stat-widget">
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-value stat-val-green">Rp {{ number_format($pendapatan/1000000, 0, ',', '.') }}<span style="font-size:1rem;color:#94a3b8;font-weight:600"> Juta</span></div>
                </div>
                <div class="stat-widget">
                    <div class="stat-label">Total Belanja</div>
                    <div class="stat-value stat-val-red">Rp {{ number_format($belanja/1000000, 0, ',', '.') }}<span style="font-size:1rem;color:#94a3b8;font-weight:600"> Juta</span></div>
                </div>
                
                <a href="#" class="btn btn-dark mt-3 rounded-pill px-4 py-2" style="background:var(--coklat-tua); border:none;">
                    <i class="bi bi-download me-2"></i> Unduh Laporan Resmi
                </a>
            </div>
            
            <!-- APBDes Chart (Right) -->
            <div class="col-lg-8 mt-5 mt-lg-0">
                <div id="apbdes_3d_chart" style="width: 100%; height: 380px;"></div>
            </div>
            
        </div>

        <!-- Rincian Interaktif (Accordion) -->
        <div class="mt-5 pt-3">
            <h5 class="fw-bold mb-4" style="color:#334155; font-size:1.1rem;">Rincian APBDes Interaktif</h5>
            
            <div class="accordion" id="accordionApbdes">
                <!-- Pendapatan -->
                <div class="accordion-item border-0 mb-3" style="border-radius:16px; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h2 class="accordion-header" id="headingPendapatan">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePendapatan" aria-expanded="false" aria-controls="collapsePendapatan" style="background:#f8fafc; color:#334155; padding: 1.25rem 1.5rem;">
                            <i class="bi bi-arrow-down-circle-fill text-success me-3 fs-4"></i> Rincian Pendapatan Desa
                        </button>
                    </h2>
                    <div id="collapsePendapatan" class="accordion-collapse collapse" aria-labelledby="headingPendapatan" data-bs-parent="#accordionApbdes">
                        <div class="accordion-body p-0">
                            <table class="table table-hover mb-0" style="font-size:0.95rem;">
                                <thead style="background:#f1f5f9; color:#64748b; font-size:0.8rem; text-transform:uppercase;">
                                    <tr><th class="ps-4 py-3">Uraian</th><th class="text-end py-3">Anggaran</th><th class="text-end pe-4 py-3">Realisasi</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($apbdes->where('jenis', 'pendapatan') as $p)
                                    <tr>
                                        <td class="ps-4 py-3 fw-semibold text-dark">{{ $p->uraian }}</td>
                                        <td class="text-end py-3 text-muted">Rp {{ number_format($p->anggaran, 0, ',', '.') }}</td>
                                        <td class="text-end pe-4 py-3 text-success fw-bold">Rp {{ number_format($p->realisasi, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Data pendapatan belum tersedia</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Belanja -->
                <div class="accordion-item border-0" style="border-radius:16px; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <h2 class="accordion-header" id="headingBelanja">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBelanja" aria-expanded="false" aria-controls="collapseBelanja" style="background:#f8fafc; color:#334155; padding: 1.25rem 1.5rem;">
                            <i class="bi bi-arrow-up-circle-fill text-danger me-3 fs-4"></i> Rincian Belanja Desa
                        </button>
                    </h2>
                    <div id="collapseBelanja" class="accordion-collapse collapse" aria-labelledby="headingBelanja" data-bs-parent="#accordionApbdes">
                        <div class="accordion-body p-0">
                            <table class="table table-hover mb-0" style="font-size:0.95rem;">
                                <thead style="background:#f1f5f9; color:#64748b; font-size:0.8rem; text-transform:uppercase;">
                                    <tr><th class="ps-4 py-3">Uraian</th><th class="text-end py-3">Anggaran</th><th class="text-end pe-4 py-3">Realisasi</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($apbdes->where('jenis', 'belanja') as $b)
                                    <tr>
                                        <td class="ps-4 py-3 fw-semibold text-dark">{{ $b->uraian }}</td>
                                        <td class="text-end py-3 text-muted">Rp {{ number_format($b->anggaran, 0, ',', '.') }}</td>
                                        <td class="text-end pe-4 py-3 text-danger fw-bold">Rp {{ number_format($b->realisasi, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="text-center py-4 text-muted">Data belanja belum tersedia</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: BLT HIGHLIGHT -->
    <div class="blt-showcase" data-aos="fade-up">
        <div style="max-width: 500px; position:relative; z-index:2;">
            <div class="badge-soft badge-soft-primary mb-3 d-inline-block">DANA SOSIAL</div>
            <h2 class="premium-title" style="font-size:2rem;">Bantuan Langsung Tunai</h2>
            <p class="text-muted" style="font-size:1.05rem;">Komitmen desa dalam menyalurkan jaring pengaman sosial tepat sasaran bagi keluarga prasejahtera.</p>
        </div>
        
        <div class="d-flex gap-4 align-items-center" style="position:relative; z-index:2;">
            <div>
                <div class="blt-big-number">{{ $blt['penerima_kk'] }}</div>
                <div class="stat-label mt-2 text-dark">Kepala Keluarga</div>
            </div>
            <div class="blt-divider" style="width:1px; height:60px; background:#cbd5e1;"></div>
            <div>
                <div class="blt-big-number" style="color:#10b981;">{{ $blt['persentase_tersalurkan'] }}%</div>
                <div class="stat-label mt-2 text-dark">Tersalurkan</div>
            </div>
        </div>
    </div>

    <!-- SECTION 3 & 4 (Splitted Grid) -->
    <div class="row">
        
        <!-- SECTION 3: KEPENDUDUKAN (TABS) -->
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="premium-card" style="height: calc(100% - 2rem);">
                <div class="watermark-emoji watermark-kependudukan">🏡</div>
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h2 class="premium-title">Demografi Warga</h2>
                        <div class="stat-label">Total {{ number_format($kependudukan['total'], 0, ',', '.') }} Jiwa</div>
                    </div>
                </div>
                
                <!-- iOS Style Tabs -->
                <div class="ios-tabs-container">
                    <ul class="nav nav-pills gap-1" id="demografi-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="usia-tab" data-bs-toggle="pill" data-bs-target="#usia" type="button" role="tab">Usia</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pendidikan-tab" data-bs-toggle="pill" data-bs-target="#pendidikan" type="button" role="tab">Pendidikan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pekerjaan-tab" data-bs-toggle="pill" data-bs-target="#pekerjaan" type="button" role="tab">Pekerjaan</button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="demografi-tabContent">
                    
                    <!-- TAB USIA -->
                    <div class="tab-pane fade show active" id="usia" role="tabpanel">
                        <div class="d-flex gap-4 mb-3 px-3">
                            <div>
                                <span class="d-flex align-items-center gap-2 mb-1"><span class="rounded-circle" style="width:10px;height:10px;background:#3b82f6;"></span> <small class="fw-bold text-muted">Laki-laki</small></span>
                                <span class="fs-4 fw-black" style="color:#334155;">{{ number_format($kependudukan['pria'], 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="d-flex align-items-center gap-2 mb-1"><span class="rounded-circle" style="width:10px;height:10px;background:#ec4899;"></span> <small class="fw-bold text-muted">Perempuan</small></span>
                                <span class="fs-4 fw-black" style="color:#334155;">{{ number_format($kependudukan['wanita'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div id="chart_usia" style="min-height: 280px; margin-left:-15px;"></div>
                    </div>
                    
                    <!-- TAB PENDIDIKAN -->
                    <div class="tab-pane fade" id="pendidikan" role="tabpanel">
                        <div id="chart_pendidikan" class="d-flex justify-content-center align-items-center" style="min-height: 320px;"></div>
                    </div>
                    
                    <!-- TAB PEKERJAAN -->
                    <div class="tab-pane fade" id="pekerjaan" role="tabpanel">
                        <div id="chart_pekerjaan" style="min-height: 320px; margin-left:-10px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: REALISASI PROGRAM -->
        <div class="col-lg-5">
            <div class="premium-card" style="height: calc(100% - 2rem);">
                <div class="watermark-emoji watermark-pembangunan">🚜</div>
                <h2 class="premium-title">Kinerja Pembangunan</h2>
                <p class="premium-subtitle">Pantauan proyek strategis berjalan</p>
                
                <div class="mt-4">
                    @foreach($program as $prog)
                    <div class="prog-item">
                        <div class="prog-header">
                            <h4 class="prog-title">{{ $prog['nama'] }}</h4>
                            <span class="prog-percent {{ $prog['progress'] == 100 ? 'text-success' : '' }}">{{ $prog['progress'] }}%</span>
                        </div>
                        <div class="slim-progress-track">
                            <div class="slim-progress-fill {{ $prog['progress'] == 100 ? 'success' : '' }}" style="--target-width: {{ $prog['progress'] }}%;"></div>
                        </div>
                        @if($prog['progress'] == 100)
                            <div class="text-success mt-2" style="font-size:0.75rem; font-weight:700;"><i class="bi bi-check2-circle me-1"></i>PROYEK SELESAI</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // 1. GOOGLE CHARTS 3D (APBDes)
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Kategori', 'Jumlah'],
            @forelse($apbdes->where('jenis', 'belanja') as $b)
                ['{{ $b->uraian }}', {{ $b->anggaran }}],
            @empty
                ['Belum Ada Data', 1]
            @endforelse
        ]);

        var options = {
            is3D: true,
            backgroundColor: 'transparent',
            legend: { position: window.innerWidth < 768 ? 'bottom' : 'right', textStyle: { color: '#64748b', fontSize: 13, fontName: 'Plus Jakarta Sans', bold: true } },
            colors: ['#c9963a', '#10b981', '#3b82f6', '#ef4444'],
            chartArea: { width: '100%', height: '80%' },
            pieSliceText: 'percentage',
            pieSliceTextStyle: { fontSize: 12, bold: true },
        };

        var chart = new google.visualization.PieChart(document.getElementById('apbdes_3d_chart'));
        chart.draw(data, options);
    }
    window.addEventListener('resize', drawChart);

    // APEXCHARTS RENDERERS
    document.addEventListener("DOMContentLoaded", function() {
        
        // 2A. TAB USIA (Modern Spline-like Bar)
        var optUsia = {
            series: [{ name: 'Laki-laki', data: [350, 280, 750, 270] }, 
                     { name: 'Perempuan', data: [320, 260, 720, 300] }],
            chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans, sans-serif' },
            plotOptions: { bar: { horizontal: false, columnWidth: '40%', borderRadius: 6 } }, // Lebih langsing dan bulat
            dataLabels: { enabled: false },
            stroke: { show: true, width: 4, colors: ['transparent'] },
            xaxis: { categories: ['Anak', 'Pemuda', 'Dewasa', 'Lansia'], axisBorder: {show:false}, axisTicks:{show:false}, labels:{style:{colors:'#94a3b8', fontWeight:600}} },
            yaxis: { labels: { style:{colors:'#94a3b8', fontWeight:600} } },
            fill: { opacity: 1 },
            colors: ['#3b82f6', '#ec4899'],
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: { theme: 'light', y: { formatter: function (val) { return val + " Jiwa" } } }
        };
        new ApexCharts(document.querySelector("#chart_usia"), optUsia).render();

        // 2B. TAB PENDIDIKAN (Donut Chart)
        var dataPendidikan = @json(array_values($kependudukan['pendidikan']));
        var labelPendidikan = @json(array_keys($kependudukan['pendidikan']));
        var optPendidikan = {
            series: dataPendidikan,
            labels: labelPendidikan,
            chart: { type: 'donut', height: 320, fontFamily: 'Plus Jakarta Sans' },
            colors: ['#6366f1', '#14b8a6', '#f59e0b', '#ec4899', '#64748b'], // Palette premium
            plotOptions: {
                pie: {
                    donut: { size: '70%', labels: { show: true, name: { color: '#64748b' }, value: { fontSize: '24px', fontWeight: 800, color: '#334155' } } },
                    expandOnClick: false
                }
            },
            dataLabels: { enabled: false },
            stroke: { width: 3, colors: ['#ffffff'] },
            legend: { position: 'right', fontSize: '13px', fontWeight: 600, labels: { colors: '#64748b' }, markers: { width: 10, height: 10, radius: 10 } }
        };
        var chartPend = new ApexCharts(document.querySelector("#chart_pendidikan"), optPendidikan);
        var pendRendered = false;
        document.getElementById('pendidikan-tab').addEventListener('shown.bs.tab', function () {
            if(!pendRendered) { chartPend.render(); pendRendered = true; }
        });

        // 2C. TAB PEKERJAAN (Horizontal Bar)
        var dataPekerjaan = @json(array_values($kependudukan['pekerjaan']));
        var labelPekerjaan = @json(array_keys($kependudukan['pekerjaan']));
        var optPekerjaan = {
            series: [{ name: 'Jumlah', data: dataPekerjaan }],
            chart: { type: 'bar', height: 320, toolbar: { show: false }, fontFamily: 'Plus Jakarta Sans' },
            plotOptions: { bar: { horizontal: true, borderRadius: 6, distributed: true, barHeight: '50%' } },
            colors: ['#0ea5e9', '#8b5cf6', '#10b981', '#f59e0b', '#f43f5e', '#94a3b8'],
            dataLabels: { enabled: true, formatter: function(val) { return val; }, style: { colors: ['#ffffff'], fontWeight: 800 } },
            xaxis: { labels: {show:false}, axisBorder: {show:false}, axisTicks: {show:false} },
            yaxis: { labels: { style: { colors: '#64748b', fontWeight: 600 } } },
            grid: { show: false },
            legend: { show: false }
        };
        var chartPek = new ApexCharts(document.querySelector("#chart_pekerjaan"), optPekerjaan);
        var pekRendered = false;
        document.getElementById('pekerjaan-tab').addEventListener('shown.bs.tab', function () {
            if(!pekRendered) { chartPek.render(); pekRendered = true; }
        });

    });
</script>
@endpush
