<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsensiPerangkat;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan halaman input absensi harian.
     */
    public function index(Request $request)
    {
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : today();

        $perangkats = Perangkat::orderBy('urutan')->get();

        // Ambil absensi yang sudah ada untuk tanggal tersebut
        $absensiMap = AbsensiPerangkat::where('tanggal', $tanggal->format('Y-m-d'))
            ->pluck('status', 'perangkat_id');

        $keteranganMap = AbsensiPerangkat::where('tanggal', $tanggal->format('Y-m-d'))
            ->pluck('keterangan', 'perangkat_id');

        // Ringkasan per status
        $ringkasan = [
            'hadir' => $absensiMap->filter(fn($s) => $s === 'hadir')->count(),
            'izin'  => $absensiMap->filter(fn($s) => $s === 'izin')->count(),
            'belum' => $perangkats->count() - $absensiMap->filter(fn($s) => $s !== 'belum')->count(),
        ];

        return view('admin.absensi.index', compact('perangkats', 'tanggal', 'absensiMap', 'keteranganMap', 'ringkasan'));
    }

    /**
     * Simpan atau update absensi (bulk upsert).
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'               => 'required|date',
            'absensi'               => 'required|array',
            'absensi.*.status'      => 'required|in:hadir,izin,belum',
            'absensi.*.keterangan'  => 'nullable|string|max:200',
        ]);

        $tanggal = $request->tanggal;

        foreach ($request->absensi as $perangkatId => $data) {
            AbsensiPerangkat::updateOrCreate(
                ['perangkat_id' => $perangkatId, 'tanggal' => $tanggal],
                [
                    'status'      => $data['status'],
                    'keterangan'  => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()
            ->route('admin.absensi.index', ['tanggal' => $tanggal])
            ->with('success', 'Data absensi berhasil disimpan untuk tanggal ' . Carbon::parse($tanggal)->translatedFormat('d F Y') . '!');
    }

    /**
     * Riwayat absensi bulanan.
     */
    public function riwayat(Request $request)
    {
        $bulan  = $request->filled('bulan')  ? (int)$request->bulan  : now()->month;
        $tahun  = $request->filled('tahun')  ? (int)$request->tahun  : now()->year;

        $perangkats = Perangkat::orderBy('urutan')->get();

        // Ambil semua absensi bulan tsb, diindeks [perangkat_id][tanggal]
        $absensiRaw = AbsensiPerangkat::whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        $absensiMatrix = [];
        foreach ($absensiRaw as $a) {
            $absensiMatrix[$a->perangkat_id][$a->tanggal->format('d')] = $a->status;
        }

        // Rekap per perangkat
        $rekap = [];
        foreach ($perangkats as $p) {
            $rekap[$p->id] = [
                'hadir' => collect($absensiMatrix[$p->id] ?? [])->filter(fn($s) => $s === 'hadir')->count(),
                'izin'  => collect($absensiMatrix[$p->id] ?? [])->filter(fn($s) => $s === 'izin')->count(),
            ];
        }

        $daysInMonth = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;

        return view('admin.absensi.riwayat', compact('perangkats', 'absensiMatrix', 'rekap', 'bulan', 'tahun', 'daysInMonth'));
    }
}
