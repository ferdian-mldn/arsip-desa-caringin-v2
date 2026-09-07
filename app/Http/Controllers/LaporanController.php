<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Cukup pakai satu ini saja (rekomendasi Laravel modern)

class LaporanController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('laporan.index', compact('kategori'));
    }

    public function cetak(Request $request)
    {
        // 1. VALIDASI WAJIB (Jangan dikosongkan)
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'kategori' => 'nullable'
        ]);

        // 2. Query Data
        $query = Dokumen::with(['kategori', 'pengunggah', 'unitKerja'])
                        ->whereBetween('tanggal_unggah', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59']);

        // Filter Kategori
        $namaKategori = 'Semua Kategori';
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
            
            // Ambil nama kategori dengan aman (cegah error jika ID tidak ketemu)
            $kategoriDipilih = Kategori::find($request->kategori);
            if ($kategoriDipilih) {
                $namaKategori = $kategoriDipilih->nama_kategori;
            }
        }

        $dataDokumen = $query->latest('tanggal_unggah')->get();

        // 3. Generate PDF
        // Gunakan 'Pdf::' (sesuai import Facade di atas)
        $pdf = Pdf::loadView('laporan.pdf', [
            'dokumen'   => $dataDokumen,
            'tgl_awal'  => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'kategori'  => $namaKategori
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Rekapitulasi_Arsip.pdf');
    }

    /**
     * AJAX: Cek Data Laporan (Versi Date Range)
     */
    public function checkLaporan(Request $request)
    {
        $request->validate([
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
            'kategori' => 'nullable'
        ]);

        $query = Dokumen::with(['kategori'])
                        ->whereBetween('tanggal_unggah', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59']);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $dokumen = $query->latest('tanggal_unggah')->get();

        if ($dokumen->isEmpty()) {
            return response()->json([
                'status' => 'empty',
                'message' => 'Tidak ditemukan dokumen pada periode tanggal tersebut.'
            ]);
        }

        $listData = [];
        foreach ($dokumen as $dok) {
            $listData[] = [
                'judul' => $dok->judul_dokumen,
                'nomor' => $dok->nomor_dokumen,
                'kategori' => $dok->kategori->nama_kategori ?? '-', // Pakai null coalescing operator jaga-jaga
                'tanggal' => $dok->tanggal_unggah->format('d/m/Y')
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $listData,
            'count' => count($listData)
        ]);
    }
}