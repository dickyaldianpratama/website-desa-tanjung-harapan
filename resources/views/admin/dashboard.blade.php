@extends('layouts.admin')
@section('title', 'Dashboard')

@push('styles')
<style>
    /* Custom Modern Calendar */
    .custom-calendar { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; border-radius: 12px; padding: 10px; width: 100%; }
    .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; font-weight: 700; color: var(--coklat-tua); }
    .calendar-header button { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; width: 32px; height: 32px; display: flex; justify-content: center; align-items: center; cursor: pointer; transition: 0.2s; color: var(--coklat-tua); }
    .calendar-header button:hover { background: var(--gold); color: #fff; border-color: var(--gold); }
    .calendar-weekdays { display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; font-weight: 700; font-size: 0.75rem; color: #94a3b8; margin-bottom: 10px; }
    .calendar-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; }
    .calendar-day { aspect-ratio: 1; display: flex; justify-content: center; align-items: center; font-size: 0.875rem; font-weight: 500; border-radius: 8px; color: #334155; cursor: default; }
    .calendar-day:hover:not(.empty) { background: #f1f5f9; }
    .calendar-day.empty { background: transparent; cursor: default; }
    .calendar-day.today { background: var(--gold); color: #fff; font-weight: 700; box-shadow: 0 4px 10px rgba(201,150,58,0.3); }
</style>
@endpush

@section('content')

<!-- Welcome Banner -->
<div class="welcome-banner mb-4" style="
    position: relative; 
    border-radius: 20px; 
    overflow: hidden; 
    padding: 2.5rem 2rem; 
    background-image: url('{{ asset('images/sliders/slider1.jpg') }}'); 
    background-size: cover; 
    background-position: center; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
">
    <!-- Overlay gelap agar tulisan terbaca -->
    <div style="
        position: absolute; 
        top: 0; left: 0; right: 0; bottom: 0; 
        background: linear-gradient(135deg, rgba(44, 30, 22, 0.85) 0%, rgba(44, 30, 22, 0.4) 100%);
        z-index: 1;
    "></div>

    <div style="position: relative; z-index: 2; color: #fff;">
        <style>
            @keyframes wave-animation {
                0% { transform: rotate( 0.0deg) }
                10% { transform: rotate(14.0deg) }
                20% { transform: rotate(-8.0deg) }
                30% { transform: rotate(14.0deg) }
                40% { transform: rotate(-4.0deg) }
                50% { transform: rotate(10.0deg) }
                60% { transform: rotate( 0.0deg) }
                100% { transform: rotate( 0.0deg) }
            }
            .waving-hand {
                display: inline-block;
                animation: wave-animation 2.5s infinite;
                transform-origin: 70% 70%;
            }
        </style>
        <h2 class="fw-bold mb-1" style="font-family: 'Playfair Display', serif; font-size: 1.8rem; letter-spacing: 0.5px;">
            Selamat Datang, {{ auth()->user()->name }}! <span class="waving-hand">👋</span>
        </h2>
        <p class="mb-0" style="color: #f8dbb1; font-size: 0.95rem;">
            Ringkasan sistem dan aktivitas terbaru Desa Tanjung Harapan hari ini.
        </p>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFF3E0">
                <img src="{{ asset('images/icons/news.svg') }}" alt="News" style="width: 42px; height: 42px; object-fit: contain;">
            </div>
            <div>
                <div class="stat-number">{{ $totalBerita }}</div>
                <div class="stat-label">Total Berita</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E8F5E9">
                <img src="{{ asset('images/icons/leaf.png') }}" alt="Potensi" style="width: 42px; height: 42px; object-fit: contain;">
            </div>
            <div>
                <div class="stat-number">{{ $totalPotensi }}</div>
                <div class="stat-label">Potensi Desa</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#E3F2FD">
                <img src="{{ asset('images/icons/gov.png') }}" alt="Perangkat" style="width: 42px; height: 42px; object-fit: contain;">
            </div>
            <div>
                <div class="stat-number">{{ $totalPerangkat }}</div>
                <div class="stat-label">Perangkat Desa</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#FCE4EC">
                <img src="{{ asset('images/icons/Pengaduan-Masyarakat.png') }}" alt="Pengaduan" style="width: 42px; height: 42px; object-fit: contain;">
            </div>
            <div>
                <div class="stat-number">{{ $totalPengaduan }}</div>
                <div class="stat-label">Pengaduan Baru</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card-admin">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-newspaper me-2 text-gold"></i>Berita Terbaru</span>
                <a href="{{ route('admin.berita.create') }}" class="btn-sm-gold">+ Tambah</a>
            </div>
            <div class="p-0">
                <table class="table table-hover mb-0" style="font-size:.875rem">
                    <thead style="background:#f8f9fa">
                        <tr><th>Judul</th><th>Kategori</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($beritaTerbaru as $b)
                        <tr>
                            <td>{{ Str::limit($b->judul, 40) }}</td>
                            <td><span class="badge" style="background:var(--cream);color:var(--coklat-medium)">{{ ucfirst($b->kategori) }}</span></td>
                            <td>
                                @if($b->status == 'publish')
                                    <span class="badge bg-success">Publish</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Belum ada berita</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-admin mb-4">
            <div class="card-header">
                <i class="bi bi-chat-dots me-2 text-gold"></i>Pengaduan Baru
            </div>
            <div class="p-3">
                @forelse($pengaduanBaru as $p)
                <div class="d-flex align-items-start gap-2 mb-3 pb-3 border-bottom">
                    <div class="avatar" style="width:36px;height:36px;border-radius:50%;background:var(--cream);display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--coklat-tua);font-size:.8rem;flex-shrink:0">
                        {{ strtoupper(substr($p->nama, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:.875rem">{{ $p->nama }}</div>
                        <div style="font-size:.8rem;color:#6c757d">{{ Str::limit($p->subjek, 35) }}</div>
                        <div style="font-size:.75rem;color:#adb5bd">{{ $p->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center py-3 mb-0" style="font-size:.875rem">Tidak ada pengaduan baru</p>
                @endforelse
                <a href="{{ route('admin.pengaduan.index') }}" style="font-size:.8rem;color:var(--gold);text-decoration:none;font-weight:600">Lihat semua →</a>
            </div>
        </div>

        <!-- Widget Kalender -->
        <div class="card-admin">
            <div class="card-header">
                <i class="bi bi-calendar3 me-2 text-gold"></i>Kalender Sistem
            </div>
            <div class="card-body p-3 d-flex justify-content-center">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const calendarEl = document.getElementById('calendar');
        let currentDate = new Date();
        
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const today = new Date();
            
            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();
            
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            
            let html = `
                <div class="custom-calendar">
                    <div class="calendar-header">
                        <button id="prevMonth"><i class="bi bi-chevron-left"></i></button>
                        <div>${monthNames[month]} ${year}</div>
                        <button id="nextMonth"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <div class="calendar-weekdays">
                        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                    </div>
                    <div class="calendar-days">
            `;
            
            for (let i = 0; i < firstDayIndex; i++) {
                html += `<div class="calendar-day empty"></div>`;
            }
            
            for (let i = 1; i <= lastDay; i++) {
                const isToday = i === today.getDate() && month === today.getMonth() && year === today.getFullYear() ? 'today' : '';
                html += `<div class="calendar-day ${isToday}">${i}</div>`;
            }
            
            html += `</div></div>`;
            calendarEl.innerHTML = html;
            
            document.getElementById('prevMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
            document.getElementById('nextMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
        }
        
        renderCalendar();
    });
</script>
@endpush
