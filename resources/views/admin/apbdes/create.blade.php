@extends('layouts.admin')
@section('title', 'Tambah Data APBDes')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card-admin mb-4">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2 text-gold"></i>Tambah Data APBDes
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.apbdes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-bold">Tahun Anggaran</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="uraian" class="form-label fw-bold">Uraian / Deskripsi</label>
                        <input type="text" class="form-control" id="uraian" name="uraian" value="{{ old('uraian') }}" placeholder="Contoh: Dana Desa, Belanja Pembangunan..." required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label fw-bold">Jenis</label>
                        <select class="form-select" id="jenis" name="jenis" required>
                            <option value="pendapatan" {{ old('jenis') == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                            <option value="belanja" {{ old('jenis') == 'belanja' ? 'selected' : '' }}>Belanja</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="anggaran" class="form-label fw-bold">Anggaran (Rp)</label>
                        <input type="text" class="form-control input-rupiah" id="anggaran" name="anggaran" value="{{ old('anggaran') }}" placeholder="Rp 0" required>
                        <small class="text-muted">Otomatis diformat menjadi Rupiah. Angka bersih yang akan disimpan.</small>
                    </div>

                    <div class="mb-4">
                        <label for="realisasi" class="form-label fw-bold">Realisasi (Rp)</label>
                        <input type="text" class="form-control input-rupiah" id="realisasi" name="realisasi" value="{{ old('realisasi', '0') }}" placeholder="Rp 0" required>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('admin.apbdes.index') }}" class="btn btn-light border">Batal</a>
                        <button type="submit" class="btn btn-primary" style="background: var(--coklat-tua); border-color: var(--coklat-tua);">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format Rupiah Otomatis
    const rupiahInputs = document.querySelectorAll('.input-rupiah');
    
    rupiahInputs.forEach(input => {
        input.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp ');
        });
        
        // Format nilai awal jika ada (untuk old input)
        if(input.value && !isNaN(input.value)) {
            input.value = formatRupiah(input.value, 'Rp ');
        }
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split         = number_string.split(','),
            sisa          = split[0].length % 3,
            rupiah        = split[0].substr(0, sisa),
            ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }
</script>
@endpush
