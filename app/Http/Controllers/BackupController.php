<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use App\Models\Dokumen;
use ZipArchive; // Class bawaan PHP
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        // Ambil list tahun yang ada dokumennya untuk dropdown
        $tahunTersedia = Dokumen::select('tahun_dokumen')
                            ->distinct()
                            ->orderBy('tahun_dokumen', 'desc')
                            ->pluck('tahun_dokumen');

        return view('admin.backup.index', compact('tahunTersedia'));
    }




    /**
     * Backup 2: Arsip Dokumen (.zip) - Untuk User Desa
     */
    /**
     * Backup 2: Arsip Dokumen (.zip) - REVISI ANTI-ERROR
     */
    public function backupArsip(Request $request)
    {
        $request->validate(['tahun' => 'required|integer']);
        $tahun = $request->tahun;

        // 1. Tentukan Path Folder menggunakan Facade Storage (Lebih Aman di Windows)
        // Ini mengarah ke: storage/app/public/documents/{TAHUN}
        $relativeDir = 'public/documents/' . $tahun;
        
        // Cek apakah path folder tersebut benar-benar ada di harddisk
        if (!Storage::exists($relativeDir) && !File::isDirectory(Storage::path($relativeDir))) {
            return back()->withErrors(['Folder arsip fisik untuk tahun ' . $tahun . ' tidak ditemukan di server.']);
        }

        // Ambil Path Absolut (C:\laragon\www\...\storage\app\public\documents\2026)
        $folderPath = Storage::path($relativeDir);
        
        // 2. Siapkan Nama File ZIP
        $zipFileName = 'Arsip_Desa_Tahun_' . $tahun . '.zip';
        // Simpan ZIP sementara di folder storage/app/public
        $zipPath = Storage::path('public/' . $zipFileName);

        // 3. Proses Pembuatan ZIP
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            
            // Ambil semua file dalam folder
            $files = File::files($folderPath);
            
            if (count($files) === 0) {
                return back()->withErrors(['Folder tahun ' . $tahun . ' ada, tapi isinya kosong (tidak ada file).']);
            }

            foreach ($files as $file) {
                // Masukkan file ke dalam ZIP
                // Parameter 2: Nama file saja (agar saat diextract tidak beranak folder)
                $zip->addFile($file->getRealPath(), $file->getFilename());
            }
            
            $zip->close();
        } else {
            return back()->withErrors(['Gagal membuat file ZIP. Cek izin folder storage.']);
        }

        // 4. Download & Hapus File ZIP Sementara
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * AJAX: Cek daftar file sebelum download
     */
    public function checkArsip(Request $request)
    {
        $request->validate(['tahun' => 'required|integer']);
        $tahun = $request->tahun;

        // Gunakan logika Path yang sama dengan backupArsip
        $relativeDir = 'public/documents/' . $tahun;
        
        if (!Storage::exists($relativeDir)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Folder tahun ' . $tahun . ' tidak ditemukan.'
            ]);
        }

        $folderPath = Storage::path($relativeDir);
        $files = File::files($folderPath);

        if (count($files) === 0) {
            return response()->json([
                'status' => 'empty',
                'message' => 'Folder tahun ' . $tahun . ' kosong.'
            ]);
        }

        // Susun data file untuk dikirim ke JS
        $fileList = [];
        foreach ($files as $file) {
            $fileList[] = [
                'name' => $file->getFilename(),
                // Konversi ukuran ke KB
                'size' => round($file->getSize() / 1024) . ' KB' 
            ];
        }

        return response()->json([
            'status' => 'success',
            'files' => $fileList,
            'count' => count($fileList)
        ]);
    }
}