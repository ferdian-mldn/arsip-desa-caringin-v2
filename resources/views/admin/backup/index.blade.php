@extends('layouts.app')

@section('title', 'Pusat Backup Data')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Pusat Backup Arsip</h1>
            <p class="text-sm sm:text-base text-secondary/80 font-medium">Kelola cadangan data arsip dokumen untuk keamanan dan pemulihan</p>
        </div>

        <!-- Success & Error Alerts -->
        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm sm:text-base text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm sm:text-base text-red-700 font-medium">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif

        <!-- Backup Arsip Dokumen Card (Full Width) -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <!-- Card Header -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <h3 class="text-lg sm:text-xl font-semibold text-white">Backup Arsip Dokumen</h3>
                    </div>
                    <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/15 text-white/90">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Format .ZIP
                    </span>
                </div>
            </div>

            <!-- Card Content -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <!-- Left: Description -->
                    <div>
                        <p class="text-sm text-text-main/80 mb-4 leading-relaxed">
                            Unduh seluruh file dokumen fisik (PDF/Gambar) dalam format <span class="font-semibold text-primary">.ZIP</span>. 
                            Sistem akan menampilkan daftar file terlebih dahulu sebelum mengunduh agar Anda dapat memastikan kelengkapan data.
                        </p>
                        <div class="flex items-start text-xs text-secondary/70 bg-bg-app p-3 rounded-lg">
                            <svg class="w-4 h-4 mr-2 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>File akan dikompresi dalam format ZIP untuk menghemat ruang penyimpanan. Pastikan perangkat Anda memiliki ruang penyimpanan yang cukup.</span>
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div>
                        <form id="formBackupArsip" action="{{ route('admin.backup.arsip') }}" method="POST" target="_blank">
                            @csrf
                            
                            <label class="block text-sm font-semibold text-primary mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Pilih Tahun Arsip
                                </span>
                            </label>
                            
                            <div class="relative mb-4">
                                <select name="tahun" 
                                        id="pilihTahun" 
                                        class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200 cursor-pointer">
                                    @foreach($tahunTersedia as $t)
                                        <option value="{{ $t }}">{{ $t }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-primary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <button type="button" 
                                    onclick="cekFile()" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                Cek & Download
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-soft-gray bg-bg-app">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="text-xs text-secondary/60 flex items-center">
                        <svg class="w-3 h-3 mr-2 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Backup mencakup semua file dokumen fisik yang tersimpan di server
                    </div>
                    <div class="text-xs text-primary/50 font-medium">
                        {{ count($tahunTersedia) }} tahun arsip tersedia
                    </div>
                </div>
            </div>
        </div>

        <!-- Panduan Section -->
        <div class="mt-6 bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-gradient-to-r from-primary/10 to-secondary/10">
                <h3 class="text-lg font-semibold text-primary flex items-center">
                    <svg class="w-5 h-5 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Panduan Backup Arsip
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-primary mb-1">Jadwal Backup Rutin</p>
                            <p class="text-xs text-secondary/70">Lakukan backup arsip dokumen minimal setiap bulan untuk menjaga keamanan data</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-primary mb-1">Penyimpanan Eksternal</p>
                            <p class="text-xs text-secondary/70">Simpan backup di flashdisk, hard drive, atau Google Drive yang terpisah dari komputer</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-primary mb-1">Keamanan Data</p>
                            <p class="text-xs text-secondary/70">Simpan file backup di tempat yang aman dan jangan bagikan ke pihak yang tidak berwenang</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div id="fileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <!-- Background Overlay -->
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-xl sm:rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <!-- Modal Header -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-white" id="modalTitle">
                            Memindai Dokumen...
                        </h3>
                    </div>
                    <button onclick="closeModal()" class="text-white/80 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6">
                <div class="mb-4">
                    <p class="text-sm text-text-main/70 mb-3">Berikut adalah file yang akan dimasukkan ke dalam ZIP:</p>
                    
                    <div class="border border-soft-gray rounded-xl bg-bg-app/50 h-64 overflow-y-auto p-3">
                        <ul id="fileListContainer" class="text-sm text-text-main divide-y divide-soft-gray/50">
                            <li class="py-4 text-center text-text-main/50">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 mb-2 animate-spin text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Sedang memindai server...
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <p class="text-xs text-right text-secondary/60 mt-2" id="totalFilesInfo"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-4 sm:px-6 py-4 bg-bg-app border-t border-soft-gray rounded-b-xl">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" 
                            onclick="confirmDownload()" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download ZIP Sekarang
                    </button>
                    <button type="button" 
                            onclick="closeModal()" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-primary font-semibold rounded-xl shadow-sm border border-soft-gray hover:bg-bg-app transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary/30">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cekFile() {
        const tahun = document.getElementById('pilihTahun').value;
        const listContainer = document.getElementById('fileListContainer');
        const modal = document.getElementById('fileModal');
        const title = document.getElementById('modalTitle');
        const info = document.getElementById('totalFilesInfo');

        // Tampilkan Modal
        modal.classList.remove('hidden');
        title.innerText = "Mengecek Dokumen Tahun " + tahun + "...";
        listContainer.innerHTML = `
            <li class="py-4 text-center text-text-main/50">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-8 h-8 mb-2 animate-spin text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Sedang memindai server...
                </div>
            </li>
        `;
        info.innerText = "";

        // Kirim Request AJAX
        fetch('{{ route("admin.backup.check") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ tahun: tahun })
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                title.innerText = "Siap Mengunduh Arsip Tahun " + tahun;
                let html = '';
                
                if (data.files.length === 0) {
                    html = `
                        <li class="py-8 text-center">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-bg-app flex items-center justify-center">
                                <svg class="w-6 h-6 text-text-main/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="text-sm text-text-main/60 font-medium">Tidak ada dokumen</p>
                            <p class="text-xs text-text-main/40 mt-1">Tidak ditemukan dokumen untuk tahun ${tahun}</p>
                        </li>
                    `;
                } else {
                    data.files.forEach(file => {
                        html += `
                            <li class="py-3 px-2 hover:bg-white rounded-lg transition-colors duration-150">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center truncate">
                                        <svg class="w-4 h-4 mr-2 text-primary/60 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-xs font-medium text-text-main truncate" title="${file.name}">${file.name}</span>
                                    </div>
                                    <span class="text-xs font-semibold text-secondary bg-primary/5 px-2 py-1 rounded">${file.size}</span>
                                </div>
                            </li>
                        `;
                    });
                }
                
                listContainer.innerHTML = html;
                info.innerText = data.files.length > 0 ? `Total: ${data.count} dokumen ditemukan` : "Tidak ada dokumen";
            } else {
                title.innerText = "Perhatian";
                listContainer.innerHTML = `
                    <li class="py-8 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-red-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-red-600 font-medium">${data.message}</p>
                    </li>
                `;
                info.innerText = "";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            title.innerText = "Kesalahan Koneksi";
            listContainer.innerHTML = `
                <li class="py-8 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-red-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-red-600 font-medium">Terjadi kesalahan koneksi server</p>
                    <p class="text-xs text-text-main/40 mt-1">Silakan coba lagi beberapa saat</p>
                </li>
            `;
            info.innerText = "";
        });
    }

    function closeModal() {
        document.getElementById('fileModal').classList.add('hidden');
    }

    function confirmDownload() {
        document.getElementById('formBackupArsip').submit();
        closeModal();
    }
</script>

<style>
    /* Custom Colors - Same as reference */
    :root { --accent: #FFD600;
        --primary: #0F9D58;
        --secondary: #34A853;
        --bg-app: #F5F7FA;
        --white: #FFFFFF;
        --text-main: #000000;
        --soft-gray: #E5E7EB;
    }

    .bg-primary { 
        background-color: #0F9D58 !important; 
    }
    .text-primary { 
        color: #000000 !important; 
    }
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    
    /* Focus rings */
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
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection