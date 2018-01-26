<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data, $status = true, $message = 'Requisição executado com sucesso.') {
            
            $customFormat = [
                'status' => $status,
                'data' => $data,
                'message' => $message
            ];
            return Response::make($customFormat)->original;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
