<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesOfferServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Api\ServicesOfferInterface', 'App\Http\Api\ServicesOfferServiceImpl');
    }
}
