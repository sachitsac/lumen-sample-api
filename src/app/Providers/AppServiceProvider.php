<?php

namespace App\Providers;

use App\Services\{IJwt, Jwt};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IJwt::class, Jwt::class);
    }
}
