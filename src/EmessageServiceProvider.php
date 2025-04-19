<?php
namespace EMessage;

use Illuminate\Support\ServiceProvider;
use EMessage\Services\EMessageService;

class EmessageServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(EMessageService::class, function ($app) {
            return new EMessageService(
                config('e-message.account_sid'),
                config('e-message.auth_token'),
                config('e-message.default_send_number'),
                config('e-message.default_service_sid'),
                config('e-message.default_whatsapp_send_number'),
            );
        });

        $this->mergeConfigFrom(__DIR__.'/../config/e-message.php', 'e-message');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/e-message.php' => config_path('e-message.php'),
        ], 'e-message-config');
    }

}
