@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="w-full">
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Tambah Pengguna Baru</h1>
                    <p class="text-sm sm:text-base text-secondary/80 font-medium">Buat akun baru untuk akses sistem arsip</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <a href="{{ route('admin.users.index') }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-primary font-semibold rounded-xl shadow-sm border border-soft-gray hover:bg-bg-app transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span class="text-sm sm:text-base">Kembali</span>
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
            <div class="flex flex-col">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm sm:text-base text-red-700 font-medium">Terjadi kesalahan!</p>
                </div>
                <ul class="list-disc list-inside ml-8 text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
                <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <h3 class="text-lg sm:text-xl font-semibold text-white">Form Tambah Pengguna</h3>
                    </div>
                </div>

                <div class="p-4 sm:p-6">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-primary mb-2">Nama Lengkap <span class="text-red-500 ml-1">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main placeholder-text-main/40 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" placeholder="Masukkan nama lengkap pengguna" required>
                            <p class="text-xs text-secondary/60 mt-1">Nama lengkap sesuai dengan identitas resmi</p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-primary mb-2">
                                Foto Profil
                                <span class="text-secondary/60 font-normal text-xs ml-1">(Opsional)</span>
                            </label>
                            <input type="file" 
                                   name="foto_profil" 
                                   accept="image/*"
                                   class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <p class="text-xs text-secondary/60 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Username <span class="text-red-500 ml-1">*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main placeholder-text-main/40 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" placeholder="contoh: johndoe" required>
                                <p class="text-xs text-secondary/60 mt-1">Untuk login ke sistem</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-primary mb-2">Password <span class="text-red-500 ml-1">*</span></label>
                                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main placeholder-text-main/40 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" placeholder="Minimal 6 karakter" required>
                                <p class="text-xs text-secondary/60 mt-1">Gunakan kombinasi yang kuat</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-primary mb-2">Peran (Role) <span class="text-red-500 ml-1">*</span></label>
                            <div class="relative">
                                <select name="id_role" class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200 cursor-pointer">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('id_role') == $role->id ? 'selected' : '' }}>{{ $role->nama_peran }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <p class="text-xs text-secondary/60 mt-1">Tentukan hak akses pengguna</p>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-primary mb-2">Unit Kerja <span class="text-secondary/60 font-normal text-xs ml-1">(Opsional untuk Admin)</span></label>
                            <div class="relative">
                                <select name="id_unit_kerja" class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200 cursor-pointer">
                                    <option value="">-- Pilih Unit Kerja --</option>
                                    @foreach($unitKerja as $unit)
                                        <option value="{{ $unit->id }}" {{ old('id_unit_kerja') == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <p class="text-xs text-secondary/60 mt-1">Kosongkan jika role adalah Admin</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-soft-gray">
                            <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-primary font-semibold rounded-xl shadow-sm border border-soft-gray hover:bg-bg-app transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/30">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>

                <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-soft-gray bg-bg-app">
                    <div class="text-xs text-secondary/60">
                        <span class="font-semibold text-primary/80">Catatan:</span> Pastikan data yang diisi sudah benar. Pengguna dapat login setelah akun dibuat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* STYLE TIDAK BERUBAH - SAMA SEPERTI YANG KAMU BERIKAN */
    :root { --accent: #FFD600; --primary: #0F9D58; --secondary: #34A853; --bg-app: #F5F7FA; --white: #FFFFFF; --text-main: #000000; --soft-gray: #E5E7EB; }
    .bg-primary { background-color: #0F9D58 !important; }
    .text-primary { color: #000000 !important; }
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    .placeholder-text-main\/40::placeholder { color: rgba(31, 41, 55, 0.4); }
    .focus\:ring-primary\/30:focus { --tw-ring-color: rgba(15, 157, 88, 0.3) !important; }
    .focus\:ring-primary\/50:focus { --tw-ring-color: rgba(15, 157, 88, 0.5) !important; }
    .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.querySelector('select[name="id_role"]');
    const unitKerjaSelect = document.querySelector('select[name="id_unit_kerja"]');
    
    // Simpan semua opsi asli dari PHP
    const originalOptions = Array.from(unitKerjaSelect.options).map(opt => ({
        value: opt.value,
        text: opt.text,
        element: opt.cloneNode(true)
    }));

    function updateDropdown() {
        const selectedRoleText = roleSelect.options[roleSelect.selectedIndex].text.toLowerCase();
        
        // Bersihkan dropdown
        unitKerjaSelect.innerHTML = '';
        
        // Tambahkan opsi default
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = '-- Pilih Unit Kerja --';
        unitKerjaSelect.appendChild(defaultOption);

        const operatorKeywords = ['kaur', 'kasi'];
        const viewerKeywords = ['kepala desa', 'kadus'];

        originalOptions.forEach(opt => {
            if (opt.value === "") return;
            
            const unitName = opt.text.toLowerCase();
            let show = false;
            
            if (selectedRoleText.includes('operator')) {
                if (operatorKeywords.some(kw => unitName.includes(kw))) show = true;
            } else if (selectedRoleText.includes('viewer')) {
                if (viewerKeywords.some(kw => unitName.includes(kw))) show = true;
            } else if (selectedRoleText.includes('admin')) {
                if (unitName.includes('sekretaris desa')) show = true;
            }
            
            if (show) {
                unitKerjaSelect.appendChild(opt.element.cloneNode(true));
            }
        });
        
        // Kembalikan old value jika ada dan masih valid di opsi yang baru
        const oldValue = "{{ old('id_unit_kerja') }}";
        if (oldValue) {
            const exists = Array.from(unitKerjaSelect.options).some(o => o.value === oldValue);
            if (exists) unitKerjaSelect.value = oldValue;
        }
    }
    
    roleSelect.addEventListener('change', updateDropdown);
    updateDropdown(); // panggil saat pertama load
});
</script>
@endsection