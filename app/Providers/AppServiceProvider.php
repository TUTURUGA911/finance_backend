<?php

namespace App\Providers;

use App\Repositories\ExpenseRepository;
use App\Repositories\IncomeRepository;
use App\Services\SqidsService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IncomeRepository::class);
        $this->app->singleton(ExpenseRepository::class);

        $this->app->singleton('sqids', function ($app) {
            return new SqidsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
