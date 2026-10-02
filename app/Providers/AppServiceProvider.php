<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pilih salah satu sesuai CSS framework Anda:
        Paginator::useBootstrapFive();   // kalau pakai Bootstrap 5
        // Paginator::useTailwind();     // kalau pakai Tailwind
        // Paginator::useBootstrapFour(); // kalau pakai Bootstrap 4
    }
}