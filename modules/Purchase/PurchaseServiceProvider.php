<?php
namespace Modules\Purchase;
use Illuminate\Support\ServiceProvider;
use Modules\Purchase\Sms\Providers\AProvider;
use Modules\Purchase\Sms\Providers\BProvider;
use Modules\Purchase\Sms\Providers\CProvider;
use Modules\Purchase\Sms\SmsService;

class PurchaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(base_path('modules/Purchase/Database/Migrations'));

        $this->app->bind('Modules\Purchase\Sms\SmsInterface', function ($app) {
            return new SmsService([
                new AProvider(),
                new BProvider(),
                new CProvider(),
            ]);
        });
    }
}
