<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use View;

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
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            $pengaturan = Pengaturan::first();
            $view->with('global_pengaturan', $pengaturan);
        });
    }
}
