<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- Tambahkan ini
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini
use App\Models\Notifikasi; // <-- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // View Composer: Mengirim data notifikasi ke 'partials.navbar' setiap kali view itu dimuat
        View::composer('partials.navbar', function ($view) {
            $notifikasiBelumDibaca = [];
            $jumlahNotifikasi = 0;

            if (Auth::check()) {
                // Ambil notifikasi milik user yang sedang login
                $notifikasiBelumDibaca = Notifikasi::where('id_user', Auth::id())
                                            ->where('sudah_dibaca', false)
                                            ->latest()
                                            ->take(5) // Ambil 5 terbaru saja
                                            ->get();
                                            
                $jumlahNotifikasi = Notifikasi::where('id_user', Auth::id())
                                            ->where('sudah_dibaca', false)
                                            ->count();
            }

            $view->with('notifList', $notifikasiBelumDibaca)
                 ->with('notifCount', $jumlahNotifikasi);
        });
    }
}