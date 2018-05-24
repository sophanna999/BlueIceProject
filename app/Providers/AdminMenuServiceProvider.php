<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AdminMenuServiceProvider extends ServiceProvider
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
        $this->AdminMenuComposer();
    }
    public function AdminMenuComposer()
    {
        view()->composer('layouts.admin','App\Http\Composers\AdminMenuComposer');
    }
}
