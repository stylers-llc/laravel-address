<?php

namespace Tests\Unit\Models;

use Stylers\Address\Models\Address;
use Stylers\Address\Tests\Fixtures\Models\User;
use Stylers\Address\Tests\TestCase;

class AddressTest extends TestCase
{
    public function dataProvider()
    {
        return [
            [User::class],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @test
     * @param string $class
     */
    public function get_addressable_relation(string $class)
    {
        $addressable = factory($class)->create();
        $address = factory(Address::class)->make();
        $address->addressable()->associate($addressable);
        $address->save();
        $address->refresh();

        $this->assertEquals($class, get_class($address->addressable));
    }
}