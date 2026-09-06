@extends('layouts.admin')
@section('title', 'Tambah Banner')

@push('styles')
<style>
/* ══ MEDIA TOGGLE ══ */
.media-toggle-wrap {
    display: flex; gap: 10px; margin-bottom: 20px;
}
.media-toggle-btn {
    flex: 1; padding: 14px 10px;
    border-radius: 14px;
    border: 2px solid #e2e8f0;
    background: #f8fafc;
    cursor: pointer;
    transition: all .2s;
    display: flex; flex-direction: column;
    align-items: center; gap: 6px;
    font-size: .82rem; font-weight: 600; color: #64748b;
}
.media-toggle-btn .toggle-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    background: #f1f5f9;
    transition: all .2s;
}
.media-toggle-btn.active-gambar {
    border-color: #c9963a;
    background: linear-gradient(135deg,#fffdf7,#fff8ec);
    color: #b07d20;
}
.media-toggle-btn.active-gambar .toggle-icon { background: linear-gradient(135deg,#c9963a,#e8b84b); color: #fff; }
.media-toggle-btn.active-video {
    border-color: #6366f1;
    background: linear-gradient(135deg,#f5f3ff,#ede9fe);
    color: #4f46e5;
}
.media-toggle-btn.active-video .toggle-icon { background: linear-gradient(135deg,#6366f1,#818cf8); color: #fff; }

/* ══ UPLOAD ZONE ══ */
.upload-zone {
    border: 2.5px dashed #c9963a; border-radius: 14px;
    background: linear-gradient(135deg,#fffdf7,#fff8ec);
    cursor: pointer; transition: all .25s; min-height: 160px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 10px; padding: 24px;
}
.upload-zone.video-mode { border-color: #6366f1; background: linear-gradient(135deg,#f5f3ff,#ede9fe); }
.upload-zone:hover,.upload-zone.dragover {
    border-color: #b07d20;
    background: linear-gradient(135deg,#fff3d4,#ffe8a0);
    box-shadow: 0 0 0 4px rgba(201,150,58,.12);
}
.upload-zone.video-mode:hover,.upload-zone.video-mode.dragover {
    border-color: #4f46e5;
    background: linear-gradient(135deg,#ede9fe,#ddd6fe);
    box-shadow: 0 0 0 4px rgba(99,102,241,.12);
}
.upload-icon-wrap {
    width: 64px; height: 64px;
    background: linear-gradient(135deg,#c9963a,#e8b84b);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem; color: #fff;
    box-shadow: 0 4px 16px rgba(201,150,58,.35);
    transition: transform .25s;
}
.upload-zone.video-mode .upload-icon-wrap { background: linear-gradient(135deg,#6366f1,#818cf8); box-shadow: 0 4px 16px rgba(99,102,241,.35); }
.upload-zone:hover .upload-icon-wrap { transform: scale(1.1) rotate(-6deg); }

/* ══ GUIDE CARD ══ */
.guide-card {
    border-radius: 12px; padding: 14px 16px;
    margin-bottom: 14px;
}
.guide-card.gambar-guide { background: linear-gradient(135deg,#fff8ec,#fff3d4); border: 1.5px solid rgba(201,150,58,.35); }
.guide-card.video-guide  { background: linear-gradient(135deg,#f5f3ff,#ede9fe); border: 1.5px solid rgba(99,102,241,.35); }
.guide-title { font-size: .82rem; font-weight: 700; margin-bottom: 9px; }
.guide-card.gambar-guide .guide-title { color: #b07d20; }
.guide-card.video-guide  .guide-title { color: #4f46e5; }
.guide-item {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: .79rem; color: #555; line-height: 1.4;
    margin-bottom: 6px;
}
.guide-item:last-child { margin-bottom: 0; }

/* ══ PREVIEW ══ */
.preview-wrap {
    position: relative; width: 100%; aspect-ratio: 16/9;
    border-radius: 14px; overflow: hidden;
    background: #1a1a2e;
    box-shadow: 0 6px 24px rgba(0,0,0,.25);
}
.preview-wrap img#imgPreview {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; object-position: 50% 50%;
    transform-origin: 50% 50%; transform: scale(1);
    transition: object-position .2s, transform .2s;
}
.preview-wrap video#vidPreview {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover;
}
.preview-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top,rgba(0,0,0,.5) 0%,transparent 55%);
    display: flex; align-items: flex-end; padding: 12px;
    pointer-events: none;
}
.preview-label {
    font-size: .7rem; color: rgba(255,255,255,.85);
    background: rgba(0,0,0,.4); padding: 3px 10px; border-radius: 20px;
}
.preview-change-btn {
    position: absolute; top: 10px; right: 10px;
    background: rgba(0,0,0,.5); color: #fff; font-size: .72rem;
    padding: 5px 12px; border-radius: 20px; cursor: pointer;
    display: flex; align-items: center; gap: 5px;
    transition: background .2s; border: none;
}
.preview-change-btn:hover { background: rgba(99,102,241,.85); }

/* ══ HD BADGE ══ */
.hd-badge-wrap { margin-top: 10px; }
.hd-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 20px;
    font-size: .78rem; font-weight: 700;
    transition: all .2s;
}
.hd-badge.hd-ok   { background: #d1fae5; color: #065f46; border: 1.5px solid #6ee7b7; }
.hd-badge.hd-warn { background: #fee2e2; color: #991b1b; border: 1.5px solid #fca5a5; }
.hd-badge.hd-info { background: #e0e7ff; color: #3730a3; border: 1.5px solid #a5b4fc; }

/* ══ FILE INFO ══ */
.file-info-bar {
    display: none; align-items: center; gap: 8px;
    background: #e8f4fd; border: 1px solid #b8daff;
    border-radius: 10px; padding: 8px 14px; font-size: .79rem;
}
.file-info-bar.show { display: flex; }

/* ══ TOOLS PANEL ══ */
.tools-panel { background: #fff; border: 1.5px solid #e9ecef; border-radius: 14px; padding: 20px; }
.tool-label {
    font-size: .78rem; font-weight: 600; color: #444;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 6px;
}
.val-badge { background: #f1f3f5; padding: 2px 10px; border-radius: 20px; font-weight: 700; color: #c9963a; font-size: .76rem; min-width: 52px; text-align: center; }
input[type=range].tool-range {
    -webkit-appearance: none; width: 100%; height: 6px; border-radius: 3px;
    background: linear-gradient(to right,#c9963a 0%,#c9963a var(--pct,75%),#e0e0e0 var(--pct,75%),#e0e0e0 100%);
    outline: none; cursor: pointer;
}
input[type=range].tool-range::-webkit-slider-thumb {
    -webkit-appearance: none; width: 20px; height: 20px;
    border-radius: 50%; background: #fff; border: 3px solid #c9963a;
    box-shadow: 0 2px 8px rgba(0,0,0,.15); cursor: pointer;
}
.hint-box { margin-top: 8px; padding: 8px 12px; border-radius: 10px; font-size: .74rem; line-height: 1.45; background: #f0fff4; color: #27ae60; transition: background .3s,color .3s; }
.section-sep { border: 0; border-top: 1.5px dashed #e0e0e0; margin: 16px 0; }
.pos-pad {
    width: 100%; aspect-ratio: 16/9;
    background:
        repeating-linear-gradient(rgba(201,150,58,.1) 0 1px,transparent 1px 100%) 0 0/16.66% 100%,
        repeating-linear-gradient(90deg,rgba(201,150,58,.1) 0 1px,transparent 1px 100%) 0 0/100% 25%,
        linear-gradient(135deg,#f5f0e8,#fdfaf5);
    border: 2px solid #c9963a; border-radius: 12px;
    position: relative; cursor: crosshair;
    overflow: hidden; user-select: none; touch-action: none;
}
.pos-center-mark { position: absolute; top: 50%; left: 50%; width: 6px; height: 6px; border-radius: 50%; background: rgba(201,150,58,.4); transform: translate(-50%,-50%); pointer-events: none; }
.pos-line-h,.pos-line-v { position: absolute; pointer-events: none; background: rgba(201,150,58,.55); }
.pos-line-h { height: 1px; left: 0; right: 0; top: 50%; }
.pos-line-v { width: 1px; top: 0; bottom: 0; left: 50%; }
.pos-handle {
    position: absolute; top: 50%; left: 50%;
    width: 30px; height: 30px; transform: translate(-50%,-50%);
    background: linear-gradient(135deg,#c9963a,#f0c060);
    border: 3px solid #fff; border-radius: 50%;
    cursor: grab; box-shadow: 0 3px 14px rgba(0,0,0,.3);
    z-index: 5; display: flex; align-items: center; justify-content: center;
}
.pos-handle::before,.pos-handle::after { content: ''; position: absolute; background: rgba(255,255,255,.85); border-radius: 2px; }
.pos-handle::before { width: 2px; height: 12px; }
.pos-handle::after  { width: 12px; height: 2px; }
.pos-coords-badge { position: absolute; bottom: 6px; right: 8px; background: rgba(0,0,0,.5); color: #fff; font-size: .65rem; padding: 2px 8px; border-radius: 20px; pointer-events: none; }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.slider.index') }}" class="text-decoration-none text-muted mb-2 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Manajemen Slider
    </a>
    <h4 class="fw-bold text-dark">Tambah Banner Baru</h4>
</div>

<div class="card-admin p-4">
    <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data" id="sliderForm">
        @csrf
        <input type="hidden" id="image_position" name="image_position" value="{{ old('image_position', '50% 50%') }}">
        <input type="hidden" id="tipe_media_input" name="tipe_media" value="{{ old('tipe_media', 'gambar') }}">

        <div class="row g-4">

            {{-- ═══ KOLOM KIRI ═══ --}}
            <div class="col-md-8">

                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Banner <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="judul"
                           class="form-control form-control-lg @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}" placeholder="Contoh: Selamat Datang di Desa Kami" maxlength="60">
                    <small class="text-muted" style="font-size:.75rem;">Maks. 60 karakter.</small>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Subtitle --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Teks Subtitle <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                              rows="2" placeholder="Teks kecil di bawah judul..." maxlength="150">{{ old('subtitle') }}</textarea>
                    <small class="text-muted" style="font-size:.75rem;">Maks. 150 karakter.</small>
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- ══ TOGGLE TIPE MEDIA ══ --}}
                <div class="mb-3">
                    <label class="form-label fw-bold mb-2">Tipe Media <span class="text-danger">*</span></label>
                    <div class="media-toggle-wrap">
                        <div class="media-toggle-btn active-gambar" id="btnGambar" onclick="setMode('gambar')">
                            <div class="toggle-icon">
                                <img src="{{ asset('images/icons/icon-image.png') }}" alt="Image" style="width:32px; height:auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                            </div>
                            <span>GAMBAR</span>
                        </div>
                        <div class="media-toggle-btn" id="btnVideo" onclick="setMode('video')">
                            <div class="toggle-icon">
                                <img src="{{ asset('images/icons/icon-vidios.png') }}" alt="Video" style="width:32px; height:auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                            </div>
                            <span>VIDEO</span>
                        </div>
                    </div>
                </div>

                {{-- ── PANEL GAMBAR ── --}}
                <div id="panelGambar">
                    <div class="guide-card gambar-guide">
                        <div class="guide-title"><i class="bi bi-info-circle-fill me-1"></i> Panduan Gambar</div>
                        <div class="guide-item"><span>📐</span><span>Rasio <strong>16:9</strong> · min <strong>1280×720 px</strong></span></div>
                        <div class="guide-item"><span>🗂️</span><span>Format: <strong>JPG · PNG · WEBP</strong> · Maks. <strong>5 MB</strong></span></div>
                        <div class="guide-item"><span>🎯</span><span><strong>Seret titik fokus</strong> di pad posisi (kanan)</span></div>
                        <div class="guide-item"><span>🔍</span><span><strong>Slider Zoom</strong> untuk perbesar tampilan gambar</span></div>
                    </div>

                    <div class="upload-zone mb-2" id="uploadZoneGambar" onclick="document.getElementById('inputGambar').click()">
                        <div class="upload-icon-wrap"><i class="bi bi-cloud-upload"></i></div>
                        <p class="fw-bold mb-0" style="color:#b07d20;">Klik atau seret gambar ke sini</p>
                        <p class="text-muted small mb-0">JPG · PNG · WEBP — Maks. 5 MB</p>
                    </div>
                    <div class="preview-wrap mb-2 d-none" id="previewWrapGambar">
                        <img id="imgPreview" src="#" alt="Preview">

                        <button type="button" class="preview-change-btn" onclick="document.getElementById('inputGambar').click()">
                            <i class="bi bi-pencil-square"></i> Ganti
                        </button>
                    </div>
                    <input class="form-control d-none" type="file" id="inputGambar" name="gambar" accept="image/jpeg,image/png,image/webp">
                    @error('gambar')<div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                    <div class="file-info-bar mt-2" id="fileInfoBarGambar">
                        <i class="bi bi-file-earmark-image"></i>
                        <span id="fileInfoTextGambar">—</span>
                        <span id="fileWarnGambar" class="badge bg-warning text-dark ms-auto d-none">File Besar</span>
                    </div>
                </div>

                {{-- ── PANEL VIDEO ── --}}
                <div id="panelVideo" class="d-none">
                    <div class="guide-card video-guide">
                        <div class="guide-title"><i class="bi bi-info-circle-fill me-1"></i> Panduan Video</div>
                        <div class="guide-item"><span>📐</span><span>Min <strong>1280×720 (HD)</strong> · disarankan <strong>1920×1080 (FHD)</strong></span></div>
                        <div class="guide-item"><span>🗂️</span><span>Format: <strong>MP4 · WEBM</strong> · Maks. <strong>50 MB</strong></span></div>
                        <div class="guide-item"><span>🔇</span><span>Video otomatis <strong>mute &amp; loop</strong> di halaman beranda</span></div>
                        <div class="guide-item"><span>✍️</span><span>Judul &amp; subtitle tetap tampil di atas video</span></div>
                    </div>

                    <div class="upload-zone video-mode mb-2" id="uploadZoneVideo" onclick="document.getElementById('inputVideo').click()">
                        <div class="upload-icon-wrap"><i class="bi bi-camera-video"></i></div>
                        <p class="fw-bold mb-0" style="color:#4f46e5;">Klik atau seret video ke sini</p>
                        <p class="text-muted small mb-0">MP4 · WEBM — Maks. 50 MB — Min. HD 720p</p>
                    </div>
                    <div class="preview-wrap mb-2 d-none" id="previewWrapVideo">
                        <video id="vidPreview" autoplay muted loop playsinline></video>
                        <div class="preview-overlay"><span class="preview-label"><i class="bi bi-play-circle me-1"></i>Preview Video</span></div>
                        <button type="button" class="preview-change-btn" onclick="document.getElementById('inputVideo').click()">
                            <i class="bi bi-pencil-square"></i> Ganti
                        </button>
                    </div>
                    <input class="form-control d-none" type="file" id="inputVideo" name="gambar" accept="video/mp4,video/webm">
                    @error('gambar')<div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror

                    <div class="hd-badge-wrap" id="hdBadgeWrap" style="display:none;">
                        <span class="hd-badge hd-info" id="hdBadge"><i class="bi bi-display me-1"></i><span id="hdBadgeText">Mendeteksi resolusi...</span></span>
                    </div>
                    <div class="file-info-bar mt-2" id="fileInfoBarVideo">
                        <i class="bi bi-file-earmark-play"></i>
                        <span id="fileInfoTextVideo">—</span>
                        <span id="fileWarnVideo" class="badge bg-warning text-dark ms-auto d-none">File Besar</span>
                    </div>
                </div>

            </div>

            {{-- ═══ KOLOM KANAN ═══ --}}
            <div class="col-md-4">

                {{-- Pengaturan Tampil --}}
                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-sliders me-2"></i>Pengaturan Tampil</h6>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Status Banner</label>
                            <select name="aktif" class="form-select @error('aktif') is-invalid @enderror">
                                <option value="1" {{ old('aktif','1') == '1' ? 'selected':'' }}>Aktif (Ditampilkan)</option>
                                <option value="0" {{ old('aktif') == '0' ? 'selected':'' }}>Tidak Aktif (Disembunyikan)</option>
                            </select>
                            @error('aktif')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Urutan Tampil</label>
                            <input type="number" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $nextUrutan) }}" min="1" required>
                            <small class="text-muted" style="font-size:.7rem;">Urutan terkecil tampil lebih dulu.</small>
                            @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ══ TOOLS GAMBAR (hanya muncul di mode gambar) ══ --}}
                <div class="tools-panel mb-4" id="toolsGambar">
                    <h6 class="mb-3"><i class="bi bi-image-alt me-2 text-warning"></i>Tools Optimasi Gambar</h6>

                    {{-- Posisi --}}
                    <div class="mb-3">
                        <div class="tool-label">
                            <span><i class="bi bi-arrows-move me-1"></i>Posisi Gambar</span>
                            <span class="val-badge" id="posBadge" style="font-size:.65rem;min-width:72px;">50% 50%</span>
                        </div>
                        <div class="pos-pad" id="posPad">
                            <div class="pos-center-mark"></div>
                            <div class="pos-line-h" id="posLineH"></div>
                            <div class="pos-line-v" id="posLineV"></div>
                            <div class="pos-handle" id="posHandle"></div>
                            <span class="pos-coords-badge" id="posCoordsLabel">50% 50%</span>
                        </div>
                        <small class="text-muted mt-1 d-block" style="font-size:.7rem;">
                            <i class="bi bi-hand-index-thumb me-1 text-warning"></i>Seret titik emas — area fokus gambar.
                        </small>
                    </div>

                    <hr class="section-sep">

                    {{-- Zoom --}}
                    <div class="mb-4">
                        <div class="tool-label">
                            <span><i class="bi bi-zoom-in me-1"></i>Zoom</span>
                            <span class="val-badge" id="scaleBadge">100%</span>
                        </div>
                        <input type="range" id="scaleSlider" name="image_scale"
                               class="tool-range" min="100" max="250" step="5" value="{{ old('image_scale', 100) }}">
                        <div class="d-flex justify-content-between mt-1" style="font-size:.66rem;color:#aaa;">
                            <span>1×</span><span>1.5×</span><span>2.5×</span>
                        </div>
                    </div>

                    <hr class="section-sep">

                    {{-- Kualitas --}}
                    <div>
                        <div class="tool-label">
                            <span><i class="bi bi-stars me-1"></i>Kualitas Kompresi</span>
                            <span class="val-badge" id="qualityBadge">85%</span>
                        </div>
                        <input type="range" id="qualitySlider" name="image_quality"
                               class="tool-range" min="10" max="100" step="5" value="{{ old('image_quality', 85) }}">
                        <div class="d-flex justify-content-between mt-1" style="font-size:.66rem;color:#aaa;">
                            <span>Hemat</span><span>Seimbang</span><span>Tajam</span>
                        </div>
                        <div class="hint-box" id="qualityHint"><span id="qualityHintText">—</span></div>
                    </div>
                </div>

                {{-- ══ VIDEO INFO PANEL ══ --}}
                <div class="tools-panel mb-4 d-none" id="toolsVideo" style="border-color:#c7d2fe;">
                    <h6 class="mb-3" style="color:#4f46e5;"><i class="bi bi-camera-video me-2"></i>Info Video</h6>
                    <div class="d-flex flex-column gap-2" style="font-size:.8rem;color:#555;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Disimpan tanpa kompresi — kualitas asli terjaga</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-volume-mute-fill text-primary"></i>
                            <span>Otomatis mute &amp; loop di beranda</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-warning"></i>
                            <span>Validasi HD (min. 720p) aktif</span>
                        </div>
                    </div>
                </div>

                {{-- Simpan --}}
                <button type="submit" id="submitBtn" class="btn w-100 py-3 fw-bold"
                        style="background:var(--gold);border-color:var(--gold);color:#fff;font-size:1.05rem;border-radius:12px;box-shadow:0 4px 15px rgba(201,150,58,.4);">
                    <i class="bi bi-save me-2"></i>Simpan Banner
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
(function () {
    /* ─── STATE ─── */
    let currentMode = '{{ old('tipe_media', 'gambar') }}';
    let hdValid = true;

    /* ─── REFS ─── */
    const tipeInput       = document.getElementById('tipe_media_input');
    const btnGambar       = document.getElementById('btnGambar');
    const btnVideo        = document.getElementById('btnVideo');
    const panelGambar     = document.getElementById('panelGambar');
    const panelVideo      = document.getElementById('panelVideo');
    const toolsGambar     = document.getElementById('toolsGambar');
    const toolsVideo      = document.getElementById('toolsVideo');
    const inputGambar     = document.getElementById('inputGambar');
    const inputVideo      = document.getElementById('inputVideo');
    const imgPreview      = document.getElementById('imgPreview');
    const vidPreview      = document.getElementById('vidPreview');
    const previewWrapG    = document.getElementById('previewWrapGambar');
    const previewWrapV    = document.getElementById('previewWrapVideo');
    const uploadZoneG     = document.getElementById('uploadZoneGambar');
    const uploadZoneV     = document.getElementById('uploadZoneVideo');
    const fileInfoBarG    = document.getElementById('fileInfoBarGambar');
    const fileInfoTextG   = document.getElementById('fileInfoTextGambar');
    const fileWarnG       = document.getElementById('fileWarnGambar');
    const fileInfoBarV    = document.getElementById('fileInfoBarVideo');
    const fileInfoTextV   = document.getElementById('fileInfoTextVideo');
    const fileWarnV       = document.getElementById('fileWarnVideo');
    const hdBadgeWrap     = document.getElementById('hdBadgeWrap');
    const hdBadge         = document.getElementById('hdBadge');
    const hdBadgeText     = document.getElementById('hdBadgeText');
    const submitBtn       = document.getElementById('submitBtn');
    const posInput        = document.getElementById('image_position');
    const posBadge        = document.getElementById('posBadge');
    const posCoordsLabel  = document.getElementById('posCoordsLabel');
    const posPad          = document.getElementById('posPad');
    const posHandle       = document.getElementById('posHandle');
    const posLineH        = document.getElementById('posLineH');
    const posLineV        = document.getElementById('posLineV');
    const scaleSlider     = document.getElementById('scaleSlider');
    const scaleBadge      = document.getElementById('scaleBadge');
    const qualitySlider   = document.getElementById('qualitySlider');
    const qualityBadge    = document.getElementById('qualityBadge');
    const qualityHint     = document.getElementById('qualityHint');
    const qualityHintText = document.getElementById('qualityHintText');

    /* ─── MODE TOGGLE ─── */
    window.setMode = function(mode) {
        currentMode = mode;
        tipeInput.value = mode;

        if (mode === 'gambar') {
            btnGambar.className = 'media-toggle-btn active-gambar';
            btnVideo.className  = 'media-toggle-btn';
            panelGambar.classList.remove('d-none');
            panelVideo.classList.add('d-none');
            toolsGambar.classList.remove('d-none');
            toolsVideo.classList.add('d-none');
            inputGambar.required = true;
            inputVideo.required  = false;
            if (inputGambar) inputGambar.disabled = false;
            if (inputVideo) inputVideo.disabled = true;
            hdValid = true;
            updateSubmitBtn();
        } else {
            btnGambar.className = 'media-toggle-btn';
            btnVideo.className  = 'media-toggle-btn active-video';
            panelGambar.classList.add('d-none');
            panelVideo.classList.remove('d-none');
            toolsGambar.classList.add('d-none');
            toolsVideo.classList.remove('d-none');
            inputGambar.required = false;
            inputVideo.required  = true;
            if (inputGambar) inputGambar.disabled = true;
            if (inputVideo) inputVideo.disabled = false;
            updateSubmitBtn();
        }
    };

    /* ─── SUBMIT GUARD ─── */
    function updateSubmitBtn() {
        if (currentMode === 'video' && !hdValid) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '.5';
            submitBtn.style.cursor = 'not-allowed';
        } else {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
    }

    /* ─── GAMBAR UPLOAD ─── */
    inputGambar.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const sizeMB = (file.size / 1048576).toFixed(2);
        fileInfoTextG.textContent = `${file.name} (${sizeMB} MB)`;
        fileInfoBarG.classList.add('show');
        fileWarnG.classList.toggle('d-none', parseFloat(sizeMB) <= 3);
        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            uploadZoneG.classList.add('d-none');
            previewWrapG.classList.remove('d-none');
            applyToPreview();
        };
        reader.readAsDataURL(file);
    });

    /* ─── VIDEO UPLOAD ─── */
    inputVideo.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const sizeMB = (file.size / 1048576).toFixed(2);
        fileInfoTextV.textContent = `${file.name} (${sizeMB} MB)`;
        fileInfoBarV.classList.add('show');
        fileWarnV.classList.toggle('d-none', parseFloat(sizeMB) <= 30);

        const blobUrl = URL.createObjectURL(file);
        const tempVid = document.createElement('video');
        tempVid.preload = 'metadata';
        tempVid.onloadedmetadata = function () {
            const w = tempVid.videoWidth;
            const h = tempVid.videoHeight;
            URL.revokeObjectURL(blobUrl);

            hdBadgeWrap.style.display = 'block';
            if (w >= 1920 && h >= 1080) {
                hdBadge.className = 'hd-badge hd-ok';
                hdBadgeText.textContent = `✅ ${w}×${h} — Full HD`;
                hdValid = true;
            } else if (w >= 1280 && h >= 720) {
                hdBadge.className = 'hd-badge hd-ok';
                hdBadgeText.textContent = `✅ ${w}×${h} — HD`;
                hdValid = true;
            } else {
                hdBadge.className = 'hd-badge hd-warn';
                hdBadgeText.textContent = `❌ ${w}×${h} — Resolusi terlalu rendah (min. HD 720p)`;
                hdValid = false;
                inputVideo.value = '';
                previewWrapV.classList.add('d-none');
                uploadZoneV.classList.remove('d-none');
            }
            updateSubmitBtn();
        };
        tempVid.src = blobUrl;

        // Tampilkan preview video
        vidPreview.src = URL.createObjectURL(file);
        vidPreview.load();
        uploadZoneV.classList.add('d-none');
        previewWrapV.classList.remove('d-none');
    });

    /* ─── DRAG & DROP GAMBAR ─── */
    ['dragenter','dragover'].forEach(ev => uploadZoneG.addEventListener(ev, e => { e.preventDefault(); uploadZoneG.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(ev => uploadZoneG.addEventListener(ev, e => { e.preventDefault(); uploadZoneG.classList.remove('dragover'); }));
    uploadZoneG.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) { inputGambar.files = e.dataTransfer.files; inputGambar.dispatchEvent(new Event('change')); }
    });

    /* ─── DRAG & DROP VIDEO ─── */
    ['dragenter','dragover'].forEach(ev => uploadZoneV.addEventListener(ev, e => { e.preventDefault(); uploadZoneV.classList.add('dragover'); }));
    ['dragleave','drop'].forEach(ev => uploadZoneV.addEventListener(ev, e => { e.preventDefault(); uploadZoneV.classList.remove('dragover'); }));
    uploadZoneV.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) { inputVideo.files = e.dataTransfer.files; inputVideo.dispatchEvent(new Event('change')); }
    });

    /* ─── POS PAD ─── */
    let posX = 50, posY = 50, dragging = false;
    function applyToPreview() {
        const pos = `${posX.toFixed(1)}% ${posY.toFixed(1)}%`;
        const scale = parseInt(scaleSlider.value) / 100;
        imgPreview.style.objectPosition  = pos;
        imgPreview.style.transformOrigin = pos;
        imgPreview.style.transform       = `scale(${scale})`;
    }
    function updatePadUI() {
        const pctX = posX.toFixed(1) + '%', pctY = posY.toFixed(1) + '%';
        posHandle.style.left = pctX; posHandle.style.top = pctY;
        posLineH.style.top = pctY; posLineV.style.left = pctX;
        const label = `${Math.round(posX)}% ${Math.round(posY)}%`;
        posBadge.textContent = label; posCoordsLabel.textContent = label; posInput.value = label;
        applyToPreview();
    }
    function posFromEvent(e) {
        const rect = posPad.getBoundingClientRect();
        const cx = e.touches ? e.touches[0].clientX : e.clientX;
        const cy = e.touches ? e.touches[0].clientY : e.clientY;
        posX = Math.min(100, Math.max(0, (cx - rect.left) / rect.width * 100));
        posY = Math.min(100, Math.max(0, (cy - rect.top) / rect.height * 100));
        updatePadUI();
    }
    updatePadUI();
    posPad.addEventListener('mousedown', e => { dragging = true; posFromEvent(e); });
    document.addEventListener('mousemove', e => { if (dragging) posFromEvent(e); });
    document.addEventListener('mouseup', () => { dragging = false; });
    posPad.addEventListener('touchstart', e => { e.preventDefault(); posFromEvent(e); }, { passive: false });
    posPad.addEventListener('touchmove',  e => { e.preventDefault(); posFromEvent(e); }, { passive: false });

    /* ─── ZOOM ─── */
    function updateScaleUI() {
        const val = parseInt(scaleSlider.value);
        scaleBadge.textContent = val + '%';
        scaleSlider.style.setProperty('--pct', ((val - 100) / 150 * 100).toFixed(1) + '%');
        applyToPreview();
    }
    updateScaleUI();
    scaleSlider.addEventListener('input', updateScaleUI);

    /* ─── KUALITAS ─── */
    function updateQualityUI() {
        const val = parseInt(qualitySlider.value);
        qualityBadge.textContent = val + '%';
        qualitySlider.style.setProperty('--pct', ((val - 10) / 90 * 100).toFixed(1) + '%');
        let hint, bg, color;
        if (val <= 40)      { hint='⚠️ Kualitas <strong>rendah</strong> — bisa buram.';      bg='#fff5f5'; color='#c0392b'; }
        else if (val <= 70) { hint='✔️ Kualitas <strong>sedang</strong> — seimbang.';          bg='#fffbf0'; color='#d68910'; }
        else                { hint='🌟 Kualitas <strong>tinggi</strong> — tajam, file besar.'; bg='#f0fff4'; color='#27ae60'; }
        qualityHint.style.background = bg; qualityHint.style.color = color;
        qualityHintText.innerHTML = hint;
    }
    updateQualityUI();
    qualitySlider.addEventListener('input', updateQualityUI);

    /* ─── INIT MODE ─── */
    setMode(currentMode);
})();
</script>
@endpush
@endsection
