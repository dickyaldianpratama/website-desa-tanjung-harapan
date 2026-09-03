import os

path = 'resources/views/admin/setting/index.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Add enctype
content = content.replace('<form action="{{ route(\'admin.setting.update\') }}" method="POST">', '<form action="{{ route(\'admin.setting.update\') }}" method="POST" enctype="multipart/form-data">')

# Add new setting-card for Struktur Organisasi
struktur_card = """
            <!-- Bagan Struktur Organisasi -->
            <div class="setting-card">
                <div class="setting-card-header">
                    <i class="bi bi-diagram-3-fill text-primary"></i> Bagan Struktur Organisasi
                </div>
                <div class="setting-card-body">
                    <div class="alert alert-info small mb-4">
                        <i class="bi bi-info-circle me-1"></i> Unggah gambar struktur organisasi yang telah Anda desain (misalnya dari Canva/Corel). Gambar ini akan ditampilkan di halaman Profil. Jika dibiarkan kosong, struktur organisasi tidak akan ditampilkan.
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Struktur Perangkat Desa</label>
                            @if(isset($settings['struktur_perangkat']) && $settings['struktur_perangkat'])
                                <div class="mb-2">
                                    <img src="{{ Storage::disk('s3')->url('images/struktur/' . $settings['struktur_perangkat']) }}" alt="Struktur Perangkat" class="img-fluid rounded border" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="struktur_perangkat" class="form-control form-control-sm" accept="image/*">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Struktur BPD</label>
                            @if(isset($settings['struktur_bpd']) && $settings['struktur_bpd'])
                                <div class="mb-2">
                                    <img src="{{ Storage::disk('s3')->url('images/struktur/' . $settings['struktur_bpd']) }}" alt="Struktur BPD" class="img-fluid rounded border" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="struktur_bpd" class="form-control form-control-sm" accept="image/*">
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Struktur PKK</label>
                            @if(isset($settings['struktur_pkk']) && $settings['struktur_pkk'])
                                <div class="mb-2">
                                    <img src="{{ Storage::disk('s3')->url('images/struktur/' . $settings['struktur_pkk']) }}" alt="Struktur PKK" class="img-fluid rounded border" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="struktur_pkk" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
"""

# Insert right before the last card (Nomor Telepon Darurat)
# First find the telepon darurat card start
telepon_str = '<div class="setting-card">\n                <div class="setting-card-header">\n                    <i class="bi bi-telephone-fill text-danger"></i> Nomor Telepon Penting / Darurat'
if telepon_str not in content:
    telepon_str = '<div class="setting-card">\r\n                <div class="setting-card-header">\r\n                    <i class="bi bi-telephone-fill text-danger"></i> Nomor Telepon Penting / Darurat'

content = content.replace(telepon_str, struktur_card + '\n' + telepon_str)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated setting/index.blade.php")
