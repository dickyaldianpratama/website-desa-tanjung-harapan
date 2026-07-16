@extends('layouts.admin')
@section('title', 'Perangkat Desa')

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
        background: rgba(201, 150, 58, 0.1);
        color: #c9963a;
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
        border-color: #c9963a;
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
        color: #c9963a;
        background: rgba(201, 150, 58, 0.1);
    }

    /* Grid ID Card */
    .perangkat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    /* ID Card Design */
    .id-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
    }
    .id-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(201, 150, 58, 0.15);
        border-color: #ebd4a5;
    }

    /* Bagian Atas Card (Coklat Tua ke Emas) */
    .id-card-header {
        background: linear-gradient(135deg, #3d1f0a 0%, #683918 100%);
        height: 100px;
        position: relative;
    }
    .badge-urutan {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255,255,255,0.2);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    /* Foto Profil Melayang */
    .id-card-photo-wrapper {
        width: 120px;
        height: 120px;
        margin: -60px auto 0;
        border-radius: 50%;
        background: #ffffff;
        padding: 5px;
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .id-card-photo {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #f1f5f9;
    }

    /* Konten Teks */
    .id-card-body {
        padding: 1.5rem;
    }
    .id-card-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    .id-card-position {
        font-size: 0.85rem;
        color: #c9963a;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }
    .id-card-nip {
        font-size: 0.85rem;
        color: #64748b;
        background: #f8fafc;
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    /* Tombol Aksi */
    .id-card-footer {
        padding: 1rem;
        background: #f8fafc;
        border-top: 1px dashed #cbd5e1;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    .btn-act {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .btn-edit { background: #fef9f0; color: #a67828; }
    .btn-edit:hover { background: #c9963a; color: white; transform: translateY(-2px); }
    
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
            <i class="bi bi-people-fill"></i>
        </div>
        <div>
            <h4 class="fw-bold text-dark mb-1">Perangkat Desa</h4>
            <p class="text-muted small mb-0">Manajemen struktur organisasi dan pejabat desa</p>
        </div>
    </div>
    
    <div class="header-actions d-flex align-items-center gap-3 flex-wrap">
        <form action="{{ route('admin.perangkat.index') }}" method="GET" class="m-0 flex-grow-1">
            <div class="search-container">
                <input type="text" name="search" class="search-input" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}">
                <button type="submit" class="search-btn"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <a href="{{ route('admin.perangkat.create') }}" class="btn btn-primary btn-tambah px-4 py-2" style="background: linear-gradient(135deg, #c9963a 0%, #a67828 100%); border: none; border-radius: 12px; font-weight: 600; box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3); transition: transform 0.2s;">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota
        </a>
    </div>
</div>

@if(request('search'))
<div class="mb-4">
    <div class="alert alert-light border d-inline-block rounded-pill px-4 py-2 shadow-sm">
        <i class="bi bi-info-circle me-2" style="color: #c9963a;"></i> Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
        <a href="{{ route('admin.perangkat.index') }}" class="ms-3 text-danger text-decoration-none"><i class="bi bi-x-circle me-1"></i>Hapus Filter</a>
    </div>
</div>
@endif

<!-- ID Card Grid -->
<div class="perangkat-grid">
    @forelse($perangkats as $p)
        <div class="id-card">
            <div class="id-card-header">
                <div class="badge-urutan">#{{ $p->urutan }}</div>
            </div>
            
            <div class="id-card-photo-wrapper">
                @if($p->foto)
                    <img src="{{ asset('images/perangkat/' . $p->foto) }}" alt="{{ $p->nama }}" class="id-card-photo">
                @else
                    <div class="id-card-photo d-flex align-items-center justify-content-center text-muted" style="background: #e2e8f0;">
                        <i class="bi bi-person-fill" style="font-size: 3rem; opacity: 0.4;"></i>
                    </div>
                @endif
            </div>
            
            <div class="id-card-body">
                <h3 class="id-card-name" title="{{ $p->nama }}">{{ $p->nama }}</h3>
                <div class="id-card-position">{{ $p->jabatan }}</div>
                @if($p->nip)
                    <div class="id-card-nip"><i class="bi bi-person-vcard me-1"></i> {{ $p->nip }}</div>
                @endif
            </div>
            
            <div class="id-card-footer">
                <a href="{{ route('admin.perangkat.edit', $p->id) }}" class="btn-act btn-edit" title="Edit Data">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.perangkat.destroy', $p->id) }}" method="POST" class="m-0 delete-form">
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
            <div class="mb-4" style="width: 80px; height: 80px; background: #fef9f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <i class="bi bi-people-fill" style="font-size: 2.5rem; color: #c9963a;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Belum Ada Perangkat Desa</h4>
            <p class="text-muted mb-4">Tambahkan data Kepala Desa beserta perangkat jajarannya di sini.</p>
            <a href="{{ route('admin.perangkat.create') }}" class="btn px-4 py-2" style="background: #c9963a; color: white; border-radius: 10px; font-weight: 600;">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Data Pertama
            </a>
        </div>
    @endforelse
</div>

<div class="pagination-wrapper d-flex justify-content-center">
    {{ $perangkats->links('pagination::bootstrap-5') }}
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data pejabat/perangkat desa yang dihapus tidak bisa dikembalikan lagi.",
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
