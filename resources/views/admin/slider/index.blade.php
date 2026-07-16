@extends('layouts.admin')
@section('title', 'Manajemen Slider')

@section('content')
<style>
    .page-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
        padding: 1.5rem 2rem;
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
    }
    
    .slider-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .slider-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
    }
    .slider-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    
    .slider-img-wrapper {
        position: relative;
        height: 200px;
        background: #1e293b;
        overflow: hidden;
    }
    .slider-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
        transition: transform 0.5s ease;
    }
    .slider-card:hover .slider-img {
        transform: scale(1.05);
    }
    .slider-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }
    
    .slider-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
    }
    .status-active { background: rgba(16, 185, 129, 0.9); color: #fff; box-shadow: 0 2px 10px rgba(16,185,129,0.4); }
    .status-inactive { background: rgba(100, 116, 139, 0.9); color: #fff; }
    
    .slider-order {
        position: absolute;
        top: 1rem;
        left: 1rem;
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.9);
        color: var(--coklat-tua);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .slider-title {
        color: #fff;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .slider-subtitle {
        color: #cbd5e1;
        font-size: 0.85rem;
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .slider-actions {
        padding: 1rem 1.5rem;
        background: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-act {
        width: 36px; height: 36px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        border: none; transition: all 0.2s;
    }
    .btn-edit { background: #f1f5f9; color: var(--coklat-medium); }
    .btn-edit:hover { background: var(--gold); color: white; }
    .btn-del { background: #fee2e2; color: #ef4444; }
    .btn-del:hover { background: #ef4444; color: white; }
    
    .empty-state {
        grid-column: 1 / -1;
        background: #ffffff;
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
        .page-header .btn-primary {
            width: 100%;
            margin-top: 1rem;
        }
    }
</style>

<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="bi bi-images"></i>
        </div>
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Slider</h4>
            <p class="text-muted small mb-0">Atur gambar banner (carousel) untuk halaman beranda</p>
        </div>
    </div>
    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary px-4 py-2" style="background: linear-gradient(135deg, var(--gold) 0%, var(--coklat-medium) 100%); border: none; border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);">
        <i class="bi bi-plus-lg me-2"></i>Tambah Banner
    </a>
</div>

<div class="slider-grid">
    @forelse($sliders as $slider)
        <div class="slider-card">
            <div class="slider-img-wrapper">
                <div class="slider-order" title="Urutan Tampil">{{ $slider->urutan }}</div>
                <div class="slider-status {{ $slider->aktif ? 'status-active' : 'status-inactive' }}">
                    <i class="bi {{ $slider->aktif ? 'bi-eye-fill' : 'bi-eye-slash-fill' }} me-1"></i>
                    {{ $slider->aktif ? 'AKTIF' : 'TIDAK AKTIF' }}
                </div>
                
                @if($slider->gambar)
                    <img src="{{ asset('images/sliders/' . $slider->gambar) }}" alt="{{ $slider->judul }}" class="slider-img">
                @else
                    <div class="slider-img d-flex align-items-center justify-content-center bg-secondary">
                        <i class="bi bi-image text-white" style="font-size: 2rem;"></i>
                    </div>
                @endif
                
                <div class="slider-overlay">
                    @if($slider->judul)
                        <div class="slider-title">{{ $slider->judul }}</div>
                    @else
                        <div class="slider-title text-muted fst-italic" style="font-size: 1rem;">(Tanpa Judul)</div>
                    @endif
                    
                    @if($slider->subtitle)
                        <div class="slider-subtitle">{{ $slider->subtitle }}</div>
                    @endif
                </div>
            </div>
            
            <div class="slider-actions">
                <div class="text-muted" style="font-size: 0.8rem;">
                    <i class="bi bi-clock-history me-1"></i> Diperbarui {{ $slider->updated_at->diffForHumans() }}
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn-act btn-edit" title="Edit Banner">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST" class="m-0 delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-act btn-del btn-delete-action" title="Hapus Banner">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="mb-4" style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <i class="bi bi-images" style="font-size: 2.5rem; color: #94a3b8;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Belum Ada Banner</h4>
            <p class="text-muted mb-4">Halaman beranda desa Anda saat ini tidak memiliki gambar banner yang bergerak.</p>
            <a href="{{ route('admin.slider.create') }}" class="btn px-4 py-2" style="background: var(--gold); color: white; border-radius: 10px; font-weight: 600;">
                <i class="bi bi-plus-lg me-2"></i>Tambah Banner Sekarang
            </a>
        </div>
    @endforelse
</div>

<div class="pagination-wrapper d-flex justify-content-center">
    {{ $sliders->links('pagination::bootstrap-5') }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Banner?',
                text: "Banner ini akan dihapus dari halaman beranda.",
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
