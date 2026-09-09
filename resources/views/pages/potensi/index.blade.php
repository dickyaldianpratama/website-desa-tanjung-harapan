@extends('layouts.app')
@section('title', 'Potensi Desa')

@push('styles')
<style>
    /* OVERRIDE NAVBAR */
    .navbar {
        background-color: var(--coklat-tua) !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    /* SECTION TITLE */
    .section-title {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        margin-bottom: 2rem;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--gold);
        border-radius: 3px;
    }

    /* WISATA CARDS (Large Horizontal) */
    .wisata-card {
        background: var(--putih);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        margin-bottom: 2rem;
        display: flex;
        flex-direction: column;
    }
    @media (min-width: 992px) {
        .wisata-card { flex-direction: row; }
    }
    .wisata-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .wisata-img-wrap {
        position: relative;
        flex: 1;
        min-height: 250px;
    }
    @media (min-width: 992px) {
        .wisata-img-wrap { max-width: 50%; }
    }
    .wisata-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0; left: 0;
    }
    .wisata-body {
        flex: 1;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* UMKM CARDS (Product Grid) */
    .umkm-card {
        background: var(--putih);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .umkm-card:hover {
        border-color: var(--gold);
        box-shadow: 0 10px 25px rgba(201, 150, 58, 0.15);
    }
    .umkm-img-wrap {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        background: #f8f9fa;
    }
    .umkm-img-wrap img {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
    }
    .umkm-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: white;
    }

    /* PERTANIAN CARDS (Vertical Info) */
    .tani-card {
        background: #F4F9F4; /* Light green tint */
        border-radius: 16px;
        padding: 2rem;
        height: 100%;
        border: 1px solid rgba(46, 125, 50, 0.1);
        transition: transform 0.3s ease;
    }
    .tani-card:hover {
        transform: translateY(-5px);
        background: #E8F5E9;
    }
    .tani-icon {
        width: 60px; height: 60px;
        background: #2E7D32;
        color: white;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }
    
    /* SIDEBAR WIDGETS */
    .widget-profil-desa {
        background: var(--putih);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .widget-profil-desa .widget-header {
        background: linear-gradient(135deg, #a71d2a 0%, #7b111b 100%);
        color: white;
        padding: 1rem 1.25rem;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
    }
    .widget-profil-desa .nav-tabs {
        border-bottom: 1px solid #eee;
        flex-wrap: nowrap;
    }
    .widget-profil-desa .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #888;
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.8rem 0.5rem;
        border-radius: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: transparent;
    }
    .widget-profil-desa .nav-tabs .nav-link:hover {
        color: #a71d2a;
    }
    .widget-profil-desa .nav-tabs .nav-link.active {
        color: #a71d2a;
        border-bottom: 2px solid #C9963A; /* Warna gold sebagai indikator aktif sesuai tema */
    }
    .widget-profil-desa .table-profil {
        margin-bottom: 0;
    }
    .widget-profil-desa .table-profil td {
        padding: 0.85rem 1rem;
        font-size: 0.85rem;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .widget-profil-desa .table-profil tr:last-child td {
        border-bottom: none;
    }
    .widget-profil-desa .table-profil .col-label {
        color: #444;
        font-weight: 500;
        width: 40%;
    }
    .widget-profil-desa .table-profil .col-value {
        color: #6c757d;
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="container mt-5 pt-5" data-aos="fade-up">
    <div class="text-center mb-5 mt-4">
        <span class="badge bg-gold text-dark mb-2 px-3 py-2"><i class="bi bi-stars me-1"></i> KEKAYAAN DESA</span>
        <h1 class="display-5 fw-bold" style="color: var(--teks-gelap);">Potensi Desa</h1>
        <p class="text-muted">Menjelajahi kekayaan alam, budaya, dan kreativitas warga {{ $settings['nama_desa'] ?? 'Desa' }}</p>
    </div>
</div>

<section class="py-5 bg-cream">
    <div class="container py-4">
        <div class="row g-5">
            {{-- KOLOM UTAMA (Potensi Desa) --}}
            <div class="col-lg-8">
                @forelse($groupedPotensi as $kategori => $items)
                <div class="mb-5 pb-3">
                    <h2 class="fw-bold section-title text-capitalize" data-aos="fade-right">{{ $kategori }}</h2>
                    <div class="row g-4 mt-2">
                        @foreach($items as $item)
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="tani-card" style="background:var(--putih); padding:1.5rem; border-radius:12px; border:1px solid rgba(0,0,0,0.08); height:100%; display:flex; flex-direction:column; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                <div class="tani-img-wrap mb-3" style="height: 200px; border-radius: 12px; overflow: hidden; position:relative;">
                                    @if($item->gambar)
                                        <img src="{{ Storage::disk('s3')->url('images/potensi/' . $item->gambar) }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/hero-placeholder.jpg') }}" alt="{{ $item->judul }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                </div>
                                <h4 class="fw-bold mb-3" style="font-size: 1.25rem;">{{ $item->judul }}</h4>
                                <p class="text-muted mb-4" style="flex-grow:1; font-size: 0.9rem;">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('potensi.show', $item->slug) }}" class="btn btn-outline-dark flex-grow-1 btn-sm py-2">Selengkapnya</a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['telepon'] ?? '6281234567890') }}?text=Halo%20Admin,%20saya%20tertarik%20dengan%20Potensi%20Desa:%20{{ urlencode($item->judul) }}" target="_blank" class="btn btn-success px-3 btn-sm d-flex align-items-center justify-content-center" title="Hubungi">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder-x display-1 text-muted mb-3 d-block"></i>
                    <h4 class="text-muted">Belum ada data potensi desa.</h4>
                </div>
                @endforelse
            </div>

            {{-- KOLOM SIDEBAR --}}
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="position-sticky" style="top: 100px;">
                    
                    {{-- WIDGET PROFIL DESA --}}
                    <div class="widget-profil-desa mb-4">
                        <div class="widget-header">
                            <i class="bi bi-folder2-open me-2 fs-5"></i> PROFIL DESA
                        </div>
                        
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="profilDesaTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100 active" id="ekologi-tab" data-bs-toggle="tab" data-bs-target="#ekologi-pane" type="button" role="tab" aria-controls="ekologi-pane" aria-selected="true">
                                    Ekologi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100" id="internet-tab" data-bs-toggle="tab" data-bs-target="#internet-pane" type="button" role="tab" aria-controls="internet-pane" aria-selected="false">
                                    Internet
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link w-100" id="status-tab" data-bs-toggle="tab" data-bs-target="#status-pane" type="button" role="tab" aria-controls="status-pane" aria-selected="false">
                                    Status Desa
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content" id="profilDesaTabContent">
                            <!-- Tab Ekologi -->
                            <div class="tab-pane fade show active" id="ekologi-pane" role="tabpanel" aria-labelledby="ekologi-tab" tabindex="0">
                                <table class="table table-borderless table-profil">
                                    <tbody>
                                        <tr>
                                            <td class="col-label">Jenis Tanah</td>
                                            <td class="col-value">Sawah</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Topografi</td>
                                            <td class="col-value">Datar</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Sumber Daya Alam</td>
                                            <td class="col-value">Air dan Hutan</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Flora Fauna</td>
                                            <td class="col-value">Jenis Tumbuhan dan Hewan yang ada di Desa</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Rawan Bencana</td>
                                            <td class="col-value">Tanah Longsor</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Kearifan Lokal</td>
                                            <td class="col-value">Tradisi dan Budaya</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Tab Internet -->
                            <div class="tab-pane fade" id="internet-pane" role="tabpanel" aria-labelledby="internet-tab" tabindex="0">
                                <table class="table table-borderless table-profil">
                                    <tbody>
                                        <tr>
                                            <td class="col-label">Sinyal Seluler</td>
                                            <td class="col-value">4G / Kuat</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Jaringan</td>
                                            <td class="col-value">Telkomsel, Indosat, XL</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Akses Fiber</td>
                                            <td class="col-value">Tersedia (IndiHome, dll)</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Lokasi Wifi Gratis</td>
                                            <td class="col-value">Kantor Desa & Balai Pertemuan</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Kondisi BTS</td>
                                            <td class="col-value">Berfungsi Baik</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Tab Status Desa -->
                            <div class="tab-pane fade" id="status-pane" role="tabpanel" aria-labelledby="status-tab" tabindex="0">
                                <table class="table table-borderless table-profil">
                                    <tbody>
                                        <tr>
                                            <td class="col-label">Status IDM</td>
                                            <td class="col-value fw-bold text-success">Desa Berkembang</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Skor IDM</td>
                                            <td class="col-value">0.7123</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Tahun Data</td>
                                            <td class="col-value">2023 / 2024</td>
                                        </tr>
                                        <tr>
                                            <td class="col-label">Status Kemendes</td>
                                            <td class="col-value">Mandiri / Tertinggal</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    {{-- WIDGET LAYANAN CEPAT (Tambahan agar Sidebar lebih berisi) --}}
                    <div class="widget-profil-desa mb-4">
                        <div class="widget-header" style="background: linear-gradient(135deg, var(--coklat-tua) 0%, var(--coklat-medium) 100%);">
                            <i class="bi bi-telephone-fill me-2 fs-5"></i> LAYANAN CEPAT
                        </div>
                        <div class="p-3">
                            <p class="text-muted small mb-3">Butuh bantuan terkait potensi desa, pengajuan proposal, atau informasi wisata?</p>
                            <a href="{{ route('kontak') }}" class="btn btn-gold w-100 mb-2 py-2 fw-bold text-dark"><i class="bi bi-chat-dots me-2"></i>Hubungi Kami</a>
                            <a href="{{ route('layanan.index') }}" class="btn btn-outline-dark w-100 py-2 fw-bold"><i class="bi bi-laptop me-2"></i>E-Layanan Desa</a>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</section>

@endsection
