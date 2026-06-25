<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Arsip Desa Caringin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =============================================
           TEMA PEMERINTAH - SISTEM ARSIP DESA CARINGIN
           Hijau Utama | Kuning Kedua | Biru Ketiga
           ============================================= */
        :root {
            /* ===== HIJAU – Warna Utama Pemerintah ===== */
            --gov-green:        #0B7A3E;   /* hijau tegas – tombol, header, sidebar */
            --gov-green-dark:   #085C2F;   /* hover state */
            --gov-green-light:  #159550;   /* aksen / gradient stop */
            --gov-green-pale:   #D4EFDF;   /* background lembut */
            --gov-green-mid:    #1DB85F;   /* highlight ringan */

            /* ===== KUNING – Warna Kedua / Aksen ===== */
            --gov-yellow:       #E6B800;   /* kuning emas terang */
            --gov-yellow-dark:  #B88F00;   /* hover / border */
            --gov-yellow-light: #FFD740;   /* highlight */
            --gov-yellow-pale:  #FFF8D6;   /* background lembut */

            /* ===== BIRU – Warna Ketiga / Informasi ===== */
            --gov-blue:         #1255A4;   /* biru pemerintah */
            --gov-blue-dark:    #0D3F7E;   /* hover */
            --gov-blue-light:   #2775D9;   /* aksen */
            --gov-blue-pale:    #DBEAFE;   /* background lembut */

            /* ===== NETRAL ===== */
            --bg-app:           #EEF2F7;   /* background halaman */
            --bg-card:          #FFFFFF;
            --text-dark:        #0F172A;   /* teks utama – sangat gelap */
            --text-body:        #1E293B;   /* teks isi */
            --text-muted:       #475569;   /* teks abu-abu */
            --border-light:     #CBD5E1;
            --border-mid:       #94A3B8;
        }

        /* ===== BASE ===== */
        * { box-sizing: border-box; }
        body {
            background-color: var(--bg-app);
            color: var(--text-body);
            font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ===== UTILITY CLASSES ===== */

        /* Backgrounds */
        .bg-gov-green       { background-color: var(--gov-green) !important; }
        .bg-gov-green-dark  { background-color: var(--gov-green-dark) !important; }
        .bg-gov-green-pale  { background-color: var(--gov-green-pale) !important; }
        .bg-gov-yellow      { background-color: var(--gov-yellow) !important; }
        .bg-gov-yellow-pale { background-color: var(--gov-yellow-pale) !important; }
        .bg-gov-blue        { background-color: var(--gov-blue) !important; }
        .bg-gov-blue-pale   { background-color: var(--gov-blue-pale) !important; }
        .bg-bg-app          { background-color: var(--bg-app) !important; }

        /* Legacy mapping (agar view lama tetap work) */
        .bg-primary         { background-color: var(--gov-green) !important; }
        .bg-primary-dark    { background-color: var(--gov-green-dark) !important; }
        .bg-primary-light   { background-color: var(--gov-green-light) !important; }
        .bg-primary-pale    { background-color: var(--gov-green-pale) !important; }
        .bg-secondary       { background-color: var(--gov-green-light) !important; }
        .bg-accent          { background-color: var(--gov-yellow) !important; }
        .bg-soft-gold       { background-color: var(--gov-yellow) !important; }
        .bg-blue-gov        { background-color: var(--gov-blue) !important; }
        .bg-blue-pale       { background-color: var(--gov-blue-pale) !important; }
        .bg-gold-pale       { background-color: var(--gov-yellow-pale) !important; }

        /* Text colors */
        .text-gov-green     { color: var(--gov-green) !important; }
        .text-gov-yellow    { color: var(--gov-yellow-dark) !important; }
        .text-gov-blue      { color: var(--gov-blue) !important; }
        .text-primary       { color: var(--gov-green) !important; }
        .text-secondary     { color: var(--gov-green-light) !important; }
        .text-secondary-light { color: rgba(255,255,255,0.82) !important; }
        .text-accent        { color: var(--gov-yellow-dark) !important; }
        .text-soft-gold     { color: var(--gov-yellow) !important; }
        .text-soft-gold-dark { color: var(--gov-yellow-dark) !important; }
        .text-blue-gov      { color: var(--gov-blue) !important; }
        .text-text-main     { color: var(--text-dark) !important; }
        .text-muted-gov     { color: var(--text-muted) !important; }

        /* Borders */
        .border-primary       { border-color: var(--gov-green) !important; }
        .border-primary-light { border-color: rgba(255,255,255,0.18) !important; }
        .border-gov-yellow    { border-color: var(--gov-yellow) !important; }
        .border-soft-gold     { border-color: var(--gov-yellow) !important; }
        .border-blue-gov      { border-color: var(--gov-blue) !important; }
        .border-soft-gray     { border-color: var(--border-light) !important; }

        /* ===== GRADIENT HELPERS ===== */
        .bg-linear-to-r   { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
        .bg-linear-to-br  { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
        .bg-gradient-to-r { background-image: linear-gradient(to right, var(--tw-gradient-stops)); }
        .bg-gradient-to-br{ background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }

        .from-primary      { --tw-gradient-from: var(--gov-green); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, transparent); }
        .from-primary-dark { --tw-gradient-from: var(--gov-green-dark); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, transparent); }
        .to-secondary      { --tw-gradient-to: var(--gov-green-light); }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: linear-gradient(135deg, var(--gov-green) 0%, var(--gov-green-light) 100%);
            color: #ffffff;
            border: 2px solid var(--gov-green-dark);
            padding: 0.6rem 1.4rem;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(11,122,62,0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--gov-green-dark) 0%, var(--gov-green) 100%);
            box-shadow: 0 4px 16px rgba(11,122,62,0.35);
            transform: translateY(-1px);
        }

        .btn-yellow {
            background: linear-gradient(135deg, var(--gov-yellow) 0%, var(--gov-yellow-light) 100%);
            color: #0F172A;
            border: 2px solid var(--gov-yellow-dark);
            padding: 0.6rem 1.4rem;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(230,184,0,0.3);
        }
        .btn-yellow:hover {
            background: linear-gradient(135deg, var(--gov-yellow-dark) 0%, var(--gov-yellow) 100%);
            box-shadow: 0 4px 16px rgba(230,184,0,0.4);
            transform: translateY(-1px);
        }

        /* legacy alias */
        .btn-gold { background: linear-gradient(135deg, var(--gov-yellow) 0%, var(--gov-yellow-light) 100%); color: #0F172A; border: 2px solid var(--gov-yellow-dark); padding: 0.6rem 1.4rem; border-radius: 0.6rem; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-gold:hover { background: linear-gradient(135deg, var(--gov-yellow-dark) 0%, var(--gov-yellow) 100%); transform: translateY(-1px); }

        .btn-blue {
            background: linear-gradient(135deg, var(--gov-blue) 0%, var(--gov-blue-light) 100%);
            color: #ffffff;
            border: 2px solid var(--gov-blue-dark);
            padding: 0.6rem 1.4rem;
            border-radius: 0.6rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 0.5rem;
            box-shadow: 0 2px 8px rgba(18,85,164,0.25);
        }
        .btn-blue:hover {
            background: linear-gradient(135deg, var(--gov-blue-dark) 0%, var(--gov-blue) 100%);
            box-shadow: 0 4px 16px rgba(18,85,164,0.35);
            transform: translateY(-1px);
        }

        /* ===== CARD ===== */
        .card-gov {
            background: var(--bg-card);
            border: 1.5px solid var(--border-light);
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card-gov:hover {
            box-shadow: 0 6px 24px rgba(11,122,62,0.12);
            transform: translateY(-2px);
        }

        /* ===== TABLE ===== */
        .table-gov thead tr {
            background: linear-gradient(90deg, var(--gov-green) 0%, var(--gov-green-light) 100%);
            color: white;
        }
        .table-gov thead th { font-weight: 700; font-size: 0.85rem; letter-spacing: 0.06em; padding: 0.85rem 1rem; }
        .table-gov tbody tr:hover { background-color: var(--gov-green-pale); }
        .table-gov tbody tr { border-bottom: 1px solid var(--border-light); transition: background 0.15s; }
        .table-gov tbody td { padding: 0.85rem 1rem; font-size: 0.9rem; color: var(--text-body); }

        /* ===== BADGES ===== */
        .badge-green  { background-color: var(--gov-green-pale); color: var(--gov-green-dark); border: 1.5px solid var(--gov-green); border-radius: 9999px; padding: 0.22rem 0.8rem; font-size: 0.78rem; font-weight: 700; }
        .badge-yellow { background-color: var(--gov-yellow-pale); color: var(--gov-yellow-dark); border: 1.5px solid var(--gov-yellow); border-radius: 9999px; padding: 0.22rem 0.8rem; font-size: 0.78rem; font-weight: 700; }
        .badge-gold   { background-color: var(--gov-yellow-pale); color: var(--gov-yellow-dark); border: 1.5px solid var(--gov-yellow); border-radius: 9999px; padding: 0.22rem 0.8rem; font-size: 0.78rem; font-weight: 700; }
        .badge-blue   { background-color: var(--gov-blue-pale); color: var(--gov-blue-dark); border: 1.5px solid var(--gov-blue); border-radius: 9999px; padding: 0.22rem 0.8rem; font-size: 0.78rem; font-weight: 700; }

        /* ===== SIDEBAR ===== */
        .sidebar-active { background-color: rgba(255,255,255,0.14); border-left: 4px solid var(--gov-yellow) !important; color: white !important; }
        .sidebar-item   { color: rgba(255,255,255,0.80); border-left: 4px solid transparent; }
        .sidebar-item:hover { background-color: rgba(255,255,255,0.09); color: white; border-left-color: rgba(255,255,255,0.3); }

        /* ===== FORM INPUTS ===== */
        .input-gov {
            background-color: #fff;
            border: 1.5px solid var(--border-light);
            border-radius: 0.6rem;
            padding: 0.65rem 1rem;
            color: var(--text-dark);
            width: 100%;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-gov:focus {
            outline: none;
            border-color: var(--gov-green);
            box-shadow: 0 0 0 3px rgba(11,122,62,0.18);
        }

        /* ===== SECTION HEADER STRIP ===== */
        .section-header {
            background: linear-gradient(135deg, var(--gov-green) 0%, var(--gov-green-light) 100%);
            color: white;
            padding: 0.85rem 1.4rem;
            border-radius: 0.6rem 0.6rem 0 0;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.01em;
        }

        /* ===== PAGE TITLE ===== */
        .page-title    { color: var(--gov-green); font-weight: 800; font-size: 1.75rem; }
        .page-subtitle { color: var(--text-muted); font-size: 0.95rem; }

        /* ===== STAT CARD ACCENT BARS ===== */
        .accent-bar-green  { height: 4px; background: linear-gradient(90deg, var(--gov-green), var(--gov-green-light)); border-radius: 9999px; }
        .accent-bar-yellow { height: 4px; background: linear-gradient(90deg, var(--gov-yellow), var(--gov-yellow-light)); border-radius: 9999px; }
        .accent-bar-blue   { height: 4px; background: linear-gradient(90deg, var(--gov-blue), var(--gov-blue-light)); border-radius: 9999px; }

        /* ===== UTILITY ===== */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        [x-cloak] { display: none !important; }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
        }

        /* ===== HOVER & FOCUS OVERRIDES FOR TAILWIND ===== */
        .hover\:bg-primary:hover    { background-color: var(--gov-green) !important; }
        .hover\:bg-secondary:hover  { background-color: var(--gov-green-light) !important; }
        .focus\:ring-primary\/50:focus   { --tw-ring-color: rgba(11,122,62,0.5) !important; }
        .focus\:ring-primary\/20:focus   { --tw-ring-color: rgba(11,122,62,0.2) !important; }
        .focus\:ring-soft-gold\/30:focus { --tw-ring-color: rgba(230,184,0,0.3) !important; }
        .focus\:border-primary:focus     { border-color: var(--gov-green) !important; }

        /* Tailwind bg-primary/10, /20 etc. equivalents */
        .bg-primary\/10 { background-color: rgba(11,122,62,0.10) !important; }
        .bg-primary\/20 { background-color: rgba(11,122,62,0.20) !important; }
        .bg-soft-gold\/20 { background-color: rgba(230,184,0,0.20) !important; }

        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 7px; height: 7px; }
        ::-webkit-scrollbar-track { background: var(--bg-app); }
        ::-webkit-scrollbar-thumb { background: var(--gov-green); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--gov-green-dark); }
    </style>
</head>
<body class="bg-bg-app font-sans leading-normal tracking-normal">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen" style="background-color: var(--bg-app);">
        
        @include('partials.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            
            @include('partials.navbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto" style="background-color: var(--bg-app);">
                @yield('content')
            </main>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-50"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-50"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden" style="display: none;">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Konfigurasi Tema Modal Pemerintah
        const SwalTheme = Swal.mixin({
            customClass: {
                popup: 'rounded-2xl border-0 shadow-2xl',
                title: 'text-xl font-bold text-gray-800',
                htmlContainer: 'text-gray-600',
                confirmButton: 'btn-primary px-6 py-2.5 mx-2',
                cancelButton: 'btn-yellow px-6 py-2.5 mx-2'
            },
            buttonsStyling: false
        });

        document.addEventListener('DOMContentLoaded', function () {
            // 1. Tangkap semua form yang pakai onsubmit="return confirm(...)"
            const deleteForms = document.querySelectorAll('form[onsubmit*="return confirm"]');
            deleteForms.forEach(form => {
                const originalOnsubmit = form.getAttribute('onsubmit');
                const match = originalOnsubmit.match(/confirm\(['"](.*?)['"]\)/);
                const message = match ? match[1] : 'Apakah Anda yakin ingin melanjutkan?';
                
                form.removeAttribute('onsubmit');
                
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    SwalTheme.fire({
                        title: 'Konfirmasi',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 2. Tangkap tombol Logout
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    SwalTheme.fire({
                        title: 'Konfirmasi Keluar',
                        text: 'Apakah Anda yakin ingin keluar dari sistem?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>