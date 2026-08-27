<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket - {{ $layanan->nomor_tiket }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; margin: 0; padding: 2rem; display: flex; justify-content: center; }
        .ticket { background: #fff; width: 100%; max-width: 600px; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 6px solid #C9963A; }
        .text-center { text-align: center; }
        h1 { margin: 0 0 5px 0; font-size: 1.5rem; color: #3D1F0A; }
        p { margin: 0 0 20px 0; color: #666; }
        .info-group { margin-bottom: 15px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
        .info-label { font-size: 0.85rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .info-value { font-size: 1.1rem; font-weight: bold; color: #333; }
        .ticket-number { background: #f9f9f9; padding: 15px; border-radius: 8px; text-align: center; font-size: 1.5rem; font-weight: bold; color: #C9963A; letter-spacing: 2px; margin-bottom: 20px; border: 1px solid #eee; }
        .btn-print { display: block; width: 100%; background: #3D1F0A; color: #fff; text-align: center; padding: 12px; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; border: none; cursor: pointer; }
        @media print {
            body { background: #fff; padding: 0; }
            .ticket { box-shadow: none; border: 1px solid #ccc; }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

<div class="ticket">
    <div class="text-center">
        <h1>Bukti Pengajuan Surat</h1>
        <p>Pemerintah Desa Tanjung Harapan</p>
    </div>

    <div class="ticket-number">
        {{ $layanan->nomor_tiket }}
    </div>

    <div class="info-group">
        <div class="info-label">Nama Pemohon</div>
        <div class="info-value">{{ $layanan->nama_lengkap }}</div>
    </div>
    
    <div class="info-group">
        <div class="info-label">NIK</div>
        <div class="info-value">{{ $layanan->nik }}</div>
    </div>

    <div class="info-group">
        <div class="info-label">Jenis Layanan</div>
        <div class="info-value">{{ $layanan->jenis_layanan }}</div>
    </div>

    <div class="info-group">
        <div class="info-label">Tanggal Pengajuan</div>
        <div class="info-value">{{ $layanan->created_at->format('d M Y, H:i') }} WIB</div>
    </div>

    <div class="text-center" style="margin-top: 30px; font-size: 0.85rem; color: #888;">
        Gunakan Nomor Tiket di atas untuk mengecek status permohonan Anda secara online di website resmi desa.
    </div>

    <button class="btn-print" onclick="window.print()">Cetak / Simpan PDF</button>
</div>

</body>
</html>
