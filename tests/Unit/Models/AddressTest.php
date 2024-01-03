<?php

namespace Tests\Unit\Models;

use Stylers\Address\Models\Address;
use Stylers\Address\Tests\Fixtures\Models\User;
use Stylers\Address\Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * @test
     */
    public function get_addressable_relation()
    {
        $addressable = factory(User::class)->create();
        $address = factory(Address::class)->make();
        $address->addressable()->associate($addressable);
        $address->save();
        $address->refresh();

        $this->assertEquals(User::class, get_class($address->addressable));
    }
}