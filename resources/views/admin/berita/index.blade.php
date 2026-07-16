@extends('layouts.admin')
@section('title', 'Kelola Berita')

@section('content')
<!-- Custom Styles for Premium Grid Layout -->
<style>
    /* Header Area */
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 2rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #f1f5f9;
    }
    .header-icon {
        width: 48px;
        height: 48px;
        background: rgba(201, 150, 58, 0.1);
        color: var(--gold);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Search Bar */
    .search-container {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.25rem 0.5rem;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);
        transition: all 0.3s;
        width: 100%;
        max-width: 320px;
    }
    .search-container:focus-within {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201, 150, 58, 0.1);
    }
    .search-input {
        border: none;
        background: transparent;
        padding: 0.5rem;
        flex-grow: 1;
        outline: none;
        font-size: 0.9rem;
    }
    .search-btn {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 0.5rem;
        border-radius: 8px;
        transition: 0.2s;
    }
    .search-btn:hover {
        color: var(--gold);
        background: rgba(201,150,58,0.1);
    }

    /* Grid Layout */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    /* Premium News Card */
    .news-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border-color: #e2e8f0;
    }

    /* Card Image Area */
    .card-img-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #f8fafc;
    }
    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .news-card:hover .card-img {
        transform: scale(1.08);
    }
    .img-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%);
        pointer-events: none;
    }

    /* Floating Badges */
    .badge-status {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
        z-index: 2;
    }
    .status-publish {
        background: rgba(16, 185, 129, 0.9);
        color: #ffffff;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
    }
    .status-draft {
        background: rgba(100, 116, 139, 0.9);
        color: #ffffff;
    }

    .badge-category {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.3s ease;
    }
    .badge-category i {
        transition: color 0.3s;
    }
    .news-card:hover .badge-category {
        background: var(--gold) !important;
        border-color: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }
    .news-card:hover .badge-category i {
        color: #ffffff !important;
    }

    /* Card Content Area */
    .card-body-custom {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--coklat-tua);
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-meta {
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: auto;
    }
    .card-meta i {
        color: var(--gold);
    }

    /* Action Footer */
    .card-footer-custom {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fafbfc;
    }
    .footer-author {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }
    .action-group {
        display: flex;
        gap: 0.5rem;
    }
    .btn-act {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        font-size: 0.9rem;
    }
    .btn-edit { background: #e0f2fe; color: #0284c7; }
    .btn-edit:hover { background: #0284c7; color: white; transform: translateY(-2px); }
    
    .btn-del { background: #fee2e2; color: #ef4444; }
    .btn-del:hover { background: #ef4444; color: white; transform: translateY(-2px); }

    /* Empty State */
    .empty-state {
        grid-column: 1 / -1;
        background: linear-gradient(to right, #ffffff, #f8fafc);
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        border: 1px dashed #cbd5e1;
    }

    /* Pagination */
    .pagination-wrapper { margin-top: 3rem; }
    .page-item .page-link {
        border-radius: 10px !important;
        margin: 0 4px;
        border: none;
        color: #64748b;
        font-weight: 600;
        min-width: 42px; width: auto; height: 42px;
        padding: 0 14px;
        display: flex; align-items: center; justify-content: center;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(201, 150, 58, 0.4);
    }
    .page-item .page-link:hover:not(.active) {
        transform: translateY(-2px);
        color: var(--coklat-tua);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: stretch;
            padding: 1.25rem;
        }
        .header-actions {
            width: 100%;
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 0.75rem !important;
            margin-top: 1rem;
        }
        .search-container { max-width: 100%; }
        .header-actions .dropdown, .header-actions .dropdown-toggle, .btn-tulis { width: 100%; }
        .header-actions .dropdown-toggle {
            display: flex; justify-content: space-between; align-items: center;
        }
        .header-actions .dropdown-menu { width: 100% !important; }
    }
</style>

<!-- Header Area -->
<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="bi bi-newspaper"></i>
        </div>
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Berita</h4>
            <p class="text-muted small mb-0">Publikasi dan kelola artikel informasi desa</p>
        </div>
    </div>
    
    <div class="header-actions d-flex align-items-center gap-3 flex-wrap">
        
        <!-- Filter Dropdown -->
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 12px; border: 1px solid #e2e8f0; color: #64748b; font-weight: 500; padding: 0.6rem 1rem; background: #ffffff;">
                <span><i class="bi bi-sliders me-1"></i> Filter</span>
                @if(request('tanggal')) <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"><span class="visually-hidden">New alerts</span></span> @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0 mt-2" aria-labelledby="filterDropdown" style="width: 280px; border-radius: 16px;">
                <form action="{{ route('admin.berita.index') }}" method="GET" class="m-0">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <h6 class="dropdown-header px-0 fw-bold text-dark mb-2"><i class="bi bi-calendar-event me-2"></i>Filter Tanggal Terbit</h6>
                    <div class="mb-3">
                        <input type="date" name="tanggal" class="form-control bg-light" value="{{ request('tanggal') }}" style="border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>
                    <div class="d-flex gap-2">
                        @if(request('tanggal'))
                            <a href="{{ route('admin.berita.index', ['search' => request('search')]) }}" class="btn btn-light w-50" style="border-radius: 8px; font-size: 0.85rem;">Reset</a>
                            <button type="submit" class="btn btn-primary w-50" style="background: var(--gold); border: none; border-radius: 8px; font-size: 0.85rem;">Update</button>
                        @else
                            <button type="submit" class="btn btn-primary w-100" style="background: var(--gold); border: none; border-radius: 8px; font-size: 0.85rem;">Terapkan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Text Search -->
        <form action="{{ route('admin.berita.index') }}" method="GET" class="m-0 flex-grow-1">
            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
            <div class="search-container">
                <input type="text" name="search" class="search-input" placeholder="Cari judul / kategori..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-tulis py-2" style="background: linear-gradient(135deg, var(--gold) 0%, var(--coklat-medium) 100%); border: none; border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3); transition: transform 0.2s;">
            <i class="bi bi-plus-lg me-2"></i>Tulis Berita
        </a>
    </div>
</div>

@if(request('search') || request('tanggal'))
<div class="mb-4">
    <div class="alert alert-light border d-inline-block rounded-pill px-4 py-2 shadow-sm">
        <i class="bi bi-funnel me-2 text-gold"></i> Filter aktif: 
        @if(request('search')) <strong>"{{ request('search') }}"</strong> @endif
        @if(request('search') && request('tanggal')) | @endif
        @if(request('tanggal')) Tanggal: <strong>{{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}</strong> @endif
        
        <a href="{{ route('admin.berita.index') }}" class="ms-3 text-danger text-decoration-none"><i class="bi bi-x-circle me-1"></i>Hapus Filter</a>
    </div>
</div>
@endif

<!-- News Grid -->
<div class="news-grid">
    @forelse($beritas as $berita)
        <div class="news-card">
            <!-- Image Area -->
            <div class="card-img-wrapper">
                <div class="badge-status {{ $berita->status == 'publish' ? 'status-publish' : 'status-draft' }}">
                    <i class="bi {{ $berita->status == 'publish' ? 'bi-check-circle' : 'bi-clock-history' }} me-1"></i>
                    {{ strtoupper($berita->status) }}
                </div>
                
                @if($berita->gambar)
                    <img src="{{ asset('images/berita/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="card-img">
                    <div class="img-overlay"></div>
                @else
                    <div class="card-img d-flex flex-column align-items-center justify-content-center text-muted" style="background: #e2e8f0;">
                        <i class="bi bi-image" style="font-size: 2rem; opacity: 0.4;"></i>
                        <span style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">Tanpa Gambar</span>
                    </div>
                @endif
                
                @php
                    // Daftar warna dinamis untuk kategori
                    $catColors = [
                        ['bg' => 'rgba(2, 132, 199, 0.85)', 'icon' => '#38bdf8'], // Ocean Blue
                        ['bg' => 'rgba(16, 185, 129, 0.85)', 'icon' => '#34d399'], // Emerald Green
                        ['bg' => 'rgba(225, 29, 72, 0.85)',  'icon' => '#fb7185'], // Rose Red
                        ['bg' => 'rgba(139, 92, 246, 0.85)', 'icon' => '#a78bfa'], // Violet
                        ['bg' => 'rgba(217, 119, 6, 0.85)',  'icon' => '#fbbf24'], // Amber Gold
                        ['bg' => 'rgba(13, 148, 136, 0.85)', 'icon' => '#2dd4bf'], // Teal
                        ['bg' => 'rgba(71, 85, 105, 0.85)',  'icon' => '#94a3b8'], // Slate Gray
                    ];
                    // Pilih warna berdasarkan kata kategori (konsisten)
                    $colorIndex = abs(crc32(strtolower($berita->kategori))) % count($catColors);
                    $theme = $catColors[$colorIndex];
                @endphp
                
                <div class="badge-category" style="background: {{ $theme['bg'] }};">
                    <i class="bi bi-tag-fill" style="color: {{ $theme['icon'] }};"></i>
                    <span>{{ $berita->kategori }}</span>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="card-body-custom">
                <h3 class="card-title" title="{{ $berita->judul }}">{{ $berita->judul }}</h3>
                <div class="card-meta">
                    <i class="bi bi-calendar3"></i>
                    {{ $berita->published_at ? $berita->published_at->format('d M Y') : 'Belum Terbit' }}
                </div>
            </div>
            
            <!-- Action Footer -->
            <div class="card-footer-custom">
                <div class="footer-author">
                    <i class="bi bi-person-circle me-1"></i> {{ $berita->penulis ?? 'Admin' }}
                </div>
                <div class="action-group">
                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn-act btn-edit" title="Edit Data">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="m-0 delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-act btn-del btn-delete-action" title="Hapus Data">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="mb-4" style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <i class="bi bi-journal-x" style="font-size: 2.5rem; color: #94a3b8;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Belum Ada Artikel</h4>
            <p class="text-muted mb-4">Ruang redaksi masih kosong. Mari mulai menulis berita atau pengumuman pertama untuk warga desa.</p>
            <a href="{{ route('admin.berita.create') }}" class="btn px-4 py-2" style="background: var(--gold); color: white; border-radius: 10px; font-weight: 600;">
                <i class="bi bi-pen me-2"></i>Tulis Berita Pertama
            </a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="pagination-wrapper d-flex justify-content-center">
    {{ $beritas->links('pagination::bootstrap-5') }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Artikel?',
                text: "Artikel yang dihapus tidak bisa dikembalikan lagi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-pill px-4',
                    cancelButton: 'rounded-pill px-4',
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        customClass: { popup: 'rounded-3' }
    });
    @endif
</script>
@endpush
@endsection
