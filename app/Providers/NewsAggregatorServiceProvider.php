<?php

namespace App\Providers;

use App\Services\ContentServices\GuardianApiService;
use App\Services\ContentServices\NewsAggregatorService;
use App\Services\ContentServices\NewsApiService;
use App\Services\ContentServices\NytApiService;
use Illuminate\Support\ServiceProvider;

class NewsAggregatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(NewsAggregatorService::class, function ($app) {
            $services = [
                new NytApiService(),
                new NewsApiService(),
                new GuardianApiService()
            ];

            return new NewsAggregatorService($services);
        });
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
