# Laravel Address

[![Latest Stable Version](https://poser.pugx.org/stylers/laravel-address/version)](https://packagist.org/packages/stylers/laravel-address) 
[![Total Downloads](https://poser.pugx.org/stylers/laravel-address/downloads)](https://packagist.org/packages/stylers/laravel-address) 
[![License](https://poser.pugx.org/stylers/laravel-address/license)](https://packagist.org/packages/stylers/laravel-address) 
[![Build Status](https://travis-ci.org/stylers-llc/laravel-address.svg?branch=master)](https://travis-ci.org/stylers-llc/laravel-address) 
[![codecov](https://codecov.io/gh/stylers-llc/laravel-address/branch/master/graph/badge.svg)](https://codecov.io/gh/stylers-llc/laravel-address) 
[![Maintainability](https://api.codeclimate.com/v1/badges/16913f2a12f13f795cea/maintainability)](https://codeclimate.com/github/stylers-llc/laravel-address/maintainability)

## Laravel version compatibility
| Laravel version | Package version |
|-----------------|-----------------|
| 5.7             | 1.0             |
| 5.8             | 1.1             |
| 6.0             | 1.1             |
| 7.0             | 2.0             |
| 8.0             | 3.0             |
| 9.0             | 4.0             |

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
If the `$type` is exists then will be update with `$attributes`.
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
    "floor" => "42",
    "door" => "69",
    "latitude" => "47.5070738",
    "longitude" => "19.045599",
    "parcel_number" => "10086/0/A/3",
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
The `syncAddresses()` method delete all addressable address if `$type` is not exists in `$arrayOfAttributes[$type][]`.
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
        "floor" => "42",
        "door" => "69",
        "latitude" => "47.5070738",
        "longitude" => "19.045599",
        "parcel_number" => "10086/0/A/3",
    ]
];
$addresses = $user->syncAddresses($arrayOfAttributes); // Collection
```

## How to Test
```bash
$ docker run -it --rm -v $PWD:/app -w /app composer bash
$ composer install
$ ./vendor/bin/phpunit
```

### Troubleshooting
```bash
# Fatal error: Allowed memory size of...
$ COMPOSER_MEMORY_LIMIT=-1 composer install
```
