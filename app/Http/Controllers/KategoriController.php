<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Ambil data kategori + hitung jumlah dokumen di dalamnya
        $kategori = Kategori::withCount('dokumen')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'masa_retensi'  => 'required|integer|min:1|max:50', // Tahun
        ]);

        Kategori::create($request->only(['nama_kategori', 'masa_retensi']));

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,'.$id,
            'masa_retensi'  => 'required|integer|min:1',
        ]);

        $kategori->update($request->only(['nama_kategori', 'masa_retensi']));

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Validasi: Jangan hapus jika sudah ada dokumen
        if ($kategori->dokumen()->count() > 0) {
            return back()->withErrors(['Gagal menghapus! Masih ada dokumen yang menggunakan kategori ini.']);
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}