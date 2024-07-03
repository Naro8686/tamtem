<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        URL::forceRootUrl(config('app.url'));
        Carbon::serializeUsing(static function($carbon) {
            $timezone = (array) $carbon->timezone;
            return [
                'date'          => $carbon->toDateTimeString(),
                'timezone_type' => $timezone['timezone_type'] ?? 3,
                'timezone'      => $timezone['timezone'] ?? 'UTC',
            ];
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local'); // После этого, вспомогательные функции Laravel такие, как route(), action(), asset() и другие будут автоматически генерировать адреса с HTTPS
    }
}
