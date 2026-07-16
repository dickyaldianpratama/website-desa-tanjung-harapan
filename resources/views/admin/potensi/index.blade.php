@extends('layouts.admin')
@section('title', 'Potensi Desa')

@section('content')
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
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
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
        max-width: 350px;
    }
    .search-container:focus-within {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
        color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    /* Grid Layout */
    .potensi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    /* Premium Card */
    .potensi-card {
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
    .potensi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border-color: #e2e8f0;
    }

    .card-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        background: #f8fafc;
    }
    .card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .potensi-card:hover .card-img {
        transform: scale(1.08);
    }
    
    .badge-category {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.95);
        color: #10b981;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    
    .card-body-custom {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    .card-desc {
        font-size: 0.9rem;
        color: #64748b;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .card-footer-custom {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background: #fafbfc;
        gap: 0.5rem;
    }
    .btn-act {
        width: 36px;
        height: 36px;
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
        .header-actions form, .btn-tambah { width: 100%; }
    }
</style>

<!-- Header Area -->
<div class="page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="bi bi-tree"></i>
        </div>
        <div>
            <h4 class="fw-bold text-dark mb-1">Potensi Desa</h4>
            <p class="text-muted small mb-0">Kelola dan pamerkan kekayaan serta potensi desa</p>
        </div>
    </div>
    
    <div class="header-actions d-flex align-items-center gap-3 flex-wrap">
        <form action="{{ route('admin.potensi.index') }}" method="GET" class="m-0 flex-grow-1">
            <div class="search-container">
                <input type="text" name="search" class="search-input" placeholder="Cari potensi..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <a href="{{ route('admin.potensi.create') }}" class="btn btn-primary btn-tambah px-4 py-2" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: transform 0.2s;">
            <i class="bi bi-plus-lg me-2"></i>Tambah Potensi
        </a>
    </div>
</div>

@if(request('search'))
<div class="mb-4">
    <div class="alert alert-light border d-inline-block rounded-pill px-4 py-2 shadow-sm">
        <i class="bi bi-info-circle me-2" style="color: #10b981;"></i> Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
        <a href="{{ route('admin.potensi.index') }}" class="ms-3 text-danger text-decoration-none"><i class="bi bi-x-circle me-1"></i>Hapus Filter</a>
    </div>
</div>
@endif

<!-- Potensi Grid -->
<div class="potensi-grid">
    @forelse($potensis as $potensi)
        <div class="potensi-card">
            <div class="card-img-wrapper">
                <div class="badge-category">
                    <i class="bi bi-tags-fill"></i> {{ $potensi->kategori }}
                </div>
                
                @if($potensi->gambar)
                    <img src="{{ asset('images/potensi/' . $potensi->gambar) }}" alt="{{ $potensi->judul }}" class="card-img">
                @else
                    <div class="card-img d-flex flex-column align-items-center justify-content-center text-muted" style="background: #e2e8f0;">
                        <i class="bi bi-image" style="font-size: 2rem; opacity: 0.4;"></i>
                        <span style="font-size: 0.75rem; opacity: 0.6; margin-top: 0.5rem;">Tanpa Gambar</span>
                    </div>
                @endif
            </div>
            
            <div class="card-body-custom">
                <h3 class="card-title" title="{{ $potensi->judul }}">{{ $potensi->judul }}</h3>
                <div class="card-desc">
                    {{ strip_tags($potensi->deskripsi) }}
                </div>
            </div>
            
            <div class="card-footer-custom">
                <a href="{{ route('admin.potensi.edit', $potensi->id) }}" class="btn-act btn-edit" title="Edit Data">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.potensi.destroy', $potensi->id) }}" method="POST" class="m-0 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-act btn-del btn-delete-action" title="Hapus Data">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="mb-4" style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <i class="bi bi-tree" style="font-size: 2.5rem; color: #94a3b8;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Belum Ada Potensi Desa</h4>
            <p class="text-muted mb-4">Pamerkan kekayaan alam, pariwisata, UMKM, atau budaya desa Anda di sini.</p>
            <a href="{{ route('admin.potensi.create') }}" class="btn px-4 py-2" style="background: #10b981; color: white; border-radius: 10px; font-weight: 600;">
                <i class="bi bi-plus-lg me-2"></i>Tambah Data Pertama
            </a>
        </div>
    @endforelse
</div>

<div class="pagination-wrapper d-flex justify-content-center">
    {{ $potensis->links('pagination::bootstrap-5') }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data potensi yang dihapus tidak bisa dikembalikan lagi.",
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
