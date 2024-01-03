<?php

namespace Tests\Unit\Models\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stylers\Address\Enums\AddressTypeEnum;
use Stylers\Address\Models\Address;
use Stylers\Address\Tests\Fixtures\Models\User;
use Stylers\Address\Tests\TestCase;

class HasAddressesTest extends TestCase
{
    /**
     * @test
     */
    public function get_addresses_relation()
    {
        $address = factory(Address::class)->make();
        $addressable = factory(User::class)->create();
        $addressable->addresses()->save($address);
        $addressable->refresh();
        $attachedAddress = $addressable->addresses()->first();

        $this->assertInstanceOf(Address::class, $attachedAddress);
    }

    /**
     * @test
     */
    public function it_can_create()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make()->toArray();
        $address = $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $this->assertDatabaseHas('addresses', $attributes);
        $this->assertEquals($addressable->id, $address->addressable_id);
        $this->assertEquals(get_class($addressable), $address->addressable_type);
    }

    /**
     * @test
     */
    public function it_can_create_when_type_is_null()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => null])->toArray();
        $address = $addressable->updateOrCreateAddress($attributes);

        $this->assertDatabaseHas('addresses', $attributes);
        $this->assertEquals($addressable->id, $address->addressable_id);
        $this->assertEquals(get_class($addressable), $address->addressable_type);
    }

    /**
     * @test
     */
    public function it_can_not_override_type_from_attributes()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => AddressTypeEnum::PRIMARY])->toArray();
        $type = AddressTypeEnum::BILLING;
        $address = $addressable->updateOrCreateAddress($attributes, $type);

        $this->assertEquals($type, $address->type);

        $attributes['type'] = $type;
        $this->assertDatabaseHas('addresses', $attributes);
        $this->assertEquals($addressable->id, $address->addressable_id);
        $this->assertEquals(get_class($addressable), $address->addressable_type);
    }

    /**
     * @test
     */
    public function it_can_update()
    {
        $addressable = factory(User::class)->create();

        $attributes = factory(Address::class)->make()->toArray();
        $address = $addressable->updateOrCreateAddress($attributes, $attributes['type']);
        
        $attributesUpdate = factory(Address::class)->make()->toArray();
        $addressUpdated = $addressable->updateOrCreateAddress($attributesUpdate, $attributes['type']);

        $attributesUpdate['type'] = $attributes['type'];
        $this->assertDatabaseHas('addresses', $attributesUpdate);
        $this->assertEquals($address->id, $addressUpdated->id);
        $this->assertEquals($addressable->id, $addressUpdated->addressable_id);
        $this->assertEquals(get_class($addressable), $addressUpdated->addressable_type);
    }

    /**
     * @test
     */
    public function has_address()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make()->toArray();
        $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $this->assertTrue($addressable->hasAddress($attributes['type']));
    }

    /**
     * @test
     */
    public function has_address_when_type_is_null()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => null])->toArray();
        $addressable->updateOrCreateAddress($attributes);

        $this->assertTrue($addressable->hasAddress());
    }

    /**
     * @test
     */
    public function has_not_address()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => AddressTypeEnum::BILLING])->toArray();
        $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $addressableOther = factory(User::class)->create();
        $attributesOther = factory(Address::class)->make(['type' => AddressTypeEnum::PRIMARY])->toArray();
        $addressableOther->updateOrCreateAddress($attributes, $attributesOther['type']);

        $this->assertFalse($addressable->hasAddress($attributesOther['type']));
    }

    /**
     * @test
     */
    public function it_can_delete()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make()->toArray();
        $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $response = $addressable->deleteAddress($attributes['type']);

        $this->assertDatabaseMissing('addresses', $attributes);
        $this->assertTrue($response);
    }

    /**
     * @test
     */
    public function it_can_delete_when_type_is_null()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => null])->toArray();
        $addressable->updateOrCreateAddress($attributes);

        $response = $addressable->deleteAddress();

        $this->assertDatabaseMissing('addresses', $attributes);
        $this->assertTrue($response);
    }

    /**
     * @test
     */
    public function it_can_not_delete()
    {
        $this->expectException(ModelNotFoundException::class);
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => AddressTypeEnum::BILLING])->toArray();
        $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $addressable->deleteAddress(AddressTypeEnum::PRIMARY);
    }

    /**
     * @test
     */
    public function it_can_sync()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make()->toArray();
        $type = AddressTypeEnum::BILLING;
        $address = $addressable->updateOrCreateAddress($attributes, $type);

        $attributesOfSync = [
            $type => factory(Address::class)->make(['type' => $type])->toArray()
        ];

        $addresses = $addressable->syncAddresses($attributesOfSync);

        $this->assertDatabaseHas('addresses', $attributesOfSync[$type]);
        $this->assertEquals(1, $addressable->addresses()->get()->count());
        $this->assertEquals(1, $addresses->count());
        $this->assertEquals($address->id, $addresses->first()->id);
        $this->assertEquals($addressable->id, $addresses->first()->addressable_id);
        $this->assertEquals(get_class($addressable), $addresses->first()->addressable_type);
    }

    /**
     * @test
     */
    public function it_can_sync_with_delete()
    {
        $addressable = factory(User::class)->create();

        $types = AddressTypeEnum::getConstants();
        foreach ($types as $type) {
            $attributes[$type] = factory(Address::class)->make(['type' => $type])->toArray();
            $addressable->updateOrCreateAddress($attributes, $type);
        }

        $typeSynced = AddressTypeEnum::BILLING;
        $attributesOfSync = [
            $typeSynced => factory(Address::class)->make(['type' => $typeSynced])->toArray()
        ];

        $addressable->syncAddresses($attributesOfSync);
        foreach ($types as $type) {
            $this->assertEquals($type == $typeSynced, $addressable->hasAddress($type));
        }
    }

    /**
     * @test
     */
    public function it_can_sync_with_create()
    {
        $addressable = factory(User::class)->create();
        $attributes = factory(Address::class)->make(['type' => AddressTypeEnum::BILLING])->toArray();
        $addressable->updateOrCreateAddress($attributes, $attributes['type']);

        $attributesOfSync = [
            $attributes['type'] => factory(Address::class)->make()->toArray(),
            AddressTypeEnum::PRIMARY => factory(Address::class)->make()->toArray(),
        ];

        $addressable->syncAddresses($attributesOfSync);
        $types = AddressTypeEnum::getConstants();
        foreach ($types as $type) {
            $this->assertEquals(array_key_exists($type, $attributesOfSync), $addressable->hasAddress($type));
        }
    }
}