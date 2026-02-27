<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Account\AccountService;
use App\Services\Project\ProjectService;
use App\Services\Document\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('account_service', function ($app) {
            return new AccountService();
        });

        $this->app->singleton('project_service', function ($app) {
            return new ProjectService();
        });

        $this->app->singleton('document_service', function ($app) {
            return new DocumentService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        JsonResource::withoutWrapping();
    }
}
