@extends('layouts.admin')
@section('title', 'Tambah Banner')

@push('styles')
<style>
/* ══════════════════════════════════════════
   UPLOAD ZONE
══════════════════════════════════════════ */
.upload-zone {
    border: 2.5px dashed #c9963a;
    border-radius: 14px;
    background: linear-gradient(135deg,#fffdf7,#fff8ec);
    cursor: pointer;
    transition: all .25s;
    min-height: 180px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 10px; padding: 24px;
}
.upload-zone:hover,.upload-zone.dragover {
    border-color: #b07d20;
    background: linear-gradient(135deg,#fff3d4,#ffe8a0);
    box-shadow: 0 0 0 4px rgba(201,150,58,.12);
}
.upload-icon-wrap {
    width:64px;height:64px;
    background:linear-gradient(135deg,#c9963a,#e8b84b);
    border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:1.7rem;color:#fff;
    box-shadow:0 4px 16px rgba(201,150,58,.35);
    transition:transform .25s;
}
.upload-zone:hover .upload-icon-wrap{transform:scale(1.1) rotate(-6deg);}

/* ══════════════════════════════════════════
   PREVIEW 16:9
══════════════════════════════════════════ */
.preview-wrap {
    position:relative; width:100%; aspect-ratio:16/9;
    border-radius:14px; overflow:hidden;
    background:#1a1a2e;
    box-shadow:0 6px 24px rgba(0,0,0,.25);
}
.preview-wrap img#imgPreview {
    position:absolute; inset:0;
    width:100%; height:100%;
    object-fit:cover;
    object-position:50% 50%;
    transform-origin:50% 50%;
    transform:scale(1);
    transition:object-position .2s, transform .2s, transform-origin .2s;
}
.preview-overlay {
    position:absolute;inset:0;
    background:linear-gradient(to top,rgba(0,0,0,.5) 0%,transparent 55%);
    display:flex;align-items:flex-end;padding:12px;
    pointer-events:none;
}
.preview-label {
    font-size:.7rem;color:rgba(255,255,255,.85);
    background:rgba(0,0,0,.4);padding:3px 10px;border-radius:20px;
}
.preview-change-btn {
    position:absolute;top:10px;right:10px;
    background:rgba(0,0,0,.5);color:#fff;font-size:.72rem;
    padding:5px 12px;border-radius:20px;cursor:pointer;
    display:flex;align-items:center;gap:5px;
    transition:background .2s;border:none;
}
.preview-change-btn:hover{background:rgba(201,150,58,.85);}

/* ══════════════════════════════════════════
   GUIDE CARD
══════════════════════════════════════════ */
.guide-card {
    background:linear-gradient(135deg,#fff8ec,#fff3d4);
    border:1.5px solid rgba(201,150,58,.35);
    border-radius:12px; padding:14px 16px;
}
.guide-item {
    display:flex;align-items:flex-start;gap:8px;
    font-size:.79rem;color:#555;line-height:1.4;
    margin-bottom:7px;
}
.guide-item:last-child{margin-bottom:0}
.guide-icon{flex-shrink:0;margin-top:1px}

/* ══════════════════════════════════════════
   FILE INFO BAR
══════════════════════════════════════════ */
.file-info-bar {
    display:none;align-items:center;gap:8px;
    background:#e8f4fd;border:1px solid #b8daff;
    border-radius:10px;padding:8px 14px;font-size:.79rem;
}
.file-info-bar.show{display:flex;}

/* ══════════════════════════════════════════
   TOOLS PANEL
══════════════════════════════════════════ */
.tools-panel {
    background:#fff;
    border:1.5px solid #e9ecef;
    border-radius:14px;padding:20px;
}

/* Drag Pad */
.pos-pad {
    width:100%; aspect-ratio:16/9;
    background:
        repeating-linear-gradient(rgba(201,150,58,.1) 0 1px,transparent 1px 100%) 0 0/16.66% 100%,
        repeating-linear-gradient(90deg,rgba(201,150,58,.1) 0 1px,transparent 1px 100%) 0 0/100% 25%,
        linear-gradient(135deg,#f5f0e8,#fdfaf5);
    border:2px solid #c9963a;
    border-radius:12px;
    position:relative; cursor:crosshair;
    overflow:hidden; user-select:none;
    touch-action:none;
}
.pos-pad:active{cursor:grabbing;}
.pos-center-mark {
    position:absolute;top:50%;left:50%;
    width:6px;height:6px;border-radius:50%;
    background:rgba(201,150,58,.4);
    transform:translate(-50%,-50%);pointer-events:none;
}
.pos-line-h,.pos-line-v {
    position:absolute;pointer-events:none;
    background:rgba(201,150,58,.55);
}
.pos-line-h{height:1px;left:0;right:0;top:50%;}
.pos-line-v{width:1px;top:0;bottom:0;left:50%;}
.pos-handle {
    position:absolute;top:50%;left:50%;
    width:30px;height:30px;
    transform:translate(-50%,-50%);
    background:linear-gradient(135deg,#c9963a,#f0c060);
    border:3px solid #fff;border-radius:50%;
    cursor:grab;box-shadow:0 3px 14px rgba(0,0,0,.3);
    z-index:5;display:flex;align-items:center;justify-content:center;
    transition:box-shadow .15s,transform .1s;
}
.pos-handle:active{cursor:grabbing;transform:translate(-50%,-50%) scale(1.15);}
.pos-handle::before,.pos-handle::after{
    content:'';position:absolute;background:rgba(255,255,255,.85);border-radius:2px;
}
.pos-handle::before{width:2px;height:12px;}
.pos-handle::after{width:12px;height:2px;}
.pos-coords-badge {
    position:absolute;bottom:6px;right:8px;
    background:rgba(0,0,0,.5);color:#fff;
    font-size:.65rem;padding:2px 8px;border-radius:20px;
    pointer-events:none;
}

/* Range Sliders */
.tool-label {
    font-size:.78rem;font-weight:600;color:#444;
    display:flex;align-items:center;justify-content:space-between;
    margin-bottom:6px;
}
.val-badge {
    background:#f1f3f5;padding:2px 10px;border-radius:20px;
    font-weight:700;color:#c9963a;font-size:.76rem;
    min-width:52px;text-align:center;
}
input[type=range].tool-range {
    -webkit-appearance:none;width:100%;height:6px;border-radius:3px;
    background:linear-gradient(to right,#c9963a 0%,#c9963a var(--pct,75%),#e0e0e0 var(--pct,75%),#e0e0e0 100%);
    outline:none;cursor:pointer;
}
input[type=range].tool-range::-webkit-slider-thumb {
    -webkit-appearance:none;width:20px;height:20px;
    border-radius:50%;background:#fff;border:3px solid #c9963a;
    box-shadow:0 2px 8px rgba(0,0,0,.15);cursor:pointer;
    transition:box-shadow .15s,transform .15s;
}
input[type=range].tool-range::-webkit-slider-thumb:hover {
    box-shadow:0 0 0 6px rgba(201,150,58,.2);transform:scale(1.1);
}
.hint-box {
    margin-top:8px;padding:8px 12px;border-radius:10px;
    font-size:.74rem;line-height:1.45;
    background:#f0fff4;color:#27ae60;
    transition:background .3s,color .3s;
}
.section-sep{border:0;border-top:1.5px dashed #e0e0e0;margin:16px 0;}
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

        {{-- Hidden fields --}}
        <input type="hidden" id="image_position" name="image_position"
               value="{{ old('image_position', '50% 50%') }}">

        <div class="row g-4">

            {{-- ═══════════════ KOLOM KIRI ═══════════════ --}}
            <div class="col-md-8">

                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Banner <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="text" name="judul"
                           class="form-control form-control-lg @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}"
                           placeholder="Contoh: Selamat Datang di Desa Kami"
                           maxlength="60">
                    <small class="text-muted" style="font-size:.75rem;">Maks. 60 karakter.</small>
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Subtitle --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Teks Subtitle <span class="text-muted fw-normal">(Opsional)</span></label>
                    <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                              rows="3" placeholder="Teks kecil di bawah judul..." maxlength="150">{{ old('subtitle') }}</textarea>
                    <small class="text-muted" style="font-size:.75rem;">Maks. 150 karakter.</small>
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- ── GAMBAR BANNER ── --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="bi bi-image me-1 text-warning"></i>
                        Gambar Banner <span class="text-danger">*</span>
                    </label>

                    {{-- Panduan --}}
                    <div class="guide-card mb-3">
                        <div style="font-size:.82rem;font-weight:700;color:#b07d20;margin-bottom:9px;">
                            <i class="bi bi-info-circle-fill me-1"></i> Panduan Import Gambar Banner
                        </div>
                        <div class="guide-item"><span class="guide-icon">📐</span><span>Rasio ideal <strong>16:9</strong> — resolusi min. <strong>1280×720 px</strong>, disarankan <strong>1920×1080 px</strong>.</span></div>
                        <div class="guide-item"><span class="guide-icon">🗂️</span><span>Format: <strong>JPG · PNG · WEBP</strong>. Otomatis dikompres ke JPEG sesuai kualitas pilihan Anda.</span></div>
                        <div class="guide-item"><span class="guide-icon">⚖️</span><span>Maks. file <strong>5 MB</strong>. Gunakan slider Kualitas untuk menyeimbangkan ketajaman & ukuran file.</span></div>
                        <div class="guide-item"><span class="guide-icon">🎯</span><span><strong>Seret titik fokus</strong> di pad posisi untuk memastikan bagian penting gambar selalu terlihat.</span></div>
                        <div class="guide-item"><span class="guide-icon">🔍</span><span><strong>Slider Zoom</strong> untuk memperbesar/memperkecil tampilan gambar tanpa mengubah file asli.</span></div>
                    </div>

                    {{-- Upload Zone --}}
                    <div class="upload-zone mb-2" id="uploadZone"
                         onclick="document.getElementById('gambar').click()">
                        <div class="upload-icon-wrap"><i class="bi bi-cloud-upload"></i></div>
                        <p class="fw-bold mb-0" style="color:#b07d20;">Klik atau seret gambar ke sini</p>
                        <p class="text-muted small mb-0">JPG · PNG · WEBP — Maks. 5 MB — Rasio ideal 16:9</p>
                    </div>

                    {{-- Preview (tersembunyi sebelum gambar dipilih) --}}
                    <div class="preview-wrap mb-2 d-none" id="previewWrap">
                        <img id="imgPreview" src="#" alt="Preview Banner">
                        <div class="preview-overlay">
                            <span class="preview-label"><i class="bi bi-aspect-ratio me-1"></i>Preview 16:9</span>
                        </div>
                        <button type="button" class="preview-change-btn"
                                onclick="document.getElementById('gambar').click()">
                            <i class="bi bi-pencil-square"></i> Ganti Gambar
                        </button>
                    </div>

                    <input class="form-control d-none" type="file" id="gambar" name="gambar"
                           accept="image/jpeg,image/png,image/webp" required>
                    @error('gambar')<div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror

                    <div class="file-info-bar mt-2" id="fileInfoBar">
                        <i class="bi bi-file-earmark-image"></i>
                        <span id="fileInfoText">—</span>
                        <span id="fileWarnBadge" class="badge bg-warning text-dark ms-auto d-none">File Besar</span>
                    </div>
                </div>

            </div>

            {{-- ═══════════════ KOLOM KANAN ═══════════════ --}}
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

                {{-- ══ TOOLS OPTIMASI GAMBAR ══ --}}
                <div class="tools-panel mb-4">
                    <h6 class="mb-3"><i class="bi bi-image-alt me-2 text-warning"></i>Tools Optimasi Gambar</h6>

                    {{-- ── POSISI GAMBAR (2D Drag Pad) ── --}}
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
                            <i class="bi bi-hand-index-thumb me-1 text-warning"></i>
                            Seret titik emas untuk memilih area fokus gambar.
                        </small>
                    </div>

                    <hr class="section-sep">

                    {{-- ── ZOOM ── --}}
                    <div class="mb-4">
                        <div class="tool-label">
                            <span><i class="bi bi-zoom-in me-1"></i>Zoom Gambar</span>
                            <span class="val-badge" id="scaleBadge">100%</span>
                        </div>
                        <input type="range" id="scaleSlider" name="image_scale"
                               class="tool-range" min="100" max="250" step="5"
                               value="{{ old('image_scale', 100) }}">
                        <div class="d-flex justify-content-between mt-1" style="font-size:.66rem;color:#aaa;">
                            <span>Normal (1×)</span><span>1.5×</span><span>Zoom Max (2.5×)</span>
                        </div>
                    </div>

                    <hr class="section-sep">

                    {{-- ── KUALITAS ── --}}
                    <div>
                        <div class="tool-label">
                            <span><i class="bi bi-stars me-1"></i>Kualitas Kompresi</span>
                            <span class="val-badge" id="qualityBadge">85%</span>
                        </div>
                        <input type="range" id="qualitySlider" name="image_quality"
                               class="tool-range" min="10" max="100" step="5"
                               value="{{ old('image_quality', 85) }}">
                        <div class="d-flex justify-content-between mt-1" style="font-size:.66rem;color:#aaa;">
                            <span>Hemat (kecil)</span><span>Seimbang</span><span>Tajam (besar)</span>
                        </div>
                        <div class="hint-box" id="qualityHint">
                            <span id="qualityHintText">—</span>
                        </div>
                    </div>
                </div>

                {{-- Simpan --}}
                <button type="submit" class="btn w-100 py-3 fw-bold"
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
    const gambarInput    = document.getElementById('gambar');
    const imgPreview     = document.getElementById('imgPreview');
    const previewWrap    = document.getElementById('previewWrap');
    const uploadZone     = document.getElementById('uploadZone');
    const fileInfoBar    = document.getElementById('fileInfoBar');
    const fileInfoText   = document.getElementById('fileInfoText');
    const fileWarnBadge  = document.getElementById('fileWarnBadge');

    const posInput       = document.getElementById('image_position');
    const posBadge       = document.getElementById('posBadge');
    const posCoordsLabel = document.getElementById('posCoordsLabel');
    const posPad         = document.getElementById('posPad');
    const posHandle      = document.getElementById('posHandle');
    const posLineH       = document.getElementById('posLineH');
    const posLineV       = document.getElementById('posLineV');

    const scaleSlider    = document.getElementById('scaleSlider');
    const scaleBadge     = document.getElementById('scaleBadge');
    const qualitySlider  = document.getElementById('qualitySlider');
    const qualityBadge   = document.getElementById('qualityBadge');
    const qualityHint    = document.getElementById('qualityHint');
    const qualityHintText= document.getElementById('qualityHintText');

    let posX = 50, posY = 50;

    function applyToPreview() {
        if (!imgPreview) return;
        const pos   = `${posX.toFixed(1)}% ${posY.toFixed(1)}%`;
        const scale = parseInt(scaleSlider.value) / 100;
        imgPreview.style.objectPosition  = pos;
        imgPreview.style.transformOrigin = pos;
        imgPreview.style.transform       = `scale(${scale})`;
    }

    function updatePadUI() {
        const pctX = posX.toFixed(1) + '%';
        const pctY = posY.toFixed(1) + '%';
        posHandle.style.left = pctX;
        posHandle.style.top  = pctY;
        posLineH.style.top   = pctY;
        posLineV.style.left  = pctX;
        const label = `${Math.round(posX)}% ${Math.round(posY)}%`;
        posBadge.textContent       = label;
        posCoordsLabel.textContent = label;
        posInput.value             = label;
        applyToPreview();
    }

    function posFromEvent(e) {
        const rect    = posPad.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        posX = Math.min(100, Math.max(0, (clientX - rect.left)  / rect.width  * 100));
        posY = Math.min(100, Math.max(0, (clientY - rect.top)   / rect.height * 100));
        updatePadUI();
    }

    // Init dengan nilai default
    updatePadUI();

    // Mouse drag
    let dragging = false;
    posPad.addEventListener('mousedown', e => { dragging = true; posFromEvent(e); });
    document.addEventListener('mousemove', e => { if (dragging) posFromEvent(e); });
    document.addEventListener('mouseup',   () => { dragging = false; });

    // Touch drag
    posPad.addEventListener('touchstart', e => { e.preventDefault(); posFromEvent(e); }, { passive: false });
    posPad.addEventListener('touchmove',  e => { e.preventDefault(); posFromEvent(e); }, { passive: false });

    // Zoom
    function updateScaleUI() {
        const val = parseInt(scaleSlider.value);
        scaleBadge.textContent = val + '%';
        scaleSlider.style.setProperty('--pct', ((val - 100) / 150 * 100).toFixed(1) + '%');
        applyToPreview();
    }
    updateScaleUI();
    scaleSlider.addEventListener('input', updateScaleUI);

    // Kualitas
    function updateQualityUI() {
        const val = parseInt(qualitySlider.value);
        qualityBadge.textContent = val + '%';
        qualitySlider.style.setProperty('--pct', ((val - 10) / 90 * 100).toFixed(1) + '%');
        let hint, bg, color;
        if (val <= 40)      { hint='⚠️ Kualitas <strong>rendah</strong> — file kecil tapi mungkin buram/pecah.';       bg='#fff5f5'; color='#c0392b'; }
        else if (val <= 70) { hint='✔️ Kualitas <strong>sedang</strong> — seimbang ukuran file & ketajaman.';           bg='#fffbf0'; color='#d68910'; }
        else                { hint='🌟 Kualitas <strong>tinggi</strong> — gambar tajam & tidak pecah, file agak besar.'; bg='#f0fff4'; color='#27ae60'; }
        qualityHint.style.background = bg;
        qualityHint.style.color      = color;
        qualityHintText.innerHTML    = hint;
    }
    updateQualityUI();
    qualitySlider.addEventListener('input', updateQualityUI);

    // Upload
    gambarInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const sizeMB = (file.size / 1048576).toFixed(2);
        fileInfoText.textContent = `${file.name} (${sizeMB} MB)`;
        fileInfoBar.classList.add('show');
        fileWarnBadge.classList.toggle('d-none', parseFloat(sizeMB) <= 3);

        const reader = new FileReader();
        reader.onload = e => {
            imgPreview.src = e.target.result;
            uploadZone.classList.add('d-none');
            previewWrap.classList.remove('d-none');
            applyToPreview();
        };
        reader.readAsDataURL(file);
    });

    // Drag & drop
    ['dragenter','dragover'].forEach(ev =>
        uploadZone.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.add('dragover'); })
    );
    ['dragleave','drop'].forEach(ev =>
        uploadZone.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.remove('dragover'); })
    );
    uploadZone.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) {
            gambarInput.files = e.dataTransfer.files;
            gambarInput.dispatchEvent(new Event('change'));
        }
    });
})();
</script>
@endpush
@endsection
