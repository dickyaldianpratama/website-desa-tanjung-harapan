@extends('layouts.app')
@section('title', 'Fasilitas Desa')

@push('styles')
<style>
    /* Styling modern untuk Filter dan Grid Fasilitas */
    .filter-btn {
        background: transparent;
        border: 1px solid var(--gold);
        color: var(--coklat-tua);
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin: 0.25rem;
    }
    .filter-btn:hover, .filter-btn.active {
        background: var(--gold);
        color: #fff;
    }

    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .fasilitas-card {
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        background: #fff;
        height: 320px;
        cursor: pointer;
    }
    .fasilitas-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .fasilitas-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    .fasilitas-card:hover img {
        transform: scale(1.08);
    }

    /* Glassmorphism Overlay */
    .fasilitas-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(44, 21, 7, 0.9) 0%, rgba(44, 21, 7, 0.4) 60%, transparent 100%);
        padding: 2rem 1.5rem 1.5rem;
        color: #fff;
        transform: translateY(30%); /* Sembunyikan sebagian deskripsi */
        transition: transform 0.4s ease;
    }
    .fasilitas-card:hover .fasilitas-overlay {
        transform: translateY(0);
        background: linear-gradient(to top, rgba(44, 21, 7, 0.95) 0%, rgba(44, 21, 7, 0.7) 100%);
        backdrop-filter: blur(4px);
    }

    .fasilitas-kategori {
        background: var(--gold);
        color: var(--coklat-tua);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .fasilitas-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .fasilitas-desc {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8);
        opacity: 0;
        transition: opacity 0.4s ease;
        transition-delay: 0.1s;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .fasilitas-card:hover .fasilitas-desc {
        opacity: 1;
    }

    /* Hide element class for filtering */
    .fasilitas-item.hide {
        display: none;
    }
    
    /* Animasi Zoom In Modal Khusus Fasilitas */
    .modal.fade .modal-dialog.modal-zoom {
        transform: scale(0.8);
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        opacity: 0;
    }
    .modal.show .modal-dialog.modal-zoom {
        transform: scale(1);
        opacity: 1;
    }
    .btn-close-custom {
        background-color: rgba(255,255,255,0.9);
        border-radius: 50%;
        padding: 0.6rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s ease;
    }
    .btn-close-custom:hover {
        background-color: #fff;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')

<div class="container py-5 my-3">
    <!-- Filter Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="font-serif fw-bold text-coklat-tua mb-4">Eksplorasi Fasilitas Kami</h2>
            <div id="fasilitas-filters" class="d-flex flex-wrap justify-content-center">
                <button class="filter-btn active" data-filter="all">Semua Fasilitas</button>
                @foreach($kategoriList as $kat)
                    <button class="filter-btn" data-filter="{{ Str::slug($kat) }}">{{ $kat }}</button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grid Section -->
    <div class="fasilitas-grid" id="fasilitas-container">
        @forelse($fasilitas as $item)
            <div class="fasilitas-item" data-category="{{ Str::slug($item->kategori) }}">
                <!-- Ditambahkan attribut data-* untuk JS Modal -->
                <div class="fasilitas-card" 
                     data-nama="{{ $item->nama_fasilitas }}"
                     data-kategori="{{ $item->kategori }}"
                     data-deskripsi="{{ $item->deskripsi }}"
                     data-foto="{{ $item->foto ? Storage::disk('s3')->url('images/fasilitas/' . $item->foto) : '' }}"
                     onclick="openFasilitasModal(this)">
                     
                    @if($item->foto)
                        <img src="{{ Storage::disk('s3')->url('images/fasilitas/' . $item->foto) }}" alt="{{ $item->nama_fasilitas }}" loading="lazy">
                    @else
                        <!-- Placeholder jika foto kosong -->
                        <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                            <i class="bi bi-building fs-1 text-light"></i>
                        </div>
                    @endif
                    
                    <div class="fasilitas-overlay">
                        <span class="fasilitas-kategori">{{ $item->kategori }}</span>
                        <h4 class="fasilitas-title font-serif">{{ $item->nama_fasilitas }}</h4>
                        @if($item->deskripsi)
                            <div class="fasilitas-desc">
                                {{ $item->deskripsi }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada data fasilitas yang ditambahkan.</h5>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Zoom In Detail Fasilitas -->
<div class="modal fade" id="fasilitasModal" tabindex="-1" aria-labelledby="modalNama" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-zoom" style="max-width: 500px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            
            <!-- Tombol Close (Silang) menumpuk di atas gambar -->
            <button type="button" class="btn-close btn-close-custom position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
            
            <!-- Gambar Fasilitas (Zoomed) -->
            <img id="modalFoto" src="" alt="Foto Fasilitas" class="d-none" style="width: 100%; height: 260px; object-fit: cover;">
            
            <!-- Placeholder jika tidak ada gambar -->
            <div id="modalFotoPlaceholder" class="bg-secondary d-none align-items-center justify-content-center" style="width: 100%; height: 260px;">
                <i class="bi bi-building" style="font-size: 4rem; color: rgba(255,255,255,0.7);"></i>
            </div>
            
            <!-- Detail Teks -->
            <div class="modal-body p-4 text-center">
                <span id="modalKategori" class="badge bg-gold text-coklat-tua px-3 py-1 rounded-pill mb-3 fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;"></span>
                <h4 id="modalNama" class="fw-bold text-coklat-tua mb-3 font-serif"></h4>
                <div id="modalDeskripsi" class="text-secondary" style="line-height: 1.6; font-size: 0.95rem;"></div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // 1. Script Filter Kategori
    document.addEventListener("DOMContentLoaded", function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.fasilitas-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                items.forEach(item => {
                    if (filterValue === 'all') {
                        item.classList.remove('hide');
                    } else {
                        if (item.getAttribute('data-category') === filterValue) {
                            item.classList.remove('hide');
                        } else {
                            item.classList.add('hide');
                        }
                    }
                });
            });
        });
    });

    // 2. Script Buka Modal Detail (Zoom-in)
    function openFasilitasModal(element) {
        // Ambil data dari atribut element yang diklik
        const nama = element.getAttribute('data-nama');
        const kategori = element.getAttribute('data-kategori');
        const deskripsi = element.getAttribute('data-deskripsi');
        const foto = element.getAttribute('data-foto');

        // Isi konten modal
        document.getElementById('modalNama').innerText = nama;
        document.getElementById('modalKategori').innerText = kategori;
        document.getElementById('modalDeskripsi').innerText = deskripsi ? deskripsi : 'Tidak ada deskripsi/informasi tambahan untuk fasilitas ini.';

        const imgEl = document.getElementById('modalFoto');
        const placeholder = document.getElementById('modalFotoPlaceholder');

        // Mengatur tampilan gambar vs placeholder dengan class d-none / d-flex
        if (foto && foto.trim() !== '') {
            imgEl.src = foto;
            imgEl.classList.remove('d-none');
            
            placeholder.classList.remove('d-flex');
            placeholder.classList.add('d-none');
        } else {
            imgEl.classList.add('d-none');
            
            placeholder.classList.remove('d-none');
            placeholder.classList.add('d-flex');
        }

        // Tampilkan Modal Bootstrap
        const modalElement = document.getElementById('fasilitasModal');
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }
</script>
@endpush
