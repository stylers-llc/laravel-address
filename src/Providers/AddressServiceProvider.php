<?php

namespace Stylers\Address\Providers;

use Illuminate\Support\ServiceProvider;
use Stylers\Address\Contracts\Models\AddressInterface;
use Stylers\Address\Models\Address;

/**
 * Class AddressServiceProvider
 * @package Stylers\Address\Providers
 */
class AddressServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AddressInterface::class, Address::class);
    }
}
