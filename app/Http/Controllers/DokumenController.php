<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Kategori;
use App\Models\UnitKerja;
use App\Models\LogAktivitas;
use App\Models\User;       
use App\Models\Notifikasi; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dokumen::with(['kategori', 'unitKerja', 'pengunggah']);
        
        // Filter Cari Judul/Nomor
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('judul_dokumen', 'like', '%' . $request->cari . '%')
                  ->orWhere('nomor_dokumen', 'like', '%' . $request->cari . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // --- TAMBAHAN BARU: Filter Status Retensi ---
        if ($request->filled('status_retensi')) {
            $query->where('status_retensi', $request->status_retensi);
        }

        $dokumen = $query->latest('tanggal_unggah')->paginate(10);
        $kategori = Kategori::all();
        
        return view('dokumen.index', compact('dokumen', 'kategori'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $unitKerja = UnitKerja::all();
        return view('dokumen.create', compact('kategori', 'unitKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'required|string|max:100',
            'id_kategori'   => 'required|exists:kategori,id',
            'tahun_dokumen' => 'required|integer|digits:4',
            'file_dokumen'  => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'deskripsi'     => 'nullable|string'
        ]);

        $idUnitKerja = Auth::user()->id_unit_kerja;
        if (Auth::user()->role->nama_peran === 'Admin' && $request->filled('id_unit_kerja')) {
            $idUnitKerja = $request->id_unit_kerja;
        }

        $file = $request->file('file_dokumen');
        $extension = $file->getClientOriginalExtension();
        $ukuran = $file->getSize() / 1024;
        $namaFileBaru = $request->tahun_dokumen . '_' . Str::slug($request->judul_dokumen) . '_' . Str::random(5) . '.' . $extension;
        $path = $file->storeAs('public/documents/' . $request->tahun_dokumen, $namaFileBaru);
        
        $dokumen = Dokumen::create([
            'id_kategori'   => $request->id_kategori,
            'id_unit_kerja' => $idUnitKerja,
            'id_pengunggah' => Auth::id(),
            'nomor_dokumen' => $request->nomor_dokumen,
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi'     => $request->deskripsi,
            'tahun_dokumen' => $request->tahun_dokumen,
            'lokasi_file'   => $path,
            'tipe_file'     => $extension,
            'ukuran_file'   => round($ukuran),
            'status_retensi'=> 'Aktif'
        ]);

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'tipe_aktivitas' => 'UPLOAD',
            'keterangan' => 'Mengunggah dokumen: ' . $request->judul_dokumen,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // --- PERUBAHAN DI SINI (NOTIFIKASI KE SEMUA USER) ---
        
        // Ambil semua user yang statusnya AKTIF
        $allUsers = User::where('status_aktif', true)->get();

        foreach($allUsers as $user) {
            // Kirim notifikasi ke semua user KECUALI si pengunggah itu sendiri
            if($user->id !== Auth::id()) {
                Notifikasi::create([
                    'id_user' => $user->id,
                    'judul'   => 'Dokumen Baru Diunggah',
                    'pesan'   => Auth::user()->nama_lengkap . ' baru saja mengunggah dokumen: ' . $request->judul_dokumen,
                    'link_target' => route('dokumen.show', $dokumen->id),
                    'tipe_notifikasi' => 'info'
                ]);
            }
        }
        // ----------------------------------------------------

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diarsipkan.');
    }

    public function show($id)
    {
        $dokumen = Dokumen::with(['kategori', 'unitKerja', 'pengunggah'])->findOrFail($id);
        return view('dokumen.show', compact('dokumen'));
    }

    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        $canEditDelete = Auth::user()->role->nama_peran === 'Admin' 
                      || Auth::id() == $dokumen->id_pengunggah 
                      || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dokumen->id_unit_kerja);

        if (!$canEditDelete) {
            return abort(403, 'Anda tidak memiliki izin mengedit dokumen ini.');
        }
        $kategori = Kategori::all();
        $unitKerja = UnitKerja::all();
        return view('dokumen.edit', compact('dokumen', 'kategori', 'unitKerja'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $canEditDelete = Auth::user()->role->nama_peran === 'Admin' 
                      || Auth::id() == $dokumen->id_pengunggah 
                      || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dokumen->id_unit_kerja);

        if (!$canEditDelete) {
            return abort(403);
        }

        $request->validate([
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'required|string|max:100',
            'id_kategori'   => 'required|exists:kategori,id',
            'tahun_dokumen' => 'required|integer|digits:4',
            'file_dokumen'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'deskripsi'     => 'nullable|string'
        ]);

        $dataUpdate = [
            'judul_dokumen' => $request->judul_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'id_kategori'   => $request->id_kategori,
            'tahun_dokumen' => $request->tahun_dokumen,
            'deskripsi'     => $request->deskripsi,
        ];

        if (Auth::user()->role->nama_peran === 'Admin' && $request->filled('id_unit_kerja')) {
            $dataUpdate['id_unit_kerja'] = $request->id_unit_kerja;
        }

        if ($request->hasFile('file_dokumen')) {
            if (Storage::exists($dokumen->lokasi_file)) {
                Storage::delete($dokumen->lokasi_file);
            }
            $file = $request->file('file_dokumen');
            $extension = $file->getClientOriginalExtension();
            $ukuran = $file->getSize() / 1024;
            $namaFileBaru = $request->tahun_dokumen . '_' . Str::slug($request->judul_dokumen) . '_' . Str::random(5) . '.' . $extension;
            $path = $file->storeAs('public/documents/' . $request->tahun_dokumen, $namaFileBaru);

            $dataUpdate['lokasi_file'] = $path;
            $dataUpdate['tipe_file'] = $extension;
            $dataUpdate['ukuran_file'] = round($ukuran);
        }

        $dokumen->update($dataUpdate);

        LogAktivitas::create([
            'id_user' => Auth::id(),
            'tipe_aktivitas' => 'UPDATE',
            'keterangan' => 'Memperbarui dokumen: ' . $request->judul_dokumen,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->route('dokumen.show', $id)->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'tipe_aktivitas' => 'DOWNLOAD',
            'keterangan' => 'Mengunduh dokumen: ' . $dokumen->judul_dokumen,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        return Storage::download($dokumen->lokasi_file, $dokumen->judul_dokumen . '.' . $dokumen->tipe_file);
    }

    /**
     * Preview File di Browser
     */
    public function preview($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // 1. Cek Fisik File
        if (!Storage::exists($dokumen->lokasi_file)) {
            return response()->make('<div style="text-align:center; padding:20px;">File fisik tidak ditemukan di server.</div>', 404);
        }

        $path = Storage::path($dokumen->lokasi_file);
        $extension = strtolower($dokumen->tipe_file);

        // 2. Jika File Word/Excel (Office) -> Tampilkan Pesan Download
        if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx'])) {
            $downloadLink = route('dokumen.download', $id);
            $html = '
                <div style="font-family:sans-serif; text-align:center; padding:50px; color:#555;">
                    <svg style="width:50px; height:50px; margin-bottom:15px; color:#888;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p style="font-size:18px; margin-bottom:10px;">Pratinjau tidak tersedia untuk format <b>.'.$extension.'</b></p>
                    <p>Browser tidak mendukung pembacaan file Office secara langsung.</p>
                    <br>
                    <a href="'.$downloadLink.'" style="background:#2563EB; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; font-weight:bold;">Download File</a>
                </div>
            ';
            return response()->make($html, 200, ['Content-Type' => 'text/html']);
        }

        // 3. Persiapan Base64 (Hanya untuk PDF dan Gambar)
        $fileContent = file_get_contents($path);
        $base64 = base64_encode($fileContent);
        $mime = Storage::mimeType($dokumen->lokasi_file);

        // 4. Logika Tampilan Berdasarkan Tipe File
        if ($extension === 'pdf') {
            // Tampilan Khusus PDF (Iframe full)
            $src = 'data:application/pdf;base64,' . $base64;
            $content = '<iframe src="' . $src . '" style="width:100%; height:100%; border:none;"></iframe>';
        } 
        elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
            // Tampilan Khusus Gambar (Img tag)
            $src = 'data:' . $mime . ';base64,' . $base64;
            $content = '<div style="display:flex; justify-content:center; align-items:center; height:100%; background:#f3f4f6;">
                            <img src="' . $src . '" style="max-width:100%; max-height:100%; box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                        </div>';
        } 
        else {
            // Fallback untuk tipe lain
            return response()->make('Format file tidak didukung untuk preview.', 200);
        }

        // 5. Return HTML untuk "menipu" IDM
        // Kita bungkus dalam HTML penuh agar styling (height 100%) berfungsi
        $htmlWrapper = '
            <!DOCTYPE html>
            <html style="height:100%; margin:0;">
            <body style="height:100%; margin:0; overflow:hidden;">
                ' . $content . '
            </body>
            </html>
        ';

        return response()->make($htmlWrapper, 200, ['Content-Type' => 'text/html']);
    }

    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        $canEditDelete = Auth::user()->role->nama_peran === 'Admin' 
                      || Auth::id() == $dokumen->id_pengunggah 
                      || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dokumen->id_unit_kerja);

        if (!$canEditDelete) {
            return abort(403, 'Anda tidak berhak menghapus dokumen ini.');
        }
        if (Storage::exists($dokumen->lokasi_file)) {
            Storage::delete($dokumen->lokasi_file);
        }
        $judul = $dokumen->judul_dokumen;
        $dokumen->delete();
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'tipe_aktivitas' => 'DELETE',
            'keterangan' => 'Menghapus dokumen: ' . $judul,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}