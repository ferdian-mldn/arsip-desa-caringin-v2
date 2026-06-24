@extends('layouts.app')

@section('title', 'Dashboard - SIPE DESA')

@section('content')
<div class="min-h-screen bg-bg-app">
    <div class="bg-primary text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">Dashboard Ikhtisar</h1>
                    <p class="text-secondary-light">Selamat datang, {{ Auth::user()->nama_lengkap }}! Berikut ringkasan aktivitas sistem arsip.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-soft-gray hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-lg bg-primary/10">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-800">Total</span>
                </div>
                <div class="text-sm font-medium text-text-main/70 mb-1">Total Dokumen Arsip</div>
                <div class="text-3xl font-bold text-primary mb-2">{{ $totalDokumen }}</div>
                <div class="h-1 bg-gradient-to-r from-primary to-secondary rounded-full"></div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-soft-gray hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-lg bg-blue-50">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-800">Bulan Ini</span>
                </div>
                <div class="text-sm font-medium text-text-main/70 mb-1">Dokumen Baru</div>
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $dokumenBulanIni }}</div>
                <div class="h-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"></div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-soft-gray hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-lg bg-purple-50">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 text-purple-800">Kategori</span>
                </div>
                <div class="text-sm font-medium text-text-main/70 mb-1">Jenis Kategori</div>
                <div class="text-3xl font-bold text-purple-700 mb-2">{{ $totalKategori }}</div>
                <div class="h-1 bg-gradient-to-r from-purple-400 to-purple-600 rounded-full"></div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 {{ Auth::user()->role->nama_peran == 'Admin' ? 'border-soft-gold' : 'border-green-500' }} hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-lg {{ Auth::user()->role->nama_peran == 'Admin' ? 'bg-soft-gold/20' : 'bg-green-50' }}">
                        <svg class="w-8 h-8 {{ Auth::user()->role->nama_peran == 'Admin' ? 'text-soft-gold' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ Auth::user()->role->nama_peran == 'Admin' ? 'bg-soft-gold/20 text-soft-gold-dark' : 'bg-green-100 text-green-800' }}">Aktif</span>
                </div>
                <div class="text-sm font-medium text-text-main/70 mb-1">Status Akun</div>
                <div class="text-2xl font-bold {{ Auth::user()->role->nama_peran == 'Admin' ? 'text-soft-gold-dark' : 'text-green-700' }} mb-2">{{ Auth::user()->role->nama_peran }}</div>
                <div class="h-1 {{ Auth::user()->role->nama_peran == 'Admin' ? 'bg-gradient-to-r from-soft-gold to-yellow-500' : 'bg-gradient-to-r from-green-400 to-green-600' }} rounded-full"></div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-soft-gray">
                <div class="px-6 py-4 border-b border-soft-gray bg-primary">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-white">Statistik Arsip per Kategori</h4>
                        <svg class="w-5 h-5 text-white/80" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    @if($totalDokumen > 0)
                        <div class="relative h-64">
                            <canvas id="chartDokumen"></canvas>
                        </div>
                        <div class="mt-4 pt-4 border-t border-soft-gray">
                            <p class="text-sm text-text-main/70 text-center">
    Total dokumen terdistribusi ke <strong>{{ $kategoriTerpakai }}</strong> kategori
</p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-64 bg-bg-app rounded-lg border border-dashed border-soft-gray">
                            <svg class="w-16 h-16 text-text-main/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-text-main/60 text-center max-w-sm">Belum ada data dokumen untuk ditampilkan. Mulai tambahkan dokumen pertama Anda!</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-soft-gray">
                <div class="px-6 py-4 border-b border-soft-gray bg-primary">
                    <div class="flex items-center justify-between">
                        <h4 class="text-lg font-semibold text-white">Dokumen Terbaru Diunggah</h4>
                        <svg class="w-5 h-5 text-white/80" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-bg-app">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Judul Dokumen</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-soft-gray">
                            @forelse($dokumenTerbaru as $dok)
                            <tr class="hover:bg-bg-app/50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-text-main">{{ $dok->judul_dokumen }}</p>
                                            <p class="text-xs text-text-main/60">{{ $dok->nomor_dokumen }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $hash = md5($dok->kategori->nama_kategori);
                                        $hue = hexdec(substr($hash, 0, 4)) % 360;
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border border-soft-gray shadow-sm" style="background-color: hsl({{ $hue }}, 85%, 85%); color: #000000;">
                                        {{ $dok->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm text-text-main">
                                        <svg class="w-4 h-4 mr-1 text-text-main/50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $dok->tanggal_unggah->format('d M Y') }}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-text-main/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-text-main/60">Tidak ada dokumen baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-bg-app border-t border-soft-gray">
                    <a href="{{ route('dokumen.index') }}" class="inline-flex items-center text-sm font-medium text-primary hover:text-primary/80 transition-colors duration-200">
                        Lihat Semua Dokumen
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($totalDokumen > 0)
    <div id="chart-data" 
         data-labels="{{ json_encode($statistikKategori->pluck('nama_kategori')) }}" 
         data-values="{{ json_encode($statistikKategori->pluck('total')) }}"
         class="hidden">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chartDokumen').getContext('2d');
            const dataElement = document.getElementById('chart-data');
            
            const labels = JSON.parse(dataElement.dataset.labels);
            const dataTotal = JSON.parse(dataElement.dataset.values);

            // Generate gradient for chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, '#0F9D58');
            gradient.addColorStop(0.7, '#34A853');
            gradient.addColorStop(1, 'rgba(51, 78, 104, 0.2)');

            // Enhanced chart configuration with Navy Blue theme
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: dataTotal,
                        backgroundColor: gradient,
                        borderColor: '#0F9D58',
                        borderWidth: 2,
                        borderRadius: 6,
                        hoverBackgroundColor: '#0F9D58',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0F9D58',
                            titleColor: '#FFFFFF',
                            bodyColor: '#F5F7FA',
                            borderColor: '#0F9D58',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return `Dokumen: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(229, 231, 235, 0.5)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#34A853',
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#34A853',
                                font: {
                                    weight: '500'
                                },
                                maxRotation: 45
                            }
                        }
                    }
                }
            });
        });
    </script>
@endif

<script>
    // Format tanggal untuk input type="date" di mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Cek jika menggunakan mobile
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }
        
        // Format tanggal untuk input date
        function formatDateForInput(date) {
            return date.toISOString().split('T')[0];
        }
        
        // Set default tanggal untuk form di halaman lain jika diperlukan
        if (isMobileDevice()) {
            console.log('Mobile device detected - adjusting date formats');
        }
    });
</script>

<style>
    :root { --accent: #FFD600;
        --primary: #0F9D58;
        --secondary: #34A853;
        --bg-app: #F5F7FA;
        --white: #FFFFFF;
        --text-main: #000000;
        --soft-gray: #E5E7EB;
        --soft-gold: #C9A24D;
        --soft-gold-dark: #B08C3A;
    }

    .bg-primary { 
        background-color: #0F9D58 !important; 
    }
    .text-primary { 
        color: #000000 !important; 
    }
    
    .bg-secondary { background-color: var(--secondary); }
    .bg-bg-app { background-color: var(--bg-app); }
    .bg-white { background-color: var(--white); }
    .bg-soft-gray { background-color: var(--soft-gray); }
    
    .text-secondary { color: #000000; }
    .text-bg-app { color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .text-soft-gold { color: var(--soft-gold); }
    .text-soft-gold-dark { color: var(--soft-gold-dark); }
    
    .border-soft-gray { border-color: var(--soft-gray); }
    .border-primary { border-color: var(--primary); }
    .border-soft-gold { border-color: var(--soft-gold); }
    
    .bg-primary-light { background-color: rgba(15, 157, 88, 0.1); }
    
    .secondary-light { color: rgba(51, 78, 104, 0.8); }
    
    /* Styling untuk input date di mobile */
    input[type="date"] {
        min-height: 44px; /* Ukuran touch-friendly */
    }
    
    /* Pastikan warna header menggunakan #0F9D58 */
    .bg-gradient-to-r.from-primary {
        background: #0F9D58 !important;
    }
    
    .bg-gradient-to-r.from-primary.to-secondary {
        background: linear-gradient(to right, #0F9D58, #34A853) !important;
    }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection