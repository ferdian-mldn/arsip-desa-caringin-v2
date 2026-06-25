@extends('layouts.app')

@section('title', 'Detail Dokumen')

@section('content')
<div class="min-h-screen bg-bg-app py-6">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-secondary hover:text-primary transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-secondary/40" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('dokumen.index') }}" class="ml-1 text-sm font-medium text-secondary hover:text-primary transition-colors md:ml-2">Arsip Dokumen</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-secondary/40" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-primary md:ml-2">Detail Dokumen</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-lg p-4 shadow-sm" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Main Document Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-soft-gray overflow-hidden mb-8">
            <!-- Document Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-secondary/5 border-b border-soft-gray">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary uppercase tracking-wide">
                            {{ $dokumen->kategori->nama_kategori }}
                        </span>
                        <h1 class="text-2xl md:text-3xl font-bold text-primary mt-3">{{ $dokumen->judul_dokumen }}</h1>
                        <p class="text-secondary/80 font-medium mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Nomor: <strong class="ml-1">{{ $dokumen->nomor_dokumen }}</strong>
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full 
                            {{ $dokumen->status_retensi == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <div class="w-2 h-2 rounded-full {{ $dokumen->status_retensi == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} mr-1.5"></div>
                            {{ $dokumen->status_retensi }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="md:flex">
                <!-- Main Content -->
                <div class="p-6 md:w-2/3 border-r border-soft-gray">
                    <!-- Description Section -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-primary">Deskripsi Dokumen</h3>
                        </div>
                        <div class="bg-bg-app rounded-xl p-5 border border-soft-gray">
                            <p class="text-text-main leading-relaxed text-justify">
                                {{ $dokumen->deskripsi ?? 'Tidak ada deskripsi yang tersedia untuk dokumen ini.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('dokumen.download', $dokumen->id) }}" 
                           class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download Arsip
                        </a>

                        @php
                            $canEditDelete = Auth::user()->role->nama_peran === 'Admin' || Auth::id() == $dokumen->id_pengunggah || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dokumen->id_unit_kerja);
                        @endphp
                        @if($canEditDelete)
                        <a href="{{ route('dokumen.edit', $dokumen->id) }}" 
                           class="inline-flex items-center px-6 py-3 border border-soft-gray text-text-main font-semibold rounded-xl hover:bg-bg-app hover:border-primary/30 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-soft-gray">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Dokumen
                        </a>
                        @endif

                        @if($canEditDelete)
                        <form action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-red-50 text-red-600 font-semibold rounded-xl hover:bg-red-100 hover:text-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Metadata Sidebar -->
                <div class="p-6 md:w-1/3 bg-gradient-to-b from-primary/5 to-transparent">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-primary">Metadata Dokumen</h3>
                    </div>

                    <div class="space-y-5">
                        <!-- Unit Kerja -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Unit Kerja</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6">{{ $dokumen->unitKerja->nama_unit ?? 'Administrator' }}</p>
                        </div>

                        <!-- Tahun Dokumen -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Tahun Dokumen</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6">{{ $dokumen->tahun_dokumen }}</p>
                        </div>

                        <!-- Pengunggah -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Diunggah Oleh</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6">{{ $dokumen->pengunggah->nama_lengkap }}</p>
                        </div>

                        <!-- Tanggal Upload -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Tanggal Upload</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6">{{ $dokumen->tanggal_unggah->format('d M Y, H:i') }}</p>
                        </div>

                        <!-- Tipe File -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Tipe File</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6 uppercase">{{ $dokumen->tipe_file }}</p>
                        </div>

                        <!-- Ukuran File -->
                        <div>
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Ukuran File</span>
                            </div>
                            <p class="text-sm font-semibold text-text-main ml-6">{{ $dokumen->ukuran_file }} KB</p>
                        </div>

                        <!-- Status Retensi (Mobile) -->
                        <div class="md:hidden">
                            <div class="flex items-center mb-1.5">
                                <svg class="w-4 h-4 text-secondary/70 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs font-medium text-secondary/70 uppercase tracking-wide">Status Retensi</span>
                            </div>
                            <div class="ml-6">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $dokumen->status_retensi == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <div class="w-2 h-2 rounded-full {{ $dokumen->status_retensi == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} mr-1.5"></div>
                                    {{ $dokumen->status_retensi }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Preview Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-soft-gray overflow-hidden">
            <!-- Preview Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-secondary/5 border-b border-soft-gray">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-primary">Pratinjau Dokumen</h3>
                </div>
            </div>

            <!-- Preview Content -->
            <div class="relative">
                <!-- Loading State -->
                <div id="previewLoading" class="absolute inset-0 bg-bg-app flex items-center justify-center z-10">
                    <div class="text-center">
                        <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin mx-auto mb-3"></div>
                        <p class="text-sm text-secondary">Memuat pratinjau dokumen...</p>
                    </div>
                </div>

                <!-- Iframe Container -->
                <div class="bg-gray-50">
                    <iframe 
                        src="{{ route('dokumen.preview', $dokumen->id) }}" 
                        class="w-full h-[600px] md:h-[700px] border-none" 
                        id="documentPreview"
                        onload="document.getElementById('previewLoading').style.display = 'none';"
                        onerror="showPreviewError()">
                    </iframe>
                </div>

                <!-- Preview Actions -->
                <div class="px-6 py-4 border-t border-soft-gray bg-bg-app">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-secondary/70">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h1m0 0h-1m1 0v4m-5-4h.01M11 12h2"/>
                            </svg>
                            Pratinjau ini hanya untuk melihat dokumen. Untuk edit, download dokumen terlebih dahulu.
                        </div>
                        <a href="{{ route('dokumen.download', $dokumen->id) }}" 
                           class="inline-flex items-center text-sm font-medium text-primary hover:text-secondary transition-colors">
                            Download untuk Edit
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to List Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('dokumen.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-soft-gray text-text-main font-semibold rounded-xl hover:bg-bg-app hover:border-primary/30 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Arsip
            </a>
        </div>
    </div>
</div>

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
    .focus\:ring-primary\/50:focus {
        --tw-ring-color: rgba(15, 157, 88, 0.5) !important;
    }
    
    /* Gradient */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
    
    /* Loading spinner animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>

<script>
    // Function to show preview error
    function showPreviewError() {
        const loadingDiv = document.getElementById('previewLoading');
        if (loadingDiv) {
            loadingDiv.innerHTML = `
                <div class="text-center p-8">
                    <svg class="w-16 h-16 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-600 font-medium mb-1">Gagal memuat pratinjau</p>
                    <p class="text-sm text-red-500">Silakan download dokumen untuk melihat isinya</p>
                </div>
            `;
        }
    }

    // Fallback if iframe fails to load
    document.addEventListener('DOMContentLoaded', function() {
        const previewIframe = document.getElementById('documentPreview');
        const loadingDiv = document.getElementById('previewLoading');
        
        // Hide loading after 10 seconds (fallback)
        setTimeout(() => {
            if (loadingDiv && loadingDiv.style.display !== 'none') {
                loadingDiv.innerHTML = `
                    <div class="text-center p-8">
                        <svg class="w-16 h-16 text-yellow-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-yellow-600 font-medium mb-1">Pratinjau membutuhkan waktu lebih lama</p>
                        <p class="text-sm text-yellow-500">Dokumen sedang diproses, silakan tunggu atau download untuk melihat</p>
                        <button onclick="location.reload()" class="mt-3 text-sm text-primary hover:text-secondary underline">
                            Muat Ulang
                        </button>
                    </div>
                `;
            }
        }, 10000);
    });
</script>
@endsection