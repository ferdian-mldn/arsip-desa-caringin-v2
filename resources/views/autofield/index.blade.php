@extends('layouts.app')

@section('title', 'Cetak Surat Otomatis')

@section('content')
<div class="min-h-screen bg-bg-app py-4 sm:py-6">
    <div class="container mx-auto px-3 sm:px-4">
        <!-- Header Section -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary mb-1">Cetak Surat Otomatis</h1>
                    <p class="text-sm sm:text-base text-secondary/80 font-medium">Generate dokumen surat desa otomatis berdasarkan data warga</p>
                </div>
                <a href="{{ route('autofield.riwayat') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-white border border-soft-gray text-primary font-semibold rounded-xl shadow-sm hover:bg-bg-app transition-all duration-200 text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Riwayat Cetak
                </a>
            </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Panel: Search & Form -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Step 1: Cari Data Warga -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">1</span>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Cari Data Warga</h3>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <label class="block text-sm font-semibold text-primary mb-2">Masukkan NIK atau Nama Warga</label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <input type="text" 
                                       id="inputNIK" 
                                       placeholder="Ketik NIK (16 digit) atau nama warga..." 
                                       class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200"
                                       maxlength="16"
                                       autocomplete="off">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-secondary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <button type="button" 
                                    onclick="cariWarga()" 
                                    id="btnCari"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-semibold rounded-xl shadow-lg hover:bg-secondary transition-all duration-200 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary/50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari
                            </button>
                        </div>

                        <!-- Suggestions -->
                        <div id="suggestionsContainer" class="mt-3 hidden">
                            <p class="text-xs text-amber-600 font-medium mb-2">Mungkin yang Anda maksud:</p>
                            <div id="suggestionsList" class="space-y-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Preview Data Warga (Hidden by default) -->
                <div id="wargaPreview" class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center mr-3">
                                    <span class="text-white font-bold text-sm">2</span>
                                </div>
                                <h3 class="text-lg font-semibold text-white">Data Warga Ditemukan</h3>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-400/20 text-green-200">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">NIK</p>
                                    <p class="text-sm font-semibold text-primary" id="prevNIK">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Nama Lengkap</p>
                                    <p class="text-sm font-semibold text-primary" id="prevNama">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Tempat, Tanggal Lahir</p>
                                    <p class="text-sm text-text-main" id="prevTTL">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Jenis Kelamin</p>
                                    <p class="text-sm text-text-main" id="prevJK">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Agama</p>
                                    <p class="text-sm text-text-main" id="prevAgama">-</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Status Perkawinan</p>
                                    <p class="text-sm text-text-main" id="prevStatus">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Pekerjaan</p>
                                    <p class="text-sm text-text-main" id="prevPekerjaan">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Pendidikan Terakhir</p>
                                    <p class="text-sm text-text-main" id="prevPendidikan">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">Alamat</p>
                                    <p class="text-sm text-text-main" id="prevAlamat">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-secondary/60 font-medium mb-0.5">No. KK</p>
                                    <p class="text-sm text-text-main" id="prevKK">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Pilih Template & Generate -->
                <div id="generateSection" class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 bg-primary">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center mr-3">
                                <span class="text-white font-bold text-sm">3</span>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Pilih Template & Cetak</h3>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <form id="formGenerate" action="{{ route('autofield.generate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_warga" id="inputIdWarga" value="">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                <!-- Pilih Template -->
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Pilih Template Surat
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <select name="id_template" 
                                                id="selectTemplate" 
                                                required
                                                class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main appearance-none focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200 cursor-pointer">
                                            <option value="">-- Pilih Template --</option>
                                            @foreach($templates as $t)
                                                <option value="{{ $t->id }}">{{ $t->nama_template }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-primary">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nomor Surat (Optional) -->
                                <div>
                                    <label class="block text-sm font-semibold text-primary mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            Nomor Surat <span class="text-secondary/50 font-normal">(opsional)</span>
                                        </span>
                                    </label>
                                    <input type="text" 
                                           name="nomor_surat" 
                                           placeholder="Contoh: 001/DS-CRG/VI/2026" 
                                           class="w-full px-4 py-3 rounded-xl border border-soft-gray bg-white text-text-main focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200">
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-6 py-3.5 bg-primary text-white font-semibold rounded-xl shadow-lg transition-all duration-200 focus:outline-none"
                                    style="background-color: #0F9D58;">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Generate & Download Dokumen
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Info & Panduan -->
            <div class="space-y-6">
                <!-- Panduan Penggunaan -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 bg-gradient-to-r from-primary/10 to-secondary/10">
                        <h3 class="text-base font-semibold text-primary flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Cara Penggunaan
                        </h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold mr-3 mt-0.5">1</div>
                                <div>
                                    <p class="text-sm font-semibold text-primary">Cari Data Warga</p>
                                    <p class="text-xs text-secondary/70 mt-0.5">Masukkan NIK (16 digit) atau nama warga yang ingin dibuatkan surat</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold mr-3 mt-0.5">2</div>
                                <div>
                                    <p class="text-sm font-semibold text-primary">Verifikasi Data</p>
                                    <p class="text-xs text-secondary/70 mt-0.5">Pastikan data warga yang ditampilkan sudah benar sebelum melanjutkan</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold mr-3 mt-0.5">3</div>
                                <div>
                                    <p class="text-sm font-semibold text-primary">Pilih Template & Cetak</p>
                                    <p class="text-xs text-secondary/70 mt-0.5">Pilih jenis surat, isi nomor surat jika perlu, lalu klik Generate & Download</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Tersedia -->
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-soft-gray overflow-hidden">
                    <div class="px-4 sm:px-6 py-4 sm:py-5 bg-gradient-to-r from-primary/10 to-secondary/10">
                        <h3 class="text-base font-semibold text-primary flex items-center">
                            <svg class="w-5 h-5 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Template Tersedia
                        </h3>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="space-y-3">
                            @forelse($templates as $t)
                            <div class="flex items-center p-3 rounded-lg bg-bg-app/70 border border-soft-gray/50">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-primary">{{ $t->nama_template }}</p>
                                    @if($t->deskripsi)
                                    <p class="text-xs text-secondary/60 mt-0.5">{{ $t->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-sm text-secondary/60">Belum ada template tersedia</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Enter key trigger search
    document.getElementById('inputNIK').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            cariWarga();
        }
    });

    function cariWarga() {
        const nik = document.getElementById('inputNIK').value.trim();
        if (!nik || nik.length < 3) {
            alert('Masukkan minimal 3 karakter NIK atau nama warga.');
            return;
        }

        const btnCari = document.getElementById('btnCari');
        btnCari.disabled = true;
        btnCari.innerHTML = `<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Mencari...`;

        fetch('{{ route("autofield.cariWarga") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nik: nik })
        })
        .then(response => response.json())
        .then(data => {
            btnCari.disabled = false;
            btnCari.innerHTML = `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cari`;

            if (data.status === 'success') {
                tampilkanDataWarga(data.data);
                document.getElementById('suggestionsContainer').classList.add('hidden');
            } else if (data.status === 'suggestions') {
                tampilkanSuggestions(data.data);
                document.getElementById('wargaPreview').classList.add('hidden');
                document.getElementById('generateSection').classList.add('hidden');
            } else {
                alert(data.message);
                document.getElementById('wargaPreview').classList.add('hidden');
                document.getElementById('generateSection').classList.add('hidden');
                document.getElementById('suggestionsContainer').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btnCari.disabled = false;
            btnCari.innerHTML = `<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cari`;
            alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
        });
    }

    function tampilkanDataWarga(data) {
        document.getElementById('wargaPreview').classList.remove('hidden');
        document.getElementById('generateSection').classList.remove('hidden');
        document.getElementById('inputIdWarga').value = data.id;

        document.getElementById('prevNIK').textContent = data.nik;
        document.getElementById('prevNama').textContent = data.nama_lengkap;
        document.getElementById('prevTTL').textContent = data.tempat_lahir + ', ' + data.tanggal_lahir;
        document.getElementById('prevJK').textContent = data.jenis_kelamin;
        document.getElementById('prevAgama').textContent = data.agama;
        document.getElementById('prevStatus').textContent = data.status_perkawinan;
        document.getElementById('prevPekerjaan').textContent = data.pekerjaan;
        document.getElementById('prevPendidikan').textContent = data.pendidikan_terakhir;
        document.getElementById('prevAlamat').textContent = data.alamat_lengkap;
        document.getElementById('prevKK').textContent = data.no_kk;

        // Scroll to preview
        document.getElementById('wargaPreview').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function tampilkanSuggestions(suggestions) {
        const container = document.getElementById('suggestionsContainer');
        const list = document.getElementById('suggestionsList');
        container.classList.remove('hidden');

        let html = '';
        suggestions.forEach(s => {
            html += `
                <button type="button" onclick="pilihSuggestion('${s.nik}')" 
                        class="w-full flex items-center justify-between p-3 rounded-lg bg-bg-app/70 border border-soft-gray/50 hover:bg-primary/5 transition-colors text-left">
                    <div>
                        <p class="text-sm font-medium text-primary">${s.nama_lengkap}</p>
                        <p class="text-xs text-secondary/60">NIK: ${s.nik} • ${s.alamat || '-'}</p>
                    </div>
                    <svg class="w-4 h-4 text-primary/40 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            `;
        });
        list.innerHTML = html;
    }

    function pilihSuggestion(nik) {
        document.getElementById('inputNIK').value = nik;
        cariWarga();
    }
</script>

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
    .bg-secondary { background-color: var(--secondary); }
    .text-secondary { color: #000000; }
    .bg-bg-app { background-color: var(--bg-app); }
    .text-text-main { color: #000000; }
    .border-soft-gray { border-color: var(--soft-gray); }
    .focus\:ring-primary\/30:focus { --tw-ring-color: rgba(15, 157, 88, 0.3) !important; }
    .focus\:ring-primary\/50:focus { --tw-ring-color: rgba(15, 157, 88, 0.5) !important; }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
@endsection
