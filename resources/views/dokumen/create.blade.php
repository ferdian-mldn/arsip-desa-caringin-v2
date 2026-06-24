@extends('layouts.app')

@section('title', 'Upload Dokumen Baru')

@section('content')
<div class="min-h-screen bg-bg-app py-6">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center shadow-lg border border-primary/20">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-primary mb-2">Form Pengarsipan Dokumen</h1>
                <p class="text-lg text-secondary/80 font-medium">Unggah dan arsipkan dokumen desa dengan metadata lengkap</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl border border-soft-gray overflow-hidden">
            <!-- Form Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-secondary/5 border-b border-soft-gray">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div>
                        <h2 class="text-lg font-semibold text-primary">Detail Dokumen</h2>
                        <p class="text-sm text-secondary/70 mt-0.5">Isi semua kolom yang diperlukan (<span class="text-red-500">*</span>) dengan informasi yang akurat</p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mx-6 mt-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-red-700 font-semibold mb-2">Perhatikan kesalahan berikut:</p>
                        <ul class="list-disc pl-5 text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form Content -->
            <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Basic Information Grid -->
                <div class="space-y-6">
                    <!-- Judul Dokumen -->
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Judul Dokumen <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" 
                               name="judul_dokumen" 
                               value="{{ old('judul_dokumen') }}" 
                               class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 placeholder:text-text-main/40"
                               placeholder="Contoh: Surat Keputusan Kepala Desa tentang Penetapan Anggaran..." 
                               required>
                        <p class="text-xs text-secondary/70 mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m-5-4h.01M11 12h2"/>
                            </svg>
                            Gunakan judul yang deskriptif dan mudah dipahami
                        </p>
                    </div>

                    <!-- Nomor & Tahun Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nomor Dokumen -->
                        <div>
                            <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Nomor Dokumen <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" 
                                   name="nomor_dokumen" 
                                   value="{{ old('nomor_dokumen') }}" 
                                   class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 placeholder:text-text-main/40"
                                   placeholder="Contoh: 001/SK/KD/VI/2024" 
                                   required>
                        </div>

                        <!-- Tahun Dokumen -->
                        <div>
                            <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tahun Dokumen <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="tahun_dokumen" 
                                       value="{{ old('tahun_dokumen', date('Y')) }}" 
                                       class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200"
                                       min="2000" 
                                       max="{{ date('Y') + 1 }}" 
                                       required>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori & Unit Kerja Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Kategori <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <select name="id_kategori" 
                                        class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 appearance-none"
                                        required>
                                    <option value="">-- Pilih Kategori Dokumen --</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Kerja (Admin only) -->
                        @if(Auth::user()->role->nama_peran === 'Admin')
                        <div>
                            <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Unit Kerja Pemilik
                            </label>
                            <div class="relative">
                                <select name="id_unit_kerja" 
                                        class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 appearance-none">
                                    <option value="">-- Pilih Unit Kerja (Opsional) --</option>
                                    @foreach($unitKerja as $u)
                                        <option value="{{ $u->id }}" {{ old('id_unit_kerja') == $u->id ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs text-secondary/70 mt-1.5 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m-5-4h.01M11 12h2"/>
                                </svg>
                                Kosongkan jika dokumen bersifat umum untuk seluruh desa
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- File Upload Section -->
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            File Dokumen <span class="text-red-500 ml-1">*</span>
                            <span class="text-xs font-normal text-secondary/70 ml-2">(PDF, DOC, DOCX, XLS, XLSX, JPG, PNG - Maks 10MB)</span>
                        </label>
                        
                        <div class="relative">
                            <input type="file" 
                                   name="file_dokumen" 
                                   id="fileInput"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   required 
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            
                            <div id="dropZone" class="border-2 border-dashed border-soft-gray rounded-2xl p-8 text-center hover:border-primary hover:bg-primary/5 transition-all duration-200 group">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-xl bg-gradient-to-br from-primary/10 to-secondary/10 flex items-center justify-center group-hover:scale-105 transition-transform duration-200 border border-primary/20">
                                        <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-text-main mb-1">Klik atau drag file ke sini</p>
                                    <p class="text-xs text-secondary/70">Unggah file dokumen yang akan diarsipkan</p>
                                    <div id="fileName" class="mt-4 text-sm text-primary font-medium hidden">
                                        <svg class="w-5 h-5 inline mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span id="fileText"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label class="block text-sm font-semibold text-primary mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            Deskripsi / Ringkasan Isi
                            <span class="text-xs font-normal text-secondary/70 ml-2">(Opsional)</span>
                        </label>
                        <textarea name="deskripsi" 
                                  rows="4" 
                                  class="w-full px-4 py-3 bg-bg-app border border-soft-gray rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all duration-200 placeholder:text-text-main/40 resize-none"
                                  placeholder="Jelaskan isi dokumen secara singkat, tujuan, dan informasi penting lainnya...">{{ old('deskripsi') }}</textarea>
                        <p class="text-xs text-secondary/70 mt-1.5 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m-5-4h.01M11 12h2"/>
                            </svg>
                            Deskripsi akan membantu dalam pencarian dan pemahaman dokumen
                        </p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 mt-8 border-t border-soft-gray">
                    <div class="text-sm text-secondary/70 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Data akan disimpan dengan aman di sistem arsip digital
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dokumen.index') }}" 
                           class="px-6 py-3 border border-soft-gray text-text-main font-semibold rounded-xl hover:bg-bg-app hover:border-primary/30 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-soft-gray flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Simpan Arsip
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="max-w-3xl mx-auto mt-6">
            <div class="bg-gradient-to-r from-primary/5 to-secondary/5 rounded-xl p-4 border border-soft-gray">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-primary mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-secondary">
                        <p class="font-semibold text-primary mb-2">Tips Pengisian yang Baik:</p>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Gunakan judul yang jelas dan deskriptif</li>
                            <li>Masukkan nomor dokumen sesuai format resmi</li>
                            <li>Pilih kategori yang paling sesuai dengan isi dokumen</li>
                            <li>Tambahkan deskripsi untuk memudahkan pencarian di kemudian hari</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const dropZone = document.getElementById('dropZone');
        const fileName = document.getElementById('fileName');
        const fileText = document.getElementById('fileText');

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                fileText.textContent = file.name;
                fileName.classList.remove('hidden');
                dropZone.classList.add('border-primary', 'bg-primary/5');
                
                // Add check icon
                const uploadIcon = dropZone.querySelector('svg');
                if (uploadIcon) {
                    uploadIcon.classList.add('text-green-500');
                }
            }
        });

        // Drag and drop functionality
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropZone.classList.add('border-primary', 'bg-primary/10');
        });

        dropZone.addEventListener('dragleave', function(e) {
            if (!dropZone.contains(e.relatedTarget)) {
                dropZone.classList.remove('border-primary', 'bg-primary/10');
            }
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-primary/10');
            
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                const file = e.dataTransfer.files[0];
                fileText.textContent = file.name;
                fileName.classList.remove('hidden');
                dropZone.classList.add('border-green-500', 'bg-green-50');
                
                // Change icon to check
                const uploadIcon = dropZone.querySelector('svg');
                if (uploadIcon) {
                    uploadIcon.classList.remove('text-primary');
                    uploadIcon.classList.add('text-green-500');
                }
                
                // Reset after 3 seconds
                setTimeout(() => {
                    dropZone.classList.remove('border-green-500', 'bg-green-50');
                    if (uploadIcon) {
                        uploadIcon.classList.remove('text-green-500');
                        uploadIcon.classList.add('text-primary');
                    }
                }, 3000);
            }
        });

        // Click drop zone to trigger file input
        dropZone.addEventListener('click', function(e) {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });
    });
</script>

<style>
    /* Custom Colors */
    :root { --accent: #FFD600;
        --primary: #0F9D58;
        --secondary: #34A853;
        --bg-app: #F5F7FA;
        --white: #FFFFFF;
        --text-main: #000000;
        --soft-gray: #E5E7EB;
    }

    .bg-primary { background-color: var(--primary); }
    .text-primary { color: var(--primary); }
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    
    /* Focus ring */
    .focus\:ring-primary\/30:focus {
        --tw-ring-color: rgba(15, 157, 88, 0.3) !important;
    }
    
    .focus\:ring-primary\/50:focus {
        --tw-ring-color: rgba(15, 157, 88, 0.5) !important;
    }
    
    /* Gradient */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection