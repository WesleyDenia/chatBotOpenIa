<?php

namespace App\Providers;

use App\Services\WhatsApp\Providers\TwilioProvider;
use App\Services\WhatsApp\Providers\UltraMsgProvider;
use App\Services\WhatsApp\WhatsAppProviderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $provider = env('WHATSAPP_PROVIDER', 'ultramsg');

        if ($provider === 'ultramsg') {
            $this->app->bind(WhatsAppProviderInterface::class, UltraMsgProvider::class);
        } elseif ($provider === 'twilio') {
            $this->app->bind(WhatsAppProviderInterface::class, TwilioProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
