<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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

        $this->app->bind(
            'App\Helpers\Interfaces\SmsInterface',
            'App\Helpers\Sms\EmailSmsSender'
        );

        $this->app->bind(
            'App\Helpers\Interfaces\EmailViewInterface',
            'App\Helpers\Email\EmailView'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
