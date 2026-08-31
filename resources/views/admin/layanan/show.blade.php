@extends('layouts.admin')

@section('title', 'Detail Permohonan Surat')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.layanan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Antrean
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold font-serif" style="color: var(--coklat-tua);">Informasi Pengajuan</h5>
                <div>
                    @if($layanan->status == 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                    @elseif($layanan->status == 'diproses')
                        <span class="badge bg-info px-3 py-2 rounded-pill">Diproses</span>
                    @elseif($layanan->status == 'selesai')
                        <span class="badge bg-success px-3 py-2 rounded-pill">Selesai</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                    @endif
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Nomor Tiket</div>
                    <div class="col-sm-8"><span class="fs-5 fw-bold text-primary">{{ $layanan->nomor_tiket }}</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Jenis Surat</div>
                    <div class="col-sm-8 fw-semibold fs-6">{{ $layanan->jenis_layanan }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Nama Lengkap</div>
                    <div class="col-sm-8">{{ $layanan->nama_lengkap }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">NIK</div>
                    <div class="col-sm-8">{{ $layanan->nik }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">No. WhatsApp</div>
                    <div class="col-sm-8 d-flex align-items-center gap-3">
                        {{ $layanan->no_whatsapp }}
                        @php
                            $wa = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $layanan->no_whatsapp));
                            $pesan = "Halo Bpk/Ibu {$layanan->nama_lengkap}, dari Pemerintah Desa Tanjung Harapan terkait permohonan surat tiket {$layanan->nomor_tiket}.";
                        @endphp
                        <a href="https://wa.me/{{ $wa }}?text={{ urlencode($pesan) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                            <i class="bi bi-whatsapp me-1"></i> Chat WA
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Keperluan Khusus</div>
                    <div class="col-sm-8">
                        @if($layanan->keperluan)
                            <div class="bg-light p-3 rounded border">{{ $layanan->keperluan }}</div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Lampiran (KTP/Pengantar)</div>
                    <div class="col-sm-8">
                        @if($layanan->file_lampiran)
                            @php
                                $fileLampiran = $layanan->file_lampiran;
                                // Jika sudah full URL, langsung pakai
                                if (\Illuminate\Support\Str::startsWith($fileLampiran, 'http')) {
                                    $imgUrl = $fileLampiran;
                                } else {
                                    // Bangun URL publik Supabase secara langsung
                                    $supabaseUrl = rtrim(env('SUPABASE_URL', ''), '/');
                                    $bucket      = env('SUPABASE_BUCKET', 'public-images');
                                    $imgUrl      = $supabaseUrl
                                                    ? "{$supabaseUrl}/storage/v1/object/public/{$bucket}/layanan/{$fileLampiran}"
                                                    : asset('storage/layanan/' . $fileLampiran);
                                }
                            @endphp
                            <div class="mb-2">
                                <a href="{{ $imgUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                                    <i class="bi bi-eye me-1"></i> Lihat Lampiran
                                </a>
                            </div>
                            <a href="{{ $imgUrl }}" target="_blank">
                                <img src="{{ $imgUrl }}" class="img-thumbnail rounded" style="max-height: 250px; object-fit: cover; border: 2px solid #dee2e6;">
                            </a>
                        @else
                            <span class="text-muted">Tidak ada lampiran yang diunggah.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 fw-bold font-serif" style="color: var(--coklat-tua);">Update Status</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ubah Status</label>
                        <select name="status" class="form-select" id="select-status">
                            <option value="pending" {{ $layanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ $layanan->status == 'diproses' ? 'selected' : '' }}>Diproses (Sedang Dibuat)</option>
                            <option value="selesai" {{ $layanan->status == 'selesai' ? 'selected' : '' }}>Selesai (Siap Cetak)</option>
                            <option value="ditolak" {{ $layanan->status == 'ditolak' ? 'selected' : '' }}>Ditolak / Batal</option>
                        </select>
                    </div>

                    <div class="mb-3" id="wrap-nomor-surat" style="display: {{ $layanan->status == 'selesai' ? 'block' : 'none' }};">
                        <label class="form-label fw-semibold">Nomor Surat Asli Desa</label>
                        <input type="text" name="nomor_surat" class="form-control" placeholder="Misal: 140/SK/TH/2026/08" value="{{ $layanan->nomor_surat }}">
                        <div class="form-text">Diperlukan agar warga bisa mencetak PDF surat yang valid.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Catatan untuk Warga (Opsional)</label>
                        <textarea name="catatan_admin" class="form-control" rows="4" placeholder="Misal: 'Surat sudah bisa di-download' atau 'Foto KTP buram'.">{{ $layanan->catatan_admin }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold">Simpan Perubahan</button>
                </form>
                
                @if($layanan->status == 'selesai')
                <hr class="my-4">
                <a href="{{ route('layanan.cetakSurat', $layanan->nomor_tiket) }}" target="_blank" class="btn btn-success w-100 rounded-pill py-2 fw-semibold mb-2">
                    <i class="bi bi-printer me-2"></i>Cetak/PDF Surat Asli
                </a>
                @endif
                
                <hr class="my-4">
                
                <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold">
                        <i class="bi bi-trash me-2"></i>Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('select-status').addEventListener('change', function() {
        if(this.value === 'selesai') {
            document.getElementById('wrap-nomor-surat').style.display = 'block';
        } else {
            document.getElementById('wrap-nomor-surat').style.display = 'none';
        }
    });
</script>
@endpush
