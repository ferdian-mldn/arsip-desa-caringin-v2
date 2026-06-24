@extends('layouts.app')

@section('title', 'Riwayat Cetak Surat')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Riwayat Cetak Surat</h1>
                    <p class="text-sm sm:text-base text-secondary/80 font-medium">Log semua dokumen surat yang telah di-generate</p>
                </div>
                <a href="{{ route('autofield.index') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Cetak Surat Baru
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">No</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">Jenis Surat</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">Nama Warga</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">NIK</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">No. Surat</th>
                            <th class="px-4 sm:px-6 py-4 text-xs font-semibold uppercase tracking-wider">Dicetak Oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-soft-gray">
                        @forelse($riwayat as $index => $r)
                        <tr class="hover:bg-bg-app/50 transition-colors">
                            <td class="px-4 sm:px-6 py-4 text-sm text-text-main">{{ $riwayat->firstItem() + $index }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-text-main">
                                <div>{{ $r->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-secondary/60">{{ $r->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-primary/10 text-primary">
                                    {{ $r->template->nama_template ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm font-medium text-primary">{{ $r->warga->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-text-main font-mono">{{ $r->warga->nik ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-text-main">{{ $r->nomor_surat ?? '-' }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-text-main">{{ $r->user->nama_lengkap ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-secondary/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-sm text-secondary/60 font-medium">Belum ada riwayat cetak surat</p>
                                    <p class="text-xs text-secondary/40 mt-1">Mulai cetak surat pertama Anda</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($riwayat->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-soft-gray bg-bg-app">
                {{ $riwayat->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    :root { --accent: #FFD600;
        --primary: #0F9D58;
        --secondary: #34A853;
        --bg-app: #F5F7FA;
        --text-main: #000000;
        --soft-gray: #E5E7EB;
    }
    .bg-primary { background-color: #0F9D58 !important; }
    .text-primary { color: #000000 !important; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection
