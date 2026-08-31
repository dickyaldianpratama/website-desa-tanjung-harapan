<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Desa - {{ $layanan->nomor_surat ?? $layanan->nomor_tiket }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #e0e0e0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        .a4-page {
            background: #fff;
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            margin: 20px 0;
            position: relative;
        }
        
        /* Kop Surat */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }
        .kop-surat::after {
            content: '';
            position: absolute;
            left: 20mm;
            right: 20mm;
            top: calc(20mm + 115px);
            border-bottom: 1px solid #000;
        }
        .logo-container { width: 90px; text-align: center; }
        .logo-container img { max-width: 80px; height: auto; }
        .kop-text { flex-grow: 1; text-align: center; line-height: 1.1; }
        .kop-text h2 { margin: 0; font-size: 16pt; font-weight: normal; text-transform: uppercase; }
        .kop-text h1 { margin: 5px 0; font-size: 20pt; font-weight: bold; text-transform: uppercase; }
        .kop-text p { margin: 0; font-size: 11pt; }

        /* Isi Surat */
        .surat-body { padding: 30px 15px; font-size: 12pt; line-height: 1.5; text-align: justify; }
        .surat-title { text-align: center; margin-bottom: 30px; }
        .surat-title h3 { margin: 0; font-size: 14pt; text-decoration: underline; text-transform: uppercase; }
        .surat-title p { margin: 5px 0 0; }

        .table-biodata { width: 100%; margin: 20px 0 20px 30px; }
        .table-biodata td { padding: 4px 0; vertical-align: top; }
        .table-biodata td:first-child { width: 180px; }
        .table-biodata td:nth-child(2) { width: 20px; }

        /* Tanda Tangan */
        .ttd-section { margin-top: 50px; display: flex; justify-content: flex-end; }
        .ttd-box { width: 300px; text-align: center; }
        .ttd-box p { margin: 0; line-height: 1.5; }
        .ttd-kades-img { height: 90px; object-fit: contain; margin: 10px 0; }
        
        .btn-print-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #198754;
            color: #fff;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        @media print {
            body { background: #fff; margin: 0; display: block; }
            .a4-page { width: auto; min-height: auto; margin: 0; padding: 15mm; box-shadow: none; border: none; }
            .kop-surat::after { left: 15mm; right: 15mm; top: calc(15mm + 115px); }
            .btn-print-floating { display: none; }
        }
    </style>
</head>
<body>

<div class="a4-page">
    
    <!-- Kop Surat -->
    <div class="kop-surat">
        <div class="logo-container">
            @if(isset($settings['logo_desa']) && $settings['logo_desa'])
                <img src="{{ asset('images/logo/'.$settings['logo_desa']) }}" alt="Logo">
            @else
                <img src="{{ asset('images/logo_desa.png') }}" alt="Logo Desa Tanjung Harapan">
            @endif
        </div>
        <div class="kop-text">
            <h2>PEMERINTAH KABUPATEN {{ strtoupper(str_replace('Kabupaten ', '', $settings['nama_kabupaten'] ?? 'KAMPAR')) }}</h2>
            <h2>KECAMATAN {{ strtoupper(str_replace('Kecamatan ', '', $settings['nama_kecamatan'] ?? 'KAMPAR KIRI')) }}</h2>
            <h1>{{ strtoupper($settings['nama_desa'] ?? 'DESA TANJUNG HARAPAN') }}</h1>
            <p>{{ $settings['alamat_desa'] ?? $settings['alamat'] ?? 'Alamat Desa Belum Diatur' }}</p>
            <p>Telepon: {{ $settings['telepon_desa'] ?? $settings['telepon'] ?? '-' }} | Email: {{ $settings['email_desa'] ?? $settings['email'] ?? '-' }} | Website: www.desatanjungharapan.site</p>
        </div>
    </div>

    <!-- Isi Surat -->
    <div class="surat-body">
        <div class="surat-title">
            <h3>{{ strtoupper($layanan->jenis_layanan) }}</h3>
            <p>Nomor: {{ $layanan->nomor_surat ?? '......./......./......./20..' }}</p>
        </div>

        <p>Yang bertanda tangan di bawah ini Kepala {{ $settings['nama_desa'] ?? 'Desa Tanjung Harapan' }}, Kecamatan {{ str_replace('Kecamatan ', '', $settings['nama_kecamatan'] ?? 'Kampar Kiri') }}, Kabupaten {{ str_replace('Kabupaten ', '', $settings['nama_kabupaten'] ?? 'Kampar') }}, dengan ini menerangkan bahwa:</p>

        <table class="table-biodata">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $layanan->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $layanan->nik }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $layanan->keperluan ?: 'Sesuai dengan jenis surat yang diajukan.' }}</td>
            </tr>
        </table>

        <p>Bahwa nama tersebut di atas benar adalah warga kami dan mengajukan permohonan <strong>{{ $layanan->jenis_layanan }}</strong>.</p>
        <p>Demikian surat keterangan ini kami buat dengan sebenarnya, untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="ttd-section">
        <div class="ttd-box">
            <p>{{ str_replace('Desa ', '', $settings['nama_desa'] ?? 'Tanjung Harapan') }}, {{ \Carbon\Carbon::parse($layanan->updated_at)->locale('id')->translatedFormat('d F Y') }}</p>
            <p>{{ $settings['jabatan_kades'] ?? 'Kepala Desa' }}</p>
            
            @if(isset($settings['foto_kades']) && $settings['foto_kades'])
                <!-- Ruang kosong untuk ditempel/di-import tanda tangan -->
                <div style="height: 90px; margin: 15px 0;"></div>
            @else
                <div style="height: 70px; margin: 15px 0;"></div>
            @endif

            <p style="font-weight: bold; text-decoration: underline;">{{ $settings['nama_kades'] ?? 'NAMA KADES' }}</p>
        </div>
    </div>

</div>

<button class="btn-print-floating" onclick="window.print()">🖨️ Cetak PDF / Print</button>

</body>
</html>
