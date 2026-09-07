<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function baca($id)
    {
        $notif = Notifikasi::findOrFail($id);

        // Pastikan yg baca adalah pemilik notif
        if ($notif->id_user == Auth::id()) {
            $notif->update(['sudah_dibaca' => true]);
        }

        // Fix Open Redirect: Hanya izinkan redirect ke URL internal aplikasi ini
        $target = $notif->link_target;
        $appUrl = config('app.url');

        if (!str_starts_with($target, $appUrl) && !str_starts_with($target, '/')) {
            return redirect()->route('dashboard');
        }

        // Cek apakah link_target mengarah ke detail dokumen yang sudah dihapus
        // Pola URL: /dokumen/{id} atau {appUrl}/dokumen/{id}
        $pattern = '#/dokumen/(\d+)$#';
        if (preg_match($pattern, $target, $matches)) {
            $dokumenId = $matches[1];
            $dokumen = \App\Models\Dokumen::find($dokumenId);

            if (!$dokumen) {
                // Dokumen sudah dihapus — tampilkan halaman informatif
                return response()->view('notifikasi.dokumen-dihapus', [
                    'notif' => $notif,
                ], 200);
            }
        }

        return redirect($target);
    }
    public function tandaiSemuaDibaca()
    {
        // Update semua notifikasi milik user yang login menjadi sudah_dibaca = true
        Notifikasi::where('id_user', Auth::id())
                  ->where('sudah_dibaca', false)
                  ->update(['sudah_dibaca' => true]);

        // Kembali ke halaman sebelumnya
        return back();
    }
}