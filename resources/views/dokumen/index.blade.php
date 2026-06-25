@extends('layouts.app')

@section('title', 'Data Arsip Dokumen')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                <div class="w-full">
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Arsip Dokumen Desa</h1>
                    <p class="text-sm sm:text-base text-secondary/80 font-medium">Kelola dan telusuri seluruh dokumen arsip desa</p>
                </div>
                
                @if(Auth::user()->role->nama_peran !== 'Viewer')
                <a href="{{ route('dokumen.create') }}" 
                   class="w-full md:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="text-sm sm:text-base">Unggah Dokumen</span>
                </a>
                @endif
            </div>

            <!-- Success Alert -->
            @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-r-lg p-3 sm:p-4 shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm sm:text-base text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray mb-6 sm:mb-8 overflow-hidden">
            <div class="p-4 sm:p-6">
                <div class="flex items-center mb-3 sm:mb-4">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <h3 class="text-base sm:text-lg font-semibold text-primary">Filter Dokumen</h3>
                </div>
                
                <form action="{{ route('dokumen.index') }}" method="GET" class="space-y-3 sm:space-y-0 sm:grid sm:grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs sm:text-sm font-medium text-text-main/70">Cari Dokumen</label>
                        <input type="text" 
                               name="cari" 
                               value="{{ request('cari') }}" 
                               placeholder="Judul, nomor, atau kata kunci..." 
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm bg-bg-app border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                    </div>
                    
                    <div class="space-y-1.5">
                        <label class="block text-xs sm:text-sm font-medium text-text-main/70">Kategori</label>
                        <select name="kategori" 
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm bg-bg-app border border-soft-gray rounded-lg sm:rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end pt-2 sm:pt-0">
                        <button type="submit" 
                                class="w-full sm:w-auto px-4 sm:px-6 py-2.5 sm:py-3 bg-primary text-white text-sm sm:text-base font-semibold rounded-lg sm:rounded-xl hover:bg-secondary hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Status Retensi Warning -->
            @if(request('status_retensi'))
            <div class="border-t border-soft-gray">
                <div class="p-3 sm:p-4 bg-gradient-to-r from-yellow-50 to-amber-50">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                        <div class="flex items-center">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-yellow-100 flex items-center justify-center mr-2 sm:mr-3">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm font-medium text-yellow-800">Filter Status Aktif</p>
                                <p class="text-xs sm:text-sm text-yellow-700">
                                    Status: <strong class="font-semibold">{{ request('status_retensi') }}</strong>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dokumen.index') }}" 
                           class="text-xs sm:text-sm font-semibold text-yellow-700 hover:text-yellow-800 underline decoration-yellow-300 hover:decoration-yellow-500 transition-colors self-start sm:self-center">
                            Reset Filter
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Documents Table Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <!-- Table Header -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 bg-primary">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-base sm:text-lg font-semibold text-white">Daftar Dokumen</h3>
                    </div>
                    <div class="text-xs sm:text-sm text-white/90 font-medium">
                        {{ $dokumen->total() }} dokumen ditemukan
                    </div>
                </div>
            </div>

            <!-- Mobile View (Cards) -->
            <div class="sm:hidden">
                <div class="divide-y divide-soft-gray/50">
                    @forelse($dokumen as $dok)
                    <div class="p-3 hover:bg-bg-app/50 transition-colors duration-150">
                        <!-- Document Header -->
                        <div class="flex items-start gap-3 mb-2">
                            <div class="shrink-0 w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('dokumen.show', $dok->id) }}" 
                                   class="text-sm font-semibold text-primary hover:text-secondary line-clamp-2 block transition-colors"
                                   title="{{ $dok->judul_dokumen }}">
                                    {{ $dok->judul_dokumen }}
                                </a>
                                <p class="text-xs text-secondary mt-1">{{ $dok->nomor_dokumen }}</p>
                            </div>
                        </div>

                        <!-- Document Details -->
                        <div class="grid grid-cols-2 gap-2 mb-3 ml-13">
                            <!-- Kategori -->
                            <div class="space-y-1">
                                <p class="text-xs text-text-main/60">Kategori</p>
                                @php
                                    $hash = md5($dok->kategori->nama_kategori);
                                    $hue = hexdec(substr($hash, 0, 4)) % 360;
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hue }}, 85%, 85%); color: #000000;">
                                    {{ $dok->kategori->nama_kategori }}
                                </span>
                            </div>
                            
                            <!-- Tahun -->
                            <div class="space-y-1">
                                <p class="text-xs text-text-main/60">Tahun</p>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-text-main/50 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs font-medium text-text-main">{{ $dok->tahun_dokumen }}</p>
                                </div>
                            </div>
                            
                            <!-- Unit Kerja -->
                            <div class="space-y-1 col-span-2">
                                <p class="text-xs text-text-main/60">Unit Kerja</p>
                                @php
                                    $nama_unit = $dok->unitKerja->nama_unit ?? 'Admin';
                                    $hashUnit = md5($nama_unit);
                                    $hueUnit = hexdec(substr($hashUnit, 0, 4)) % 360;
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hueUnit }}, 85%, 85%); color: #000000;">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="truncate">{{ $nama_unit }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-2 border-t border-soft-gray/50 mt-3">
                            <div class="flex items-center gap-3">
                                <!-- View -->
                                <a href="{{ route('dokumen.show', $dok->id) }}" 
                                   class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit (Conditional) -->
                                @php
                                    $canEditDelete = Auth::user()->role->nama_peran === 'Admin' || Auth::id() == $dok->id_pengunggah || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dok->id_unit_kerja);
                                @endphp
                                @if($canEditDelete)
                                <a href="{{ route('dokumen.edit', $dok->id) }}" 
                                   class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 transition-colors duration-200"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </a>
                                @endif

                                <!-- Delete (Conditional) -->
                                @if($canEditDelete)
                                <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors duration-200"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                            
                            <!-- Quick View Button -->
                            <a href="{{ route('dokumen.show', $dok->id) }}" 
                               class="text-xs font-medium text-primary hover:text-secondary transition-colors px-2 py-1">
                                Detail →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-bg-app flex items-center justify-center">
                            <svg class="w-7 h-7 text-text-main/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-base font-medium text-text-main/60 mb-1">Belum ada dokumen</p>
                        <p class="text-sm text-text-main/40">Mulai dengan mengunggah dokumen pertama Anda</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Desktop View (Table) -->
            <div class="hidden sm:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-bg-app">
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                    Judul Dokumen
                                </th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                    Kategori
                                </th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                    Unit Kerja
                                </th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                    Tahun
                                </th>
                                <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-soft-gray">
                            @forelse($dokumen as $dok)
                            <tr class="hover:bg-bg-app/50 transition-colors duration-150">
                                <!-- Document Info -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-primary/10 flex items-center justify-center mr-2 sm:mr-3">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('dokumen.show', $dok->id) }}" 
                                               class="text-sm font-semibold text-primary hover:text-secondary truncate block transition-colors"
                                               title="{{ $dok->judul_dokumen }}">
                                                {{ $dok->judul_dokumen }}
                                            </a>
                                            <p class="text-xs text-secondary truncate mt-0.5">
                                                {{ $dok->nomor_dokumen }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    @php
                                        $hash = md5($dok->kategori->nama_kategori);
                                        $hue = hexdec(substr($hash, 0, 4)) % 360;
                                    @endphp
                                    <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hue }}, 85%, 85%); color: #000000;">
                                        {{ $dok->kategori->nama_kategori }}
                                    </span>
                                </td>

                                <!-- Unit Kerja -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    @php
                                        $nama_unit = $dok->unitKerja->nama_unit ?? 'Admin';
                                        $hashUnit = md5($nama_unit);
                                        $hueUnit = hexdec(substr($hashUnit, 0, 4)) % 360;
                                    @endphp
                                    <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hueUnit }}, 85%, 85%); color: #000000;">
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        {{ $nama_unit }}
                                    </span>
                                </td>

                                <!-- Tahun -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center text-sm font-medium text-text-main">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 text-text-main/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $dok->tahun_dokumen }}
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 sm:px-6 py-3 sm:py-4">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <!-- View -->
                                        <a href="{{ route('dokumen.show', $dok->id) }}" 
                                           class="p-1.5 sm:p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200"
                                           title="Lihat Detail">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        <!-- Edit (Conditional) -->
                                        @php
                                            $canEditDeleteDesktop = Auth::user()->role->nama_peran === 'Admin' || Auth::id() == $dok->id_pengunggah || (Auth::user()->role->nama_peran === 'Operator' && Auth::user()->id_unit_kerja == $dok->id_unit_kerja);
                                        @endphp
                                        @if($canEditDeleteDesktop)
                                        <a href="{{ route('dokumen.edit', $dok->id) }}" 
                                           class="p-1.5 sm:p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 transition-colors duration-200"
                                           title="Edit">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        @endif

                                        <!-- Delete (Conditional) -->
                                        @if($canEditDeleteDesktop)
                                        <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 sm:p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors duration-200"
                                                    title="Hapus">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
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
                                        <div class="w-16 h-16 rounded-full bg-bg-app flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-text-main/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-lg font-medium text-text-main/60 mb-1">Belum ada dokumen</p>
                                        <p class="text-sm text-text-main/40">Mulai dengan mengunggah dokumen pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($dokumen->hasPages())
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-soft-gray bg-bg-app">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0">
                    <div class="text-xs sm:text-sm text-primary/80 font-medium">
                        Menampilkan {{ $dokumen->firstItem() ?? 0 }} - {{ $dokumen->lastItem() ?? 0 }} dari {{ $dokumen->total() }} dokumen
                    </div>
                    <div class="flex flex-wrap justify-center sm:justify-end gap-1 sm:gap-2">
                        {{ $dokumen->withQueryString()->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom Colors */
    :root {
        --accent: #FFD600;
        --primary: #0F9D58;
        --secondary: #34A853;
        --bg-app: #F5F7FA;
        --white: #FFFFFF;
        --text-main: #000000;
        --soft-gray: #E5E7EB;
    }

    .bg-primary { background-color: #0F9D58 !important; }
    .text-primary { color: #0F9D58 !important; }
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }

    /* Focus ring */
    .focus\:ring-primary\/50:focus {
        --tw-ring-color: rgba(15, 157, 88, 0.5) !important;
    }

    /* Line clamp utility */
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
    }

    /* Mobile optimization */
    @media (max-width: 640px) {
        .ml-13 {
            margin-left: 3.25rem;
        }
    }
</style>
@endsection