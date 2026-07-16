@extends('layouts.admin')
@section('title', 'Kotak Pengaduan')

@section('content')
<style>
    .inbox-container {
        display: flex;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        min-height: 700px;
        overflow: hidden;
    }

    /* Sidebar Email */
    .inbox-sidebar {
        width: 250px;
        background: #f8fafc;
        border-right: 1px solid #e2e8f0;
        padding: 1.5rem;
        flex-shrink: 0;
    }
    .compose-btn {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 600;
        width: 100%;
        text-align: center;
        box-shadow: 0 4px 15px rgba(201, 150, 58, 0.3);
        margin-bottom: 2rem;
        transition: 0.3s;
    }
    .compose-btn:hover {
        transform: translateY(-2px);
        color: white;
    }
    .inbox-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .inbox-menu li {
        margin-bottom: 0.5rem;
    }
    .inbox-menu a {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #475569;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        transition: 0.2s;
    }
    .inbox-menu a:hover, .inbox-menu a.active {
        background: #fef9f0;
        color: var(--gold);
    }
    .inbox-menu a i {
        margin-right: 12px;
        font-size: 1.1rem;
    }
    .badge-count {
        margin-left: auto;
        background: var(--gold);
        color: white;
        font-size: 0.75rem;
        padding: 0.15rem 0.6rem;
        border-radius: 20px;
        font-weight: bold;
    }

    /* Main Content */
    .inbox-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .inbox-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
    }
    .search-box {
        background: #f1f5f9;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        display: flex;
        align-items: center;
        width: 300px;
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        margin-left: 10px;
        width: 100%;
        font-size: 0.9rem;
    }

    /* Email List */
    .email-list {
        flex-grow: 1;
        overflow-y: auto;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    .email-item {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: 0.2s;
        text-decoration: none;
        color: inherit;
        background: #ffffff;
    }
    .email-item:hover {
        background: #fef9f0;
        box-shadow: inset 4px 0 0 var(--gold);
    }
    .email-item.unread {
        background: #ffffff;
        font-weight: 700;
    }
    .email-item.unread:hover {
        background: #fef9f0;
    }
    .email-item.read {
        background: #f8fafc;
        color: #64748b;
    }
    
    .email-sender {
        width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.95rem;
        color: var(--coklat-tua);
    }
    .email-subject {
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.95rem;
        margin: 0 1rem;
    }
    .email-subject span {
        color: #94a3b8;
        font-weight: 400;
        margin-left: 5px;
    }
    .email-time {
        font-size: 0.8rem;
        color: #94a3b8;
        width: 100px;
        text-align: right;
    }
    .email-actions {
        position: absolute;
        right: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        width: auto;
        text-align: right;
        opacity: 0;
        transition: 0.2s;
        pointer-events: none;
    }
    .email-item-wrapper:hover .email-actions {
        opacity: 1;
    }
    .email-actions form {
        pointer-events: auto;
    }
    .email-actions button, .btn-reply-action {
        background: #fee2e2;
        border: none;
        color: #ef4444;
        padding: 8px 12px;
        border-radius: 8px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        text-decoration: none;
    }
    .btn-reply-action {
        background: #e0f2fe;
        color: #0284c7;
    }
    .email-actions button:hover {
        background: #ef4444;
        color: white;
    }
    .btn-reply-action:hover {
        background: #0284c7;
        color: white;
    }

    .empty-inbox {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #94a3b8;
    }
    .empty-inbox i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    
    .pagination-container {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    /* Pagination Styling */
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
        .inbox-container {
            flex-direction: column;
        }
        .inbox-sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem;
        }
        .compose-btn {
            margin-bottom: 1rem;
        }
        .inbox-menu {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .inbox-menu li {
            margin-bottom: 0;
            flex: 1 1 calc(50% - 0.5rem);
        }
        .inbox-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            padding: 1rem;
        }
        .search-box {
            width: 100%;
        }
        .email-item {
            display: block;
            padding: 1rem;
            padding-right: 6.5rem; /* Space for both absolute buttons */
        }
        .email-sender {
            width: 100%;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }
        .email-subject {
            margin: 0;
            white-space: normal;
            font-size: 0.85rem;
            line-height: 1.4;
            color: #475569;
        }
        .email-subject span {
            display: block;
            margin-left: 0;
            margin-top: 0.25rem;
        }
        .email-time {
            width: 100%;
            text-align: left;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
        }
        .email-actions {
            opacity: 1 !important;
            pointer-events: auto !important;
            right: 1rem;
            width: auto;
            display: flex;
            gap: 0.5rem;
        }
        .email-actions button, .email-actions .btn-reply-action {
            padding: 10px;
            border-radius: 50%;
        }
        .email-actions .btn-text {
            display: none;
        }
        .email-actions button i, .email-actions .btn-reply-action i {
            margin: 0 !important;
        }
    }
</style>

<div class="inbox-container">
    <div class="inbox-sidebar">
        <div class="compose-btn">
            <i class="bi bi-inboxes-fill me-2"></i> Kotak Pesan
        </div>
        
        <ul class="inbox-menu">
            <li>
                <a href="{{ route('admin.pengaduan.index') }}" class="{{ !request('status') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i> Semua Pesan
                    @if($totalBaru > 0)
                        <span class="badge-count">{{ $totalBaru }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengaduan.index', ['status' => 'baru']) }}" class="{{ request('status') == 'baru' ? 'active' : '' }}">
                    <i class="bi bi-envelope-exclamation"></i> Belum Dibaca
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengaduan.index', ['status' => 'diproses']) }}" class="{{ request('status') == 'diproses' ? 'active' : '' }}">
                    <i class="bi bi-envelope-open"></i> Sudah Dibaca
                </a>
            </li>
        </ul>
    </div>

    <div class="inbox-content">
        <div class="inbox-header">
            <h5 class="mb-0 fw-bold text-dark">
                @if(request('status') == 'baru') Pesan Baru
                @elseif(request('status') == 'diproses') Pesan Terbaca
                @else Semua Pesan @endif
            </h5>
            
            <form action="{{ route('admin.pengaduan.index') }}" method="GET" class="m-0">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="search-box">
                    <i class="bi bi-search text-muted"></i>
                    <input type="text" name="search" placeholder="Cari pengirim atau subjek..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        @if($pengaduans->count() > 0)
            <ul class="email-list">
                @foreach($pengaduans as $p)
                <li class="email-item-wrapper" style="position: relative;">
                    <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="email-item {{ $p->status == 'baru' ? 'unread' : 'read' }}">
                        <div class="email-sender">
                            @if($p->status == 'baru') <i class="bi bi-circle-fill text-warning me-2" style="font-size: 8px;"></i> @endif
                            {{ $p->nama }}
                        </div>
                        <div class="email-time">
                            <i class="bi bi-clock"></i> {{ $p->created_at->isToday() ? $p->created_at->format('H:i') : $p->created_at->format('d M Y') }}
                        </div>
                        <div class="email-subject">
                            <strong>{{ $p->subjek }}</strong>
                            <span>{{ Str::limit(strip_tags($p->pesan), 80) }}</span>
                        </div>
                    </a>
                    <div class="email-actions">
                        <!-- Tombol Balas Khusus Mobile -->
                        <a href="{{ route('admin.pengaduan.show', $p->id) }}" class="btn-reply-action d-flex d-md-none" title="Balas Pesan">
                            <i class="bi bi-reply-fill"></i> <span class="btn-text">Balas</span>
                        </a>
                        <form action="{{ route('admin.pengaduan.destroy', $p->id) }}" method="POST" class="m-0 delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-delete-action" title="Hapus Pesan">
                                <i class="bi bi-trash3"></i> <span class="btn-text">Hapus</span>
                            </button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
            
            <div class="pagination-container d-flex justify-content-end">
                {{ $pengaduans->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="empty-inbox">
                <i class="bi bi-mailbox"></i>
                <h5>Tidak ada pesan ditemukan.</h5>
                <p>Kotak masuk Anda bersih.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Pesan?',
                text: "Pesan ini akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-4' }
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
