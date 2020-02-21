<?php

namespace Stylers\Address\Providers;

use Illuminate\Support\ServiceProvider;
use Stylers\Address\Contracts\Models\AddressInterface;
use Stylers\Address\Models\Address;

class AddressServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    public function register()
    {
        $this->app->bind(AddressInterface::class, Address::class);
    }
}
