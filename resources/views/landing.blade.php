<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Caringin - Kabupaten Sukabumi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --accent: #FFD600;
            --navy: #0F9D58;
            --steel: #34A853;
            --offwhite: #F5F7FA;
            --text-main: #000000;
            --softgray: #E5E7EB;
            --gold: #C9A24D;
            --gold-light: #E6D3A6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--offwhite);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* --- PERBAIKAN CSS RESPONSIF UNTUK LAYOUT STAGGERED --- */
        
        /* Container utama slice */
        .slice-container {
            display: flex;
            align-items: flex-start; /* Default rata atas */
            padding: 10px;
            
            /* Settingan Default (Mobile) agar tidak gepeng */
            gap: 8px;       /* Jarak antar kotak lebih rapat di HP */
            height: 280px;  /* Tinggi dikurangi di HP agar rasio gambar bagus */
        }

        /* Logic Naik Turun (Staggered) - Mobile */
        .segment:nth-child(even) {
            margin-top: 30px; /* Turunnya tidak terlalu jauh di HP */
        }
        
        .segment:nth-child(odd) {
            margin-top: 0px; 
        }

        /* Settingan Desktop (Layar Besar) */
        @media (min-width: 1024px) {
            .slice-container {
                gap: 15px;     /* Jarak normal di desktop */
                height: 480px; /* Tinggi normal di desktop */
            }

            .segment:nth-child(even) {
                margin-top: 60px; /* Turun normal di desktop */
            }
        }

        /* Modifikasi class segment agar punya bentuk sendiri */
        .segment {
            flex: 1; /* Lebar dibagi rata */
            height: 85%; /* Tinggi batang */
            position: relative;
            overflow: hidden;
            border-radius: 12px; /* Sudut membulat per batang */
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            background-color: #ddd; /* Placeholder color saat loading */
        }

        /* Efek Active (saat carousel jalan) */
        .segment.active {
            transform: translateY(-10px); /* Naik sedikit saat aktif */
            box-shadow: 0 15px 30px rgba(201, 162, 77, 0.3);
            border: 2px solid var(--gold);
            z-index: 10;
        }
        
        .segment.active .segment-inner > div {
            filter: grayscale(0%) !important;
            transform: scale(1.1);
        }
        
        .segment:not(.active) .segment-inner > div {
            filter: grayscale(100%);
            opacity: 0.85;
        }
        
        /* Pagination dots */
        .pagination-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease; cursor: pointer;
        }
        .pagination-dot.active {
            background-color: var(--gold); transform: scale(1.3);
            box-shadow: 0 0 8px rgba(201, 162, 77, 0.8);
        }

        /* --- SISA CSS ORIGINAL (TIDAK DIUBAH) --- */

        .section-padding { padding-top: 5rem; padding-bottom: 5rem; }
        @media (min-width: 1024px) { .section-padding { padding-top: 7rem; padding-bottom: 7rem; } }
        .hero-gradient { background: linear-gradient(135deg, rgba(15, 157, 88, 0.98) 0%, rgba(51, 78, 104, 0.95) 100%); }
        .gold-underline { position: relative; display: inline-block; }
        .gold-underline::after { content: ''; position: absolute; left: 0; bottom: -8px; width: 60px; height: 3px; background-color: var(--gold); border-radius: 2px; }
        .card-shadow { box-shadow: 0 10px 40px rgba(15, 157, 88, 0.08); transition: all 0.3s ease; }
        .card-shadow:hover { box-shadow: 0 20px 60px rgba(15, 157, 88, 0.15); transform: translateY(-5px); }
        .gold-border { border: 1px solid rgba(201, 162, 77, 0.2); }
        .navy-border { border: 1px solid rgba(15, 157, 88, 0.1); }
        .feature-icon { width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; border-radius: 16px; margin-bottom: 1.5rem; background: linear-gradient(135deg, rgba(15, 157, 88, 0.05) 0%, rgba(15, 157, 88, 0.1) 100%); color: var(--navy); font-size: 1.5rem; transition: all 0.3s ease; }
        .gold-badge { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: var(--navy); font-weight: 600; padding: 0.5rem 1.25rem; border-radius: 50px; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 12px rgba(201, 162, 77, 0.2); }
        .nav-link { position: relative; padding-bottom: 4px; }
        .nav-link::after { content: ''; position: absolute; left: 0; bottom: 0; width: 0; height: 2px; background: var(--gold); transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        .hero-pattern { background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230A2540' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E"); }
        .btn-primary { background: linear-gradient(135deg, var(--navy) 0%, var(--steel) 100%); color: white; padding: 0.875rem 2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; position: relative; overflow: hidden; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(15, 157, 88, 0.2); }
        .btn-primary::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.7s; }
        .btn-primary:hover::after { left: 100%; }
        .btn-secondary { background: white; color: var(--navy); padding: 0.875rem 2rem; border-radius: 8px; font-weight: 600; border: 1px solid var(--softgray); transition: all 0.3s ease; }
        .btn-secondary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(15, 157, 88, 0.1); border-color: var(--gold); }
        .btn-gold { background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: var(--navy); padding: 0.875rem 2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; position: relative; overflow: hidden; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(201, 162, 77, 0.3); }
        .btn-gold::after { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); transition: left 0.7s; }
        .btn-gold:hover::after { left: 100%; }
        .section-title { font-size: 2.5rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem; line-height: 1.2; }
        @media (min-width: 768px) { .section-title { font-size: 3rem; } }
        .section-subtitle { color: var(--steel); font-size: 1.125rem; max-width: 600px; margin: 0 auto; }
        .gold-divider { width: 80px; height: 4px; background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%); border-radius: 2px; margin: 1.5rem auto; position: relative; overflow: hidden; }
        .gold-divider::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent); animation: shimmer 3s infinite; }
        .particles { position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 0; overflow: hidden; }
        .particle { position: absolute; background-color: rgba(201, 162, 77, 0.15); border-radius: 50%; animation: floatParticle 20s infinite linear; }
        @keyframes floatParticle { 0% { transform: translateY(0) rotate(0deg); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; } }
        .progress-container { position: fixed; top: 0; left: 0; width: 100%; height: 4px; background: transparent; z-index: 100; }
        .progress-bar { height: 4px; background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%); width: 0%; transition: width 0.3s ease; }
        .hover-lift { transition: transform 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
        .shine-container { position: relative; overflow: hidden; }
        .shine-container::before { content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%; background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%); transform: skewX(-25deg); z-index: 1; transition: left 0.75s; }
        .shine-container:hover::before { left: 125%; }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(201, 162, 77, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(201, 162, 77, 0); } 100% { box-shadow: 0 0 0 0 rgba(201, 162, 77, 0); } }
        .pulse { animation: pulse 2s infinite; }
        .segment-inner > div { transition-duration: 400ms !important; }
        
        /* Animasi masuk */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        @keyframes shimmer { 0% { background-position: -1000px 0; } 100% { background-position: 1000px 0; } }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fadeIn { animation: fadeIn 1s ease-out forwards; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse { animation: pulse 2s infinite; }
        .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
</head>
<body class="font-sans antialiased">
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>
    
    <div class="particles" id="particles"></div>
    
    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-md border-b navy-border animate-fadeInUp">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center pulse" style="background: linear-gradient(135deg, var(--navy) 0%, var(--steel) 100%);">
                        <i class="fas fa-mountain text-white"></i>
                    </div>
                    <div>
                        <div class="font-bold text-xl" style="color: var(--navy);">DESA CARINGIN</div>
                        <div class="text-xs font-medium" style="color: var(--steel);">Kabupaten Sukabumi</div>
                    </div>
                </div>
                
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#profil" class="nav-link font-medium" style="color: var(--navy);">Profil Desa</a>
                    <a href="#potensi" class="nav-link font-medium" style="color: var(--navy);">Potensi</a>
                    <a href="#layanan" class="nav-link font-medium" style="color: var(--navy);">Layanan</a>
                    <a href="#kontak" class="nav-link font-medium" style="color: var(--navy);">Kontak</a>
                    
                    <div class="h-6 w-px bg-gray-200"></div>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-gold flex items-center gap-2">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary flex items-center gap-2">
                                <i class="fas fa-sign-in-alt"></i>
                                Login Pegawai
                            </a>
                        @endauth
                    @endif
                </div>
                
                <button id="menu-toggle" class="lg:hidden text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <div id="mobile-menu" class="lg:hidden hidden mt-4 pb-4 border-t navy-border pt-4">
                <div class="flex flex-col space-y-4">
                    <a href="#profil" class="font-medium py-2 transition-all duration-300 hover:pl-2" style="color: var(--navy);">
                        <i class="fas fa-info-circle mr-2"></i>Profil Desa
                    </a>
                    <a href="#potensi" class="font-medium py-2 transition-all duration-300 hover:pl-2" style="color: var(--navy);">
                        <i class="fas fa-star mr-2"></i>Potensi
                    </a>
                    <a href="#layanan" class="font-medium py-2 transition-all duration-300 hover:pl-2" style="color: var(--navy);">
                        <i class="fas fa-hands-helping mr-2"></i>Layanan
                    </a>
                    <a href="#kontak" class="font-medium py-2 transition-all duration-300 hover:pl-2" style="color: var(--navy);">
                        <i class="fas fa-address-book mr-2"></i>Kontak
                    </a>
                    <div class="pt-4 border-t navy-border">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-gold w-full flex justify-center items-center gap-2">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary w-full flex justify-center items-center gap-2">
                                    <i class="fas fa-sign-in-alt"></i> Login Pegawai
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 hero-pattern overflow-hidden relative">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full animate-float" style="background: radial-gradient(circle, rgba(201, 162, 77, 0.1) 0%, rgba(201, 162, 77, 0) 70%);"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full animate-float" style="background: radial-gradient(circle, rgba(15, 157, 88, 0.05) 0%, rgba(15, 157, 88, 0) 70%);"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row items-center ms-10 me-10">
                <div class="w-full lg:w-1/2 text-center lg:text-left mb-12 lg:mb-0 animate-fadeInUp">
                    <div class="mb-6">
                        <span class="gold-badge animate-pulse">
                            <i class="fas fa-certificate"></i>
                            WEBSITE RESMI PEMERINTAH
                        </span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6" style="color: var(--navy);">
                        Selamat Datang di <br>
                        <span class="gold-underline">Desa Caringin</span>
                    </h1>
                    
                    <p class="text-lg mb-10 max-w-xl mx-auto lg:mx-0" style="color: var(--steel);">
                        Mewujudkan Desa Caringin yang Mandiri, Sejahtera, dan Religius melalui tata kelola pemerintahan yang transparan dan pelayanan publik yang prima.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#profil" class="btn-primary flex items-center justify-center gap-2">
                            <i class="fas fa-compass"></i>
                            Jelajahi Desa
                        </a>
                        <a href="#layanan" class="btn-secondary flex items-center justify-center gap-2">
                            <i class="fas fa-hands-helping"></i>
                            Layanan Warga
                        </a>
                    </div>
                </div>
                
                <div class="w-full lg:w-1/2 lg:pl-12 animate-fadeIn">
                    <div class="relative">
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] rounded-full opacity-20 blur-3xl animate-float" 
                             style="background: radial-gradient(circle, var(--gold) 0%, transparent 70%); z-index: 0;">
                        </div>

                        <div class="floating-element relative z-10">
                            <div class="slice-container">
                                
                                <div class="segment w-1/4 relative overflow-hidden" data-index="0">
                                    <div class="segment-inner w-full h-full absolute top-0 left-0">
                                        <div class="w-400 h-full bg-cover bg-no-repeat transform transition-all duration-500 ease-out"
                                             style="background-image: url('{{ asset('assets/img/profile_desa.jpeg') }}'); 
                                                    background-position: 0% 50%;
                                                    background-size: 400% 100%;
                                                    filter: grayscale(100%);">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="segment w-1/4 relative overflow-hidden" data-index="1">
                                    <div class="segment-inner w-full h-full absolute top-0 left-0">
                                        <div class="w-400 h-full bg-cover bg-no-repeat transform transition-all duration-500 ease-out"
                                             style="background-image: url('{{ asset('assets/img/profile_desa.jpeg') }}'); 
                                                    background-position: 33.33% 50%;
                                                    background-size: 400% 100%;
                                                    filter: grayscale(100%);">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="segment w-1/4 relative overflow-hidden" data-index="2">
                                    <div class="segment-inner w-full h-full absolute top-0 left-0">
                                        <div class="w-400 h-full bg-cover bg-no-repeat transform transition-all duration-500 ease-out"
                                             style="background-image: url('{{ asset('assets/img/profile_desa.jpeg') }}'); 
                                                    background-position: 66.66% 50%;
                                                    background-size: 400% 100%;
                                                    filter: grayscale(100%);">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="segment w-1/4 relative overflow-hidden" data-index="3">
                                    <div class="segment-inner w-full h-full absolute top-0 left-0">
                                        <div class="w-400 h-full bg-cover bg-no-repeat transform transition-all duration-500 ease-out"
                                             style="background-image: url('{{ asset('assets/img/profile_desa.jpeg') }}'); 
                                                    background-position: 100% 50%;
                                                    background-size: 400% 100%;
                                                    filter: grayscale(100%);">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
                                <div class="pagination-dot active" data-index="0"></div>
                                <div class="pagination-dot" data-index="1"></div>
                                <div class="pagination-dot" data-index="2"></div>
                                <div class="pagination-dot" data-index="3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="profil" class="section-padding bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 animate-fadeInUp">
                <h2 class="section-title">Profil Desa</h2>
                <div class="gold-divider"></div>
                <p class="section-subtitle">
                    Desa Caringin terletak di Kecamatan Gegerbitung, Kabupaten Sukabumi. 
                    Dikenal dengan keindahan alam yang asri dan kearifan lokal masyarakat yang menjunjung tinggi nilai gotong royong.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="rounded-2xl p-8 card-shadow gold-border animate-fadeInUp hover-lift" style="animation-delay: 0.1s;">
                    <div class="feature-icon hover-lift">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">Visi Desa</h3>
                    <p class="mb-6" style="color: var(--steel);">
                        Terwujudnya Desa Caringin yang Maju, Agamis, dan Berdaya Saing melalui Pembangunan Berkelanjutan.
                    </p>
                    <div class="flex items-center text-sm font-medium" style="color: var(--gold);">
                        <span>Panduan Pembangunan</span>
                        <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </div>
                </div>
                
                <div class="rounded-2xl p-8 card-shadow gold-border animate-fadeInUp hover-lift" style="animation-delay: 0.2s;">
                    <div class="feature-icon hover-lift">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">Misi Desa</h3>
                    <p class="mb-6" style="color: var(--steel);">
                        Meningkatkan kualitas SDM, memperkuat ekonomi kerakyatan, dan mewujudkan tata kelola pemerintahan yang bersih dan transparan.
                    </p>
                    <div class="flex items-center text-sm font-medium" style="color: var(--gold);">
                        <span>Langkah Strategis</span>
                        <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </div>
                </div>
                
                <div class="rounded-2xl p-8 card-shadow gold-border animate-fadeInUp hover-lift" style="animation-delay: 0.3s;">
                    <div class="feature-icon hover-lift">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">Sejarah Desa</h3>
                    <p class="mb-6" style="color: var(--steel);">
                        Desa Caringin lahir pada tahun 1980, hasil pemekaran dari Desa Gegerbitung berdasarkan Surat Keputusan Bupati Sukabumi tahun 1984.
                    </p>
                    <div class="flex items-center text-sm font-medium" style="color: var(--gold);">
                        <span>Warisan Leluhur</span>
                        <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="potensi" class="section-padding" style="background-color: var(--offwhite);">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-16">
                <div class="mb-8 lg:mb-0 lg:w-1/2 animate-fadeInUp">
                    <h2 class="section-title">Potensi & Keunggulan</h2>
                    <div class="gold-divider" style="margin: 1.5rem 0;"></div>
                    <p class="section-subtitle text-left mx-0">
                        Desa Caringin memiliki berbagai potensi unggulan yang menjadi pondasi kemajuan dan kesejahteraan masyarakat.
                    </p>
                </div>
                
                <div class="lg:w-1/2 lg:text-right animate-fadeInUp" style="animation-delay: 0.2s;">
                    <span class="gold-badge">
                        <i class="fas fa-star"></i>
                        Unggulan Lokal
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="rounded-2xl overflow-hidden bg-white card-shadow animate-fadeInUp hover-lift" style="animation-delay: 0.1s;">
                    <div class="h-48 relative overflow-hidden shine-container">
                        <div class="absolute inset-0 flex items-center justify-center" style="background: linear-gradient(135deg, rgba(15, 157, 88, 0.9) 0%, rgba(51, 78, 104, 0.9) 100%);">
                            <i class="fas fa-seedling text-6xl text-white"></i>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 h-2" style="background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%);"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">Pertanian & Perkebunan</h3>
                        <p class="mb-6" style="color: var(--steel);">
                            Ditopang oleh area perkebunan seluas 262,7 Ha dan persawahan seluas 273,3 Ha yang menjadi pusat kegiatan ekonomi warga desa.
                        </p>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 hover-lift" style="background-color: rgba(15, 157, 88, 0.1);">
                                <i class="fas fa-leaf text-xs" style="color: var(--navy);"></i>
                            </div>
                            <span class="text-sm font-medium" style="color: var(--navy);">Lahan Subur</span>
                        </div>
                    </div>
                </div>
                
                <div class="rounded-2xl overflow-hidden bg-white card-shadow animate-fadeInUp hover-lift" style="animation-delay: 0.2s;">
                    <div class="h-48 relative overflow-hidden shine-container">
                        <div class="absolute inset-0 flex items-center justify-center" style="background: linear-gradient(135deg, rgba(15, 157, 88, 0.9) 0%, rgba(51, 78, 104, 0.9) 100%);">
                            <i class="fas fa-industry text-6xl text-white"></i>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 h-2" style="background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%);"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">UMKM & Kerajinan</h3>
                        <p class="mb-6" style="color: var(--steel);">
                            Produk olahan makanan tradisional dan kerajinan tangan anyaman bambu khas warga desa.
                        </p>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 hover-lift" style="background-color: rgba(15, 157, 88, 0.1);">
                                <i class="fas fa-hands text-xs" style="color: var(--navy);"></i>
                            </div>
                            <span class="text-sm font-medium" style="color: var(--navy);">Kerajinan Tangan</span>
                        </div>
                    </div>
                </div>
                
                <div class="rounded-2xl overflow-hidden bg-white card-shadow animate-fadeInUp hover-lift" style="animation-delay: 0.3s;">
                    <div class="h-48 relative overflow-hidden shine-container">
                        <div class="absolute inset-0 flex items-center justify-center" style="background: linear-gradient(135deg, rgba(15, 157, 88, 0.9) 0%, rgba(51, 78, 104, 0.9) 100%);">
                            <i class="fas fa-umbrella-beach text-6xl text-white"></i>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 h-2" style="background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%);"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold mb-4" style="color: var(--navy);">Wisata Alam</h3>
                        <p class="mb-6" style="color: var(--steel);">
                            Destinasi wisata curug (air terjun) dan jalur trekking perbukitan yang menawan.
                        </p>
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 hover-lift" style="background-color: rgba(15, 157, 88, 0.1);">
                                <i class="fas fa-tree text-xs" style="color: var(--navy);"></i>
                            </div>
                            <span class="text-sm font-medium" style="color: var(--navy);">Ekowisata</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="section-padding hero-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full -mt-32 -mr-32 opacity-10 animate-float" style="background: radial-gradient(circle, var(--gold) 0%, transparent 70%);"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full -mb-48 -ml-48 opacity-10 animate-float" style="animation-delay: 2s; background: radial-gradient(circle, var(--gold-light) 0%, transparent 70%);"></div>
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 animate-fadeInUp">
                <h2 class="section-title text-white">Sistem Pemerintahan Digital</h2>
                <div class="gold-divider"></div>
                <p class="section-subtitle text-gray-300">
                    Pemerintah Desa Caringin berkomitmen meningkatkan transparansi dan kecepatan pelayanan melalui sistem arsip dan administrasi digital terpadu.
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                <div class="rounded-2xl p-8 animate-fadeInUp hover-lift" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); animation-delay: 0.1s;">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 hover-lift" style="background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Layanan Warga</h3>
                    </div>
                    <p class="mb-6 text-gray-300">
                        Pengurusan surat pengantar, KTP, KK, dan dokumen kependudukan lainnya dilayani setiap hari kerja dengan sistem yang terintegrasi.
                    </p>
                    <div class="bg-white/10 p-4 rounded-lg border border-white/20 hover-lift">
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-3 animate-pulse" style="color: var(--gold);"></i>
                            <div>
                                <div class="font-bold">Senin - Jumat</div>
                                <div class="text-sm text-gray-300">08.00 - 15.00 WIB</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="rounded-2xl p-8 relative overflow-hidden animate-fadeInUp hover-lift" style="animation-delay: 0.2s; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);">
                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full -mt-16 -mr-16 opacity-20" style="background-color: var(--navy);"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 hover-lift" style="background-color: var(--navy);">
                                <i class="fas fa-lock text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold" style="color: var(--navy);">Akses Perangkat Desa</h3>
                        </div>
                        <p class="mb-8" style="color: var(--navy);">
                            Masuk ke sistem arsip digital untuk pengelolaan dokumen desa secara terintegrasi dan aman.
                        </p>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-primary inline-flex items-center gap-2" style="background: var(--navy);">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary inline-flex items-center gap-2" style="background: var(--navy);">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login Sistem
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-6 rounded-xl animate-fadeInUp hover-lift" style="animation-delay: 0.1s; background: rgba(255, 255, 255, 0.05);">
                    <i class="fas fa-file-contract text-3xl mb-4" style="color: var(--gold);"></i>
                    <div class="font-bold mb-2">Surat Menyurat</div>
                    <div class="text-sm text-gray-300">Digital & Terintegrasi</div>
                </div>
                
                <div class="text-center p-6 rounded-xl animate-fadeInUp hover-lift" style="animation-delay: 0.2s; background: rgba(255, 255, 255, 0.05);">
                    <i class="fas fa-archive text-3xl mb-4" style="color: var(--gold);"></i>
                    <div class="font-bold mb-2">Arsip Digital</div>
                    <div class="text-sm text-gray-300">Terorganisir & Aman</div>
                </div>
                
                <div class="text-center p-6 rounded-xl animate-fadeInUp hover-lift" style="animation-delay: 0.3s; background: rgba(255, 255, 255, 0.05);">
                    <i class="fas fa-chart-line text-3xl mb-4" style="color: var(--gold);"></i>
                    <div class="font-bold mb-2">Data Statistik</div>
                    <div class="text-sm text-gray-300">Real-time & Akurat</div>
                </div>
                
                <div class="text-center p-6 rounded-xl animate-fadeInUp hover-lift" style="animation-delay: 0.4s; background: rgba(255, 255, 255, 0.05);">
                    <i class="fas fa-bullhorn text-3xl mb-4" style="color: var(--gold);"></i>
                    <div class="font-bold mb-2">Pengumuman</div>
                    <div class="text-sm text-gray-300">Cepat & Tepat Sasaran</div>
                </div>
            </div>
        </div>
    </section>

    <footer id="kontak" class="pt-16 pb-8 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <div class="animate-fadeInUp">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, var(--navy) 0%, var(--steel) 100%);">
                            <i class="fas fa-mountain text-white"></i>
                        </div>
                        <div>
                            <div class="font-bold text-xl" style="color: var(--navy);">DESA CARINGIN</div>
                            <div class="text-xs font-medium" style="color: var(--steel);">Kabupaten Sukabumi</div>
                        </div>
                    </div>
                    <p class="mb-6" style="color: var(--steel);">
                        Kecamatan Gegerbitung, Kabupaten Sukabumi, Jawa Barat, Indonesia. Mewujudkan pelayanan publik yang prima untuk masyarakat.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/majucaringin.gegerbitung?mibextid=rS40aB7S9Ucbxw6v" class="w-10 h-10 rounded-full flex items-center justify-center hover-lift" style="background-color: rgba(15, 157, 88, 0.1); color: var(--navy);">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center hover-lift" style="background-color: rgba(15, 157, 88, 0.1); color: var(--navy);">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center hover-lift" style="background-color: rgba(15, 157, 88, 0.1); color: var(--navy);">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full flex items-center justify-center hover-lift" style="background-color: rgba(15, 157, 88, 0.1); color: var(--navy);">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <div class="animate-fadeInUp" style="animation-delay: 0.1s;">
                    <h4 class="text-lg font-bold mb-6" style="color: var(--navy);">Kontak Kami</h4>
                    <div class="space-y-4">
                        <div class="flex items-start hover-lift p-3 rounded-lg transition-all duration-300 hover:bg-gray-50">
                            <i class="fas fa-map-marker-alt mt-1 mr-3" style="color: var(--gold);"></i>
                            <div>
                                <div class="font-medium" style="color: var(--navy);">Alamat</div>
                                <div class="text-sm" style="color: var(--steel);">Jl. Raya Gegerbitung KM.15, Sukabumi 43197</div>
                            </div>
                        </div>
                        <div class="flex items-start hover-lift p-3 rounded-lg transition-all duration-300 hover:bg-gray-50">
                            <i class="fas fa-phone-alt mt-1 mr-3" style="color: var(--gold);"></i>
                            <div>
                                <div class="font-medium" style="color: var(--navy);">Handphone Kades</div>
                                <div class="text-sm" style="color: var(--steel);">0815-4640-2939</div>
                            </div>
                        </div>
                        <div class="flex items-start hover-lift p-3 rounded-lg transition-all duration-300 hover:bg-gray-50">
                            <i class="fas fa-envelope mt-1 mr-3" style="color: var(--gold);"></i>
                            <div>
                                <div class="font-medium" style="color: var(--navy);">Email</div>
                                <div class="text-sm" style="color: var(--steel);">info@desacaringin.sukabumi.id</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="animate-fadeInUp" style="animation-delay: 0.2s;">
                    <h4 class="text-lg font-bold mb-6" style="color: var(--navy);">Jam Layanan</h4>
                    <div class="space-y-4">
                        <div class="p-4 rounded-lg hover-lift" style="background-color: rgba(15, 157, 88, 0.03);">
                            <div class="font-medium mb-1" style="color: var(--navy);">Hari Kerja</div>
                            <div class="text-sm" style="color: var(--steel);">Senin - Jumat: 08.00 - 15.00 WIB</div>
                        </div>
                        <div class="p-4 rounded-lg hover-lift" style="background-color: rgba(201, 162, 77, 0.05);">
                            <div class="font-medium mb-1" style="color: var(--navy);">Layanan Darurat</div>
                            <div class="text-sm" style="color: var(--steel);">24 Jam melalui Call Center</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-200 text-center">
                <p class="text-sm" style="color: var(--steel);">
                    &copy; <span id="currentYear">{{ date('Y') }}</span> Pemerintah Desa Caringin. Hak Cipta Dilindungi.
                </p>
                <p class="text-xs mt-2" style="color: var(--steel); opacity: 0.7;">
                    Dibangun dengan <i class="fas fa-heart animate-pulse" style="color: #ef4444;"></i> untuk kemajuan Desa Caringin
                </p>
            </div>
        </div>
    </footer>

    <button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 rounded-full flex items-center justify-center z-40 opacity-0 transition-all duration-300 hover-lift" style="background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%); color: var(--navy); box-shadow: 0 4px 20px rgba(201, 162, 77, 0.3);">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
        
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuToggle.innerHTML = mobileMenu.classList.contains('hidden') 
                ? '<i class="fas fa-bars text-xl"></i>' 
                : '<i class="fas fa-times text-xl"></i>';
        });
        
        // Close mobile menu when clicking a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuToggle.innerHTML = '<i class="fas fa-bars text-xl"></i>';
            });
        });
        
        // Progress Bar
        const progressBar = document.getElementById('progressBar');
        
        window.addEventListener('scroll', () => {
            const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (window.scrollY / windowHeight) * 100;
            progressBar.style.width = scrolled + '%';
            
            // Back to Top Button
            const backToTopButton = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTopButton.style.opacity = '1';
            } else {
                backToTopButton.style.opacity = '0';
            }
        });
        
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 3px and 10px
                const size = Math.random() * 7 + 3;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random animation delay and duration
                const delay = Math.random() * 20;
                const duration = Math.random() * 10 + 20;
                particle.style.animationDelay = `${delay}s`;
                particle.style.animationDuration = `${duration}s`;
                
                // Random opacity
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                
                particlesContainer.appendChild(particle);
            }
        }
        
        // Initialize particles when page loads
        window.addEventListener('load', createParticles);
        
        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!entry.target.classList.contains('animate-fadeInUp') && !entry.target.classList.contains('animate-fadeIn')) {
                        // Add animation class based on element type
                        if (entry.target.classList.contains('card-shadow') || entry.target.classList.contains('section-title') || entry.target.classList.contains('feature-icon')) {
                            entry.target.classList.add('animate-fadeInUp');
                        } else {
                            entry.target.classList.add('animate-fadeIn');
                        }
                    }
                }
            });
        }, observerOptions);
        
        // Observe elements to animate
        document.querySelectorAll('.card-shadow, .section-title, .feature-icon, .hover-lift').forEach(el => {
            observer.observe(el);
        });
        
        // Add shine effect to cards on hover
        document.querySelectorAll('.shine-container').forEach(container => {
            container.addEventListener('mouseenter', function() {
                this.classList.add('shine');
            });
        });
        
        // Add hover effect to feature icons
        document.querySelectorAll('.feature-icon').forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(5deg)';
            });
            
            icon.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        });
        
        // Initial Carousel Script
        document.addEventListener('DOMContentLoaded', function() {
            const segments = document.querySelectorAll('.segment');
            const paginationDots = document.querySelectorAll('.pagination-dot');
            
            let currentSegmentIndex = 0;
            let autoPlayInterval;
            const intervalDuration = 1500; // CEPAT: 1.5 detik per segmen (dari 3 detik)
            
            // Initialize
            function initSegmentCarousel() {
                activateSegment(0);
                startAutoPlay();
            }
            
            // Activate a specific segment
            function activateSegment(index) {
                if (index < 0 || index >= segments.length) return;
                
                currentSegmentIndex = index;
                
                segments.forEach(segment => {
                    segment.classList.remove('active');
                });
                
                segments[currentSegmentIndex].classList.add('active');
                
                paginationDots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === currentSegmentIndex);
                });
            }
            
            // Move to next segment
            function nextSegment() {
                const nextIndex = (currentSegmentIndex + 1) % segments.length;
                activateSegment(nextIndex);
            }
            
            // Start auto-play
            function startAutoPlay() {
                if (autoPlayInterval) clearInterval(autoPlayInterval);
                autoPlayInterval = setInterval(() => {
                    nextSegment();
                }, intervalDuration);
            }
            
            // REMOVED HOVER LISTENER to continue animation on hover
            
            // Optional: Click dot to go to segment
            paginationDots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    activateSegment(index);
                });
            });
            
            // Optional: Click segment to activate
            segments.forEach(segment => {
                segment.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    activateSegment(index);
                });
            });
            
            // Initialize
            initSegmentCarousel();
            
            // Fallback for image loading
            const imageUrl = "{{ asset('assets/img/profile_desa.jpeg') }}";
            const testImage = new Image();
            testImage.onerror = function() {
                document.querySelectorAll('.segment-inner > div').forEach(div => {
                    div.style.backgroundImage = "url('https://via.placeholder.com/1200x800/0A2540/FFFFFF?text=Kantor+Desa+Caringin')";
                });
            };
            testImage.src = imageUrl;
        });
    </script>
</body>
</html>