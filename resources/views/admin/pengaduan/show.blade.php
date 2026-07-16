@extends('layouts.admin')
@section('title', 'Baca Pengaduan')

@section('content')
<style>
    .email-read-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid #f1f5f9;
        min-height: 700px;
    }
    
    .email-read-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .email-subject-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .email-meta {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .sender-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .sender-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .sender-details {
        display: flex;
        flex-direction: column;
    }

    .sender-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .sender-email {
        font-size: 0.85rem;
        color: #64748b;
    }

    .email-date {
        font-size: 0.9rem;
        color: #94a3b8;
    }

    .email-body {
        padding: 2rem;
        font-size: 1.05rem;
        line-height: 1.8;
        color: #334155;
        white-space: pre-wrap; /* Mempertahankan format paragraf */
    }

    .back-btn {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        transition: 0.2s;
    }
    .back-btn:hover {
        color: var(--gold);
    }

    /* Mobile Responsiveness */
    @media (max-width: 576px) {
        .email-read-header, .email-meta, .email-body {
            padding: 1rem;
        }
        .email-read-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .email-subject-title {
            font-size: 1.25rem;
        }
        .email-meta {
            flex-direction: column;
            gap: 1rem;
        }
        .email-date {
            margin-left: 4rem; /* Sejajar dengan teks nama */
        }
        .btn-delete-action {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
</style>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.pengaduan.index') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> 
        <span class="d-none d-sm-inline">Kembali ke Kotak Masuk</span>
        <span class="d-inline d-sm-none">Kembali</span>
    </a>
    
    <form action="{{ route('admin.pengaduan.destroy', $pengaduan->id) }}" method="POST" class="m-0 delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-outline-danger btn-delete-action rounded-pill px-4">
            <i class="bi bi-trash3 d-none d-sm-inline-block me-2"></i>
            <i class="bi bi-trash3 d-inline-block d-sm-none"></i>
            <span class="d-none d-sm-inline">Hapus Pesan</span>
        </button>
    </form>
</div>

<div class="email-read-container">
    <div class="email-read-header">
        <h2 class="email-subject-title">{{ $pengaduan->subjek }}</h2>
        <span class="badge bg-light text-dark border"><i class="bi bi-telephone-fill text-muted me-1"></i> {{ $pengaduan->telepon ?? 'Tidak ada No. HP' }}</span>
    </div>

    <div class="email-meta">
        <div class="sender-info">
            <div class="sender-avatar">
                {{ strtoupper(substr($pengaduan->nama, 0, 1)) }}
            </div>
            <div class="sender-details">
                <span class="sender-name">{{ $pengaduan->nama }}</span>
                <span class="sender-email">&lt;{{ $pengaduan->email }}&gt;</span>
            </div>
        </div>
        <div class="email-date">
            {{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB
        </div>
    </div>

    <div class="email-body">
{{ $pengaduan->pesan }}
    </div>

    <!-- Reply Section -->
    <div class="p-4 border-top" style="background: #f8fafc; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
        <h6 class="fw-bold mb-3" style="color: #475569;"><i class="bi bi-whatsapp text-success me-2"></i> Balas Langsung via WhatsApp</h6>
        
        @if($pengaduan->telepon)
        <div class="reply-box position-relative">
            <textarea id="waReplyText" class="form-control" rows="3" placeholder="Ketik balasan untuk {{ $pengaduan->nama }} di sini..." style="border-radius: 12px; padding: 1rem; border: 1px solid #cbd5e1; resize: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"></textarea>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Akan otomatis membuka aplikasi WhatsApp dengan pesan ini.</small>
                <button type="button" id="btnKirimWa" class="btn text-white px-4 py-2" style="background: #25D366; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);">
                    Kirim Balasan <i class="bi bi-send-fill ms-2"></i>
                </button>
            </div>
        </div>
        @else
        <div class="alert alert-warning mb-0 border-0 d-flex align-items-center" style="border-radius: 12px; background: #fef3c7; color: #b45309;">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
            <div>
                <strong>Pengadu tidak menyertakan Nomor HP!</strong><br>
                Anda tidak dapat membalas via WhatsApp. Silakan hubungi via email jika tersedia.
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    @if($pengaduan->telepon)
    document.getElementById('btnKirimWa').addEventListener('click', function() {
        let noHp = '{{ $pengaduan->telepon }}';
        let pesanText = document.getElementById('waReplyText').value;
        
        if(pesanText.trim() === '') {
            Swal.fire('Ups!', 'Silakan ketik pesan balasan terlebih dahulu.', 'warning');
            return;
        }

        // Format nomor HP ke format internasional WhatsApp (Indonesia: 62)
        // Bersihkan karakter non-angka
        noHp = noHp.replace(/\D/g, '');
        // Jika dimulai dengan 0, ganti dengan 62
        if (noHp.startsWith('0')) {
            noHp = '62' + noHp.substring(1);
        }

        // Buat template sapaan pembuka otomatis
        let sapaan = "Halo Bpk/Ibu *{{ $pengaduan->nama }}*, ini balasan dari Admin Desa terkait pengaduan Anda mengenai _\"{{ $pengaduan->subjek }}\"_\n\n";
        
        let pesanFinal = encodeURIComponent(sapaan + pesanText);
        let waUrl = `https://wa.me/${noHp}?text=${pesanFinal}`;

        // Buka tab baru untuk WhatsApp
        window.open(waUrl, '_blank');
        
        // Kosongkan kotak teks (opsional)
        // document.getElementById('waReplyText').value = '';
    });
    @endif
    document.querySelectorAll('.btn-delete-action').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Pesan?',
                text: "Pesan yang dihapus tidak bisa dikembalikan.",
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
</script>
@endpush
@endsection
