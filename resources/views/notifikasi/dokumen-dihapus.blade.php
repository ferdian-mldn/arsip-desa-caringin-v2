@extends('layouts.app')

@section('title', 'Dokumen Tidak Tersedia')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg">

        {{-- Card Utama --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden" style="border: 1px solid var(--border-light);">

            {{-- Header Hijau --}}
            <div class="px-8 py-8 text-center" style="background: linear-gradient(135deg, #0B7A3E 0%, #159550 100%);">
                {{-- Ikon --}}
                <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center"
                     style="background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.3);">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-white mb-1">Dokumen Telah Dihapus</h1>
                <p class="text-green-100 text-sm">Sistem Arsip Desa Caringin</p>
            </div>

            {{-- Konten --}}
            <div class="px-8 py-6">

                {{-- Banner Peringatan --}}
                <div class="flex items-start gap-3 p-4 rounded-xl mb-6"
                     style="background: #FFF8D6; border: 1px solid #E6D060;">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5" style="color: #B88F00;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-sm" style="color: #7A5F00;">Notifikasi Tidak Lagi Berlaku</p>
                        <p class="text-sm mt-1" style="color: #92710A;">
                            Dokumen yang dirujuk notifikasi ini sudah <strong>dihapus dari sistem</strong>
                            oleh Administrator atau petugas yang berwenang.
                        </p>
                    </div>
                </div>

                {{-- Detail Notifikasi --}}
                <div class="space-y-3 mb-6">
                    <div class="flex items-start gap-3 p-3 rounded-xl" style="background: var(--bg-app);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                             style="background: #D4EFDF;">
                            <svg class="w-4 h-4" style="color: #0B7A3E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-wide mb-0.5" style="color: var(--text-muted);">Judul Notifikasi</p>
                            <p class="text-sm font-semibold" style="color: var(--text-dark);">{{ $notif->judul ?? 'Dokumen Baru Diunggah' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl" style="background: var(--bg-app);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
                             style="background: #D4EFDF;">
                            <svg class="w-4 h-4" style="color: #0B7A3E;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3v-3z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold uppercase tracking-wide mb-0.5" style="color: var(--text-muted);">Pesan</p>
                            <p class="text-sm" style="color: var(--text-body);">{{ $notif->pesan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Keterangan --}}
                <p class="text-sm text-center mb-6" style="color: var(--text-muted);">
                    Kunjungi halaman <strong>Arsip Dokumen</strong> untuk melihat daftar dokumen
                    yang masih tersedia di sistem.
                </p>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('dokumen.index') }}"
                       class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-semibold text-sm text-white transition-all duration-200 hover:opacity-90 active:scale-95"
                       style="background: linear-gradient(135deg, #0B7A3E, #159550); box-shadow: 0 2px 8px rgba(11,122,62,0.3);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lihat Arsip Dokumen
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="flex-1 flex items-center justify-center gap-2 px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-200 hover:shadow-md active:scale-95"
                       style="background: white; color: var(--text-dark); border: 1.5px solid var(--border-light);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-8 py-4 flex items-center justify-center gap-2"
                 style="background: var(--bg-app); border-top: 1px solid var(--border-light);">
                <svg class="w-4 h-4 flex-shrink-0" style="color: var(--gov-green);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <p class="text-xs" style="color: var(--text-muted);">
                    Sistem Arsip Desa Caringin &mdash; Data dikelola dengan aman
                </p>
            </div>
        </div>

    </div>
</div>
@endsection

