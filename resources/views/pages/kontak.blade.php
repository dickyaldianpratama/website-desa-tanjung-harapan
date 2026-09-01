@extends('layouts.app')
@section('title', 'Kontak & Layanan')

@push('styles')
<style>
    body { background-color: #f8fafc; }
    
    /* OVERRIDE NAVBAR */
    .navbar { background-color: var(--coklat-tua) !important; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }

    /* GENERAL CARD STYLE */
    .contact-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.04);
        padding: 2.5rem;
        margin-bottom: 2rem;
        border: none;
    }
    
    .contact-title {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        color: var(--coklat-tua);
        margin-bottom: 1.5rem;
        font-size: 1.6rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    .contact-title::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 50px; height: 3px; background: var(--gold); border-radius: 3px;
    }

    /* FLOATING TABLE STYLE (From Transparansi) */
    .table-floating {
        border-collapse: separate; border-spacing: 0 10px; width: 100%; margin-top: -10px;
    }
    .table-floating td {
        background: #ffffff;
        padding: 1rem 1.5rem;
        border: none;
        vertical-align: middle;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .table-floating tr td:first-child {
        border-top-left-radius: 10px; border-bottom-left-radius: 10px;
        font-weight: 600; color: #475569; width: 35%;
    }
    .table-floating tr td:last-child {
        border-top-right-radius: 10px; border-bottom-right-radius: 10px;
        color: #1e293b; font-weight: 500;
    }
    .table-floating tbody tr:hover td {
        background: #fdfdfd; box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    }

    /* MAPS CONTAINER */
    .map-container {
        width: 100%; height: 350px; border-radius: 16px; overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05); border: 2px solid #f1f5f9;
    }
    .map-container iframe { width: 100%; height: 100%; border: 0; }

    /* FORM PENGADUAN */
    .form-control, .form-select {
        border-radius: 10px; padding: 0.75rem 1rem; border: 1px solid #cbd5e1;
        background: #f8fafc; transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        background: #ffffff; border-color: var(--gold); box-shadow: 0 0 0 4px rgba(201, 150, 58, 0.15);
    }
    .form-label { font-weight: 600; color: #475569; margin-bottom: 0.5rem; }
    
    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white; border: none; padding: 0.8rem 2rem; border-radius: 10px;
        font-weight: 700; transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover {
        transform: translateY(-2px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); color: white;
    }

    /* SIDEBAR STYLES */
    .kades-profile {
        text-align: center; background: #ffffff; border-radius: 20px;
        padding: 2rem; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.04); margin-bottom: 2rem;
    }
    .kades-img-wrapper {
        width: 150px; height: 150px; margin: 0 auto 1.5rem;
        border-radius: 50%; padding: 5px; background: linear-gradient(135deg, var(--gold) 0%, var(--coklat-tua) 100%);
    }
    .kades-img-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 3px solid #ffffff; }
    
    .sidebar-title {
        background: var(--coklat-tua); color: white; padding: 0.75rem 1.5rem;
        border-radius: 10px; font-weight: 700; margin-bottom: 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .sidebar-title span { font-size: 0.8rem; background: var(--gold); color: var(--coklat-tua); padding: 2px 8px; border-radius: 20px; }
    
    .news-item { display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-start; }
    .news-item img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; }
    .news-content h6 { font-size: 0.9rem; font-weight: 700; color: #334155; margin-bottom: 0.2rem; line-height: 1.3; }
    .news-content a { color: inherit; text-decoration: none; transition: color 0.2s; }
    .news-content a:hover { color: var(--gold); }
    .news-date { font-size: 0.75rem; color: #94a3b8; }

    @media (max-width: 768px) {
        .contact-card { padding: 1.5rem; }
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="container mt-5 pt-5" data-aos="fade-up">
    <div class="text-center mb-5 mt-4">
        <span class="badge bg-gold text-dark mb-3 px-4 py-2" style="border-radius: 30px; letter-spacing: 2px;">
            <i class="bi bi-headset me-1"></i> LAYANAN MASYARAKAT
        </span>
        <h1 class="display-4 fw-black mb-3" style="color: var(--coklat-tua); font-family:'Playfair Display', serif;">Kontak & Pelayanan</h1>
        <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 1.1rem;">Informasi kontak resmi, lokasi kantor, dan layanan aspirasi warga Desa Tanjung Harapan.</p>
    </div>
</div>

<div class="container pb-5">
    
    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4 border-0 shadow-sm d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        @if(session('wa_link'))
            <script>
                setTimeout(function() {
                    window.open('{{ session("wa_link") }}', '_blank');
                }, 1500);
            </script>
        @endif
    @endif

    <div class="row g-5">
        <!-- LEFT COLUMN (70%) -->
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            
            <!-- INFORMASI KONTAK DESA -->
            <div class="contact-card bg-light">
                <h3 class="contact-title">Informasi Desa Tanjung Harapan</h3>
                <div class="table-responsive">
                    <table class="table-floating">
                        <tbody>
                            <tr>
                                <td><i class="bi bi-geo-alt-fill text-danger me-2"></i> Alamat Kantor</td>
                                <td>{{ $settings['alamat_desa'] ?? 'Jl. Poros Tanjung Harapan No. 1, Kecamatan X, Kabupaten Y' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone-fill text-success me-2"></i> No. Telepon / WA</td>
                                <td>{{ $settings['telepon_desa'] ?? '0812-3456-7890' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-envelope-fill text-primary me-2"></i> Email Resmi</td>
                                <td>{{ $settings['email_desa'] ?? 'pemdes@tanjungharapan.desa.id' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-clock-fill text-warning me-2"></i> Jam Pelayanan</td>
                                <td>{{ $settings['jam_kerja'] ?? 'Senin - Jumat (08:00 - 15:00 WIB)' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- NOMOR TELEPON PENTING -->
            <div class="contact-card">
                <h3 class="contact-title text-danger">Nomor Telepon Penting</h3>
                @php
                    $teleponPenting = json_decode($settings['telepon_penting'] ?? '[]', true) ?? [];
                @endphp
                @if(count($teleponPenting) > 0)
                <div class="table-responsive">
                    <table class="table-floating">
                        <tbody>
                            @foreach($teleponPenting as $tp)
                            @if(!empty($tp['jabatan']) || !empty($tp['nomor']))
                            <tr>
                                <td>
                                    <i class="bi {{ $tp['ikon'] ?? 'bi-telephone-fill' }} text-primary me-2"></i>
                                    {{ $tp['jabatan'] ?? '-' }}
                                </td>
                                <td>
                                    @if(!empty($tp['nomor']))
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $tp['nomor']) }}"
                                           class="text-decoration-none fw-semibold text-dark">
                                            {{ $tp['nomor'] }}
                                        </a>
                                    @else
                                        <span class="text-muted fst-italic">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-telephone-x display-6 d-block mb-2 opacity-50"></i>
                    <p class="small mb-1">Belum ada nomor telepon penting.</p>
                    <a href="{{ route('admin.setting.index') }}" class="btn btn-sm btn-outline-warning mt-1">
                        <i class="bi bi-gear me-1"></i> Atur di Panel Admin
                    </a>
                </div>
                @endif
            </div>


            <!-- LOKASI KANTOR -->
            <div class="contact-card p-0 overflow-hidden">
                <div class="p-4 pb-0">
                    <h3 class="contact-title">Peta Lokasi Kantor Desa</h3>
                </div>
                {{-- Peta Lokasi --}}
                <div class="map-container rounded-0 border-0 mt-3">
                    @if(!empty($settings['link_map']))
                        <iframe src="{{ $settings['link_map'] }}"
                                allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @else
                        {{--
                            PENTING: Gunakan URL format /maps/embed?pb=...
                            BUKAN link share biasa (maps.app.goo.gl atau google.com/maps)
                            karena Google memblokir URL biasa di dalam iframe.
                        --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63686.87!2d101.08267!3d0.03289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d562fc967fd8e3%3A0xbf7c72be4b207359!2sTj.%20Harapan%2C%20Kec.%20Kampar%20Kiri%2C%20Kabupaten%20Kampar%2C%20Riau!5e0!3m2!1sid!2sid!4v1724200000000!5m2!1sid!2sid"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @endif
                </div>
            </div>

            <!-- FORM PENGADUAN -->
            <div class="contact-card" id="form-pengaduan">
                <h3 class="contact-title">Kirim Aspirasi & Pengaduan</h3>
                <p class="text-muted mb-4">Sampaikan kritik, saran, atau laporan kejadian di lingkungan desa. Pesan Anda akan langsung dikirimkan ke WhatsApp Admin Desa kami.</p>
                
                <form action="{{ route('kontak.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="telepon" required placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori Pesan <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="Aspirasi / Saran">Aspirasi / Saran</option>
                                <option value="Pengaduan Infrastruktur">Pengaduan Infrastruktur</option>
                                <option value="Laporan Keamanan">Laporan Keamanan</option>
                                <option value="Layanan Administrasi">Layanan Administrasi / Surat</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subjek <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subjek" required placeholder="Judul singkat laporan Anda">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Isi Pesan / Keterangan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="pesan" rows="5" required placeholder="Tuliskan pesan Anda secara detail..."></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn-submit w-100">
                                <i class="bi bi-whatsapp me-2"></i> Kirim Pesan via WhatsApp
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <!-- RIGHT COLUMN (30%) SIDEBAR -->
        <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
            
            <!-- PROFIL KADES WIDGET -->
            <div class="kades-profile">
                <div class="kades-img-wrapper">
                    @if(isset($kades) && $kades->foto)
                        <img src="{{ Storage::disk('s3')->url('images/perangkat/' . $kades->foto) }}" alt="{{ $kades->nama }}">
                    @else
                        <img src="{{ Storage::disk('s3')->url('images/perangkat/kades.jpg') }}" onerror="this.src='{{ asset('images/hero-placeholder.jpg') }}'" alt="Kepala Desa">
                    @endif
                </div>
                <h4 class="fw-bold text-dark mb-1">{{ $kades->nama ?? 'Nama Belum Diatur' }}</h4>
                <p class="text-muted small fw-bold mb-3 text-uppercase">{{ $kades->jabatan ?? 'Kepala Desa' }}</p>
                <hr class="opacity-10 my-3">
                <p class="small text-muted fst-italic">"Melayani dengan Hati, Membangun {{ $settings['nama_desa'] ?? 'Desa' }} yang Mandiri dan Bermartabat."</p>
            </div>

            <!-- POS TERBARU WIDGET -->
            <div class="sidebar-widget">
                <div class="sidebar-title">
                    Berita Terbaru <span>Update</span>
                </div>
                <div class="bg-white rounded-4 p-3 shadow-sm border border-light">
                    @forelse($beritas as $berita)
                        <div class="news-item {{ !$loop->last ? 'border-bottom pb-3' : '' }}">
                            <img src="{{ $berita->gambar ? Storage::disk('s3')->url('images/berita/' . $berita->gambar) : 'https://placehold.co/150x150/f1f5f9/94a3b8?text=News' }}" alt="{{ $berita->judul }}">
                            <div class="news-content">
                                <h6><a href="{{ route('berita.show', $berita->slug) }}">{{ Str::limit($berita->judul, 40) }}</a></h6>
                                <div class="news-date"><i class="bi bi-calendar-event me-1"></i>{{ $berita->published_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted small py-3">Belum ada berita.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
