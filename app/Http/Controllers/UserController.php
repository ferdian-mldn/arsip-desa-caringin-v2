<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // <--- JANGAN LUPA INI

class UserController extends Controller
{
    public function index()
    {
        // Eager load relasi unitKerja dan role agar query ringan
        $users = User::with(['unitKerja', 'role'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $unitKerja = UnitKerja::all();
        return view('admin.users.create', compact('roles', 'unitKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:50|unique:users',
            'password'     => 'required|string|min:6',
            'id_role'      => 'required|exists:role,id',
            'id_unit_kerja'=> 'nullable|exists:unit_kerja,id',
            'status_aktif' => 'boolean',
            // Validasi Foto
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // CEK ADMIN MAKSIMAL 1
        $role = Role::find($request->id_role);
        if ($role && strtolower($role->nama_peran) == 'admin') {
            $adminExists = User::whereHas('role', function($q) {
                $q->where('nama_peran', 'Admin');
            })->exists();
            
            if ($adminExists) {
                return back()->withErrors(['id_role' => 'Hanya boleh ada 1 Admin di sistem.'])->withInput();
            }
        }

        $data = $request->except(['password', 'foto_profil']);
        $data['password'] = Hash::make($request->password);
        // Default status aktif jika tidak dicentang (null) dianggap false, kita paksa true/false
        $data['status_aktif'] = $request->has('status_aktif'); 

        // LOGIKA UPLOAD FOTO
        if ($request->hasFile('foto_profil')) {
            // Simpan ke folder 'public/foto_profil'
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $data['foto_profil'] = $path;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $unitKerja = UnitKerja::all();
        return view('admin.users.edit', compact('user', 'roles', 'unitKerja'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Username unique kecuali punya diri sendiri
            'username'     => 'required|string|max:50|unique:users,username,'.$id,
            'password'     => 'nullable|string|min:6',
            'id_role'      => 'required|exists:role,id',
            'id_unit_kerja'=> 'nullable|exists:unit_kerja,id',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // CEK ADMIN MAKSIMAL 1 (jika user yang diedit BUKAN admin, tapi diubah jadi admin)
        $role = Role::find($request->id_role);
        if ($role && strtolower($role->nama_peran) == 'admin') {
            $adminExists = User::whereHas('role', function($q) {
                $q->where('nama_peran', 'Admin');
            })->where('id', '!=', $id)->exists();
            
            if ($adminExists) {
                return back()->withErrors(['id_role' => 'Hanya boleh ada 1 Admin di sistem.'])->withInput();
            }
        }

        $data = $request->except(['password', 'foto_profil']);
        
        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $data['status_aktif'] = $request->has('status_aktif');

        // LOGIKA UPDATE FOTO
        if ($request->hasFile('foto_profil')) {
            // 1. Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            // 2. Upload foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $data['foto_profil'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus foto profil dari storage jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}