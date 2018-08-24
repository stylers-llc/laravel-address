<?php

use Faker\Generator as Faker;
use Stylers\Address\Models\Address;
use Stylers\Address\Enums\AddressTypeEnum;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Address::class, function (Faker $faker) {
    return [
        'type' => array_random(AddressTypeEnum::getConstants()),
        'country' => $faker->country,
        'zip_code' => $faker->postcode,
        'city' => $faker->city,
        'name_of_public_place' => $faker->streetName,
        'type_of_public_place' => 'street',
        'number_of_house' => $faker->randomNumber(),
    ];
});
