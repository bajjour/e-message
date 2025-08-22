<?php
namespace EMessage;

use EMessage\Services\WhatsAppService;
use Illuminate\Support\ServiceProvider;
use EMessage\Services\EMessageService;
use EMessage\Services\ISMSService;

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

        $this->app->singleton(WhatsAppService::class, function ($app) {
            return new WhatsAppService(
                config('e-message.whatsapp_access_token'),
                config('e-message.whatsapp_app_id'),
                config('e-message.whatsapp_app_secret'),
                config('e-message.whatsapp_phone_number_id'),
            );
        });

        $this->app->singleton(ISMSService::class, function ($app) {
            return new ISMSService(
                config('e-message.isms_username'),
                config('e-message.isms_password'),
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
