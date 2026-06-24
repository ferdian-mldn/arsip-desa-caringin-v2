@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="w-full">
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Manajemen Pengguna Sistem</h1>
                    <p class="text-sm sm:text-base text-secondary/80 font-medium">Kelola akun pengguna dan hak akses dalam sistem arsip</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="text-sm text-primary font-medium self-start sm:self-center">{{ $users->count() }} pengguna terdaftar</div>
                    <a href="{{ route('admin.users.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="text-sm sm:text-base">Tambah Pengguna</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm sm:text-base text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm sm:text-base text-red-700 font-medium">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 5.197V21m0 0h-6m6 0v-1a6 6 0 00-9-5.197M9 9a4 4 0 118 0"/></svg>
                        <h3 class="text-base sm:text-lg font-semibold text-white">Daftar Pengguna</h3>
                    </div>
                    <div class="text-xs sm:text-sm text-white/90 font-medium">Total: {{ $users->count() }} pengguna</div>
                </div>
            </div>

            <div class="sm:hidden">
                <div class="divide-y divide-soft-gray/50">
                    @forelse($users as $user)
                    <div class="p-4 hover:bg-bg-app/30 transition-colors duration-150">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-3 overflow-hidden border border-soft-gray">
                                @if($user->foto_profil)
                                    <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-primary mb-0.5">{{ $user->nama_lengkap }}</p>
                                <p class="text-xs text-secondary">{{ $user->username }}</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-2 py-0.5 text-xs rounded-full font-semibold mb-1 
                                    {{ $user->role->nama_peran == 'Admin' ? 'bg-purple-100 text-purple-800' : 
                                     ($user->role->nama_peran == 'Operator' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $user->role->nama_peran }}
                                </span>
                                @if($user->status_aktif)
                                    <span class="flex items-center text-xs text-green-600 font-medium"><div class="w-2 h-2 rounded-full bg-green-500 mr-1"></div>Aktif</span>
                                @else
                                    <span class="flex items-center text-xs text-red-600 font-medium"><div class="w-2 h-2 rounded-full bg-red-500 mr-1"></div>Non-Aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 pl-13">
                            <div class="flex items-center text-sm text-text-main mb-1">
                                <svg class="w-4 h-4 mr-2 text-text-main/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                {{ $user->unitKerja->nama_unit ?? 'Tidak ada unit kerja' }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-soft-gray/50">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 transition-colors duration-200" title="Edit Pengguna">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors duration-200" title="Hapus Pengguna">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-xs font-medium text-primary hover:text-secondary transition-colors">Edit →</a>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-bg-app flex items-center justify-center">
                            <svg class="w-7 h-7 text-text-main/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 5.197V21m0 0h-6m6 0v-1a6 6 0 00-9-5.197M9 9a4 4 0 118 0"/></svg>
                        </div>
                        <p class="text-base font-medium text-text-main/60 mb-1">Belum ada pengguna</p>
                        <p class="text-sm text-text-main/40">Mulai dengan menambahkan pengguna pertama</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="hidden sm:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-bg-app">
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Nama / Username</th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Role</th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Unit Kerja</th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Status</th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-soft-gray">
                            @forelse($users as $user)
                            <tr class="hover:bg-bg-app/50 transition-colors duration-150">
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-3xl bg-primary/10 flex items-center justify-center mr-2 sm:mr-3 overflow-hidden border border-soft-gray">
                                            @if($user->foto_profil)
                                                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="Foto" class="w-full h-full object-cover rounded-3xl">
                                            @else
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-primary truncate">{{ $user->nama_lengkap }}</p>
                                            <p class="text-xs text-secondary truncate mt-0.5">{{ $user->username }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-medium {{ $user->role->nama_peran == 'Admin' ? 'bg-purple-100 text-purple-800' : ($user->role->nama_peran == 'Operator' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $user->role->nama_peran }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center text-sm text-text-main">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 text-text-main/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        {{ $user->unitKerja->nama_unit ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    @if($user->status_aktif)
                                        <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div><span class="text-sm font-medium text-green-600">Aktif</span></div>
                                    @else
                                        <div class="flex items-center"><div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div><span class="text-sm font-medium text-red-600">Non-Aktif</span></div>
                                    @endif
                                </td>
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-1.5 sm:p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 transition-colors duration-200" title="Edit Pengguna">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 sm:p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors duration-200" title="Hapus Pengguna">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-bg-app flex items-center justify-center mb-4"><svg class="w-8 h-8 text-text-main/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 5.197V21m0 0h-6m6 0v-1a6 6 0 00-9-5.197M9 9a4 4 0 118 0"/></svg></div>
                                        <p class="text-lg font-medium text-text-main/60 mb-1">Belum ada pengguna</p>
                                        <p class="text-sm text-text-main/40">Mulai dengan menambahkan pengguna pertama</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($users->count() > 0)
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-soft-gray bg-bg-app">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-0">
                    <div class="text-xs text-secondary/60">* Klik ikon edit atau hapus untuk mengelola pengguna</div>
                    <div class="text-xs text-primary/80 font-medium">Total: {{ $users->count() }} pengguna</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* STYLE TIDAK BERUBAH - SAMA SEPERTI KODEMU */
    :root { --accent: #FFD600; --primary: #0F9D58; --secondary: #34A853; --bg-app: #F5F7FA; --white: #FFFFFF; --text-main: #000000; --soft-gray: #E5E7EB; }
    .bg-primary { background-color: #0F9D58 !important; }
    .text-primary { color: #000000 !important; }
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    .focus\:ring-primary\/20:focus { --tw-ring-color: rgba(15, 157, 88, 0.2) !important; }
    .focus\:ring-primary\/50:focus { --tw-ring-color: rgba(15, 157, 88, 0.5) !important; }
    .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
    @media (max-width: 640px) { .pl-13 { padding-left: 3.25rem; } }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection