<?php
namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Telesign\TelesignClient;

class TelesignServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            $client = new Client([
                'base_uri' => 'https://rest-api.telesign.com/v1/',
                'timeout' => 10,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(config('telesign.customer_id') . ':' . config('telesign.api_key')),
                ],
            ]);
            return $client;
        });
    }
}
