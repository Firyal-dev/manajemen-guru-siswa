<?php

namespace App\Providers;

use App\Models\TahunAjaran;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Database\Eloquent\Model::preventLazyLoading(!app()->isProduction());
        \Illuminate\Database\Eloquent\Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            \Illuminate\Support\Facades\Log::warning("Lazy loading: {$relation} on " . get_class($model));
        });

        View::composer('layouts.navigation', function ($view) {
            $view->with([
                'tahunAjaranAktif' => TahunAjaran::where('aktif', true)->first(),
                'tahunAjaran' => TahunAjaran::orderByDesc('tahun_mulai')->get(),
            ]);
        });
    }
}
