<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" 
     class="fixed z-[60] inset-y-0 left-0 w-64 transition duration-300 transform bg-primary overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    
    <div class="px-6 py-8">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-primary to-secondary shadow-lg border border-primary-light">
                    <svg class="h-7 w-7 text-soft-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-white text-xl font-bold tracking-tight">SIP-DESA</span>
                <span class="text-secondary-light text-xs font-medium mt-0.5">Sistem Informasi Pengarsipan</span>
            </div>
        </div>
    </div>

    <nav class="px-4 space-y-1">
        <div class="mb-6">
            <div class="px-3 mb-3">
                <p class="text-xs font-semibold text-secondary-light uppercase tracking-wider">Menu Utama</p>
                <div class="h-px bg-primary-light/30 mt-2"></div>
            </div>
            
            <div class="space-y-1">
                <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                   href="{{ route('dashboard') }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium text-sm">Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full animate-pulse"></div>
                    @endif
                </a>

                <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dokumen.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                   href="{{ route('dokumen.index') }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('dokumen.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dokumen.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium text-sm">Arsip Dokumen</span>
                    @if(request()->routeIs('dokumen.*'))
                        <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                    @endif
                </a>
                
                <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                   href="{{ route('laporan.index') }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('laporan.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('laporan.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                  d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium text-sm">Laporan</span>
                    @if(request()->routeIs('laporan.*'))
                        <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                    @endif
                </a>

                @if(in_array(Auth::user()->role->nama_peran, ['Admin', 'Operator']))
                <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('autofield.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                   href="{{ route('autofield.index') }}">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('autofield.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('autofield.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium text-sm">Cetak Surat</span>
                    @if(request()->routeIs('autofield.*'))
                        <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                    @endif
                </a>
                @endif
            </div>
        </div>

        @if(Auth::user()->role->nama_peran == 'Admin')
            <div class="mb-6">
                <div class="px-3 mb-3">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-secondary-light uppercase tracking-wider">Administrator</p>
                    </div>
                    <div class="h-px bg-primary-light/30 mt-2"></div>
                </div>

                <div class="space-y-1">
                    <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                       href="{{ route('admin.kategori.index') }}">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.kategori.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.kategori.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium text-sm">Kategori</span>
                        @if(request()->routeIs('admin.kategori.*'))
                            <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                        @endif
                    </a>

                    <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                       href="{{ route('admin.users.index') }}">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium text-sm">Pengguna</span>
                        @if(request()->routeIs('admin.users.*'))
                            <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                        @endif
                    </a>

                    <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.logs.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                       href="{{ route('admin.logs.index') }}">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.logs.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.logs.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium text-sm">Log Aktivitas</span>
                        @if(request()->routeIs('admin.logs.*'))
                            <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                        @endif
                    </a>

                    <a class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.backup.*') ? 'bg-white/10 text-white border-l-4 border-soft-gold' : 'text-secondary-light hover:bg-white/5 hover:text-white' }}" 
                       href="{{ route('admin.backup.index') }}">
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('admin.backup.*') ? 'bg-soft-gold/20' : 'bg-white/5' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.backup.*') ? 'text-soft-gold' : 'text-secondary-light' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                      d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                        </div>
                        <span class="ml-3 font-medium text-sm">Backup</span>
                        @if(request()->routeIs('admin.backup.*'))
                            <div class="ml-auto w-2 h-2 bg-soft-gold rounded-full"></div>
                        @endif
                    </a>
                </div>
            </div>
        @endif
    </nav>

    <div class="sticky bottom-0 left-0 right-0 bg-primary border-t border-primary-light/50 mt-8">
        <div class="p-4">
            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex items-center w-full px-3 py-3 rounded-lg text-secondary-light hover:bg-red-500/10 hover:text-red-200 transition-all duration-200 group">
                    <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 group-hover:bg-red-500/20 transition-colors duration-200">
                        <svg class="w-5 h-5 group-hover:text-red-300 transition-colors duration-200" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </div>
                    <span class="ml-3 font-medium text-sm group-hover:text-white transition-colors duration-200">
                        Keluar
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Colors for Sidebar */
    .bg-primary {
        background-color: #0F9D58;
    }
    
    .bg-primary-light {
        background-color: rgba(15, 157, 88, 0.5);
    }
    
    .text-primary {
        color: #0F9D58;
    }
    
    .border-primary-light {
        border-color: rgba(15, 157, 88, 0.3);
    }
    
    .bg-secondary {
        background-color: #34A853;
    }
    
    .text-secondary-light {
        color: #8FA3B8;
    }
    
    .bg-soft-gold {
        background-color: #C9A24D;
    }
    
    .text-soft-gold {
        color: #C9A24D;
    }
    
    .border-soft-gold {
        border-color: #C9A24D;
    }
    
    /* Gradient background */
    .bg-gradient-to-br {
        background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
    }
    .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>