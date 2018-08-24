# Laravel Address

[![Latest Stable Version](https://poser.pugx.org/stylers/laravel-address/version)](https://packagist.org/packages/stylers/laravel-address) 
[![Total Downloads](https://poser.pugx.org/stylers/laravel-address/downloads)](https://packagist.org/packages/stylers/laravel-address) 
[![License](https://poser.pugx.org/stylers/laravel-address/license)](https://packagist.org/packages/stylers/laravel-address) 
[![Build Status](https://travis-ci.org/stylers-llc/laravel-address.svg?branch=master)](https://travis-ci.org/stylers-llc/laravel-address) 
[![codecov](https://codecov.io/gh/stylers-llc/laravel-address/branch/master/graph/badge.svg)](https://codecov.io/gh/stylers-llc/laravel-address) 

## Requirements
- PHP >= 7.1.3
- Laravel ~5.x

## Installation
```bash
composer require stylers/laravel-address
```

You can publish the migration
```bash
php artisan vendor:publish --provider="Stylers\Address\Providers\AddressServiceProvider"
```

After the migration has been published, you can run the migrations
```bash
php artisan migrate
```

## Usage
* How to address
```php
use Stylers\Address\Contracts\Models\Traits\HasAddressesInterface;
use Stylers\Address\Models\Traits\HasAddresses;

class User extends Authenticatable implements HasAddressesInterface
{
    use Notifiable;
    use HasAddresses;
}
```

## Update or Create Address
```php
use Stylers\Address\Enums\AddressTypeEnum;

$user = User::first();
$attributes = [
    "country" => "Hungary",
    "zip_code" => "1055",
    "city" => "Budapest",
    "name_of_public_place" => "Kossuth Lajos",
    "type_of_public_place" => "place",
    "number_of_house" => "1-3",
]; // array
$type = AddressTypeEnum::PRIMARY; // ?string
$address = $user->updateOrCreateAddress($attributes, $type); // AddressInterface
```

## Delete Address
```php
use Stylers\Address\Enums\AddressTypeEnum;

$user = User::first();
$type = AddressTypeEnum::PRIMARY; // ?string
$isDeleted = $user->deleteAddress($type); // boolean
```

## Sync Address(es)
The `syncAddresses()` method delete all addressable address if $`type` is not exists in `$arrayOfAttributes[$type][]`.
The `syncAddresses()` method create all `$type` of `arrayOfAttributes[$type][]` if type is not exists in `addresses` table.
```php
use Stylers\Address\Enums\AddressTypeEnum;

$user = User::first();
$arrayOfAttributes = [
    AddressTypeEnum::MAILING => [
       "country" => "Hungary",
       "zip_code" => "1055",
       "city" => "Budapest",
       "name_of_public_place" => "Kossuth Lajos",
       "type_of_public_place" => "place",
       "number_of_house" => "1-3",
    ]
];
$addresses = $user->syncAddresses($arrayOfAttributes); // Collection
```