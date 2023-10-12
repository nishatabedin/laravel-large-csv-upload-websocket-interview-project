<?php

namespace App\Providers;

use App\Models\Product\UploadHistory;
use Illuminate\Support\ServiceProvider;
use App\Observers\UploadHistoryObserver;

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
        
        UploadHistory::observe(UploadHistoryObserver::class);
        
    }
}
