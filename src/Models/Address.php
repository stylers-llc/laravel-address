<?php

namespace Stylers\Address\Models;

use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model implements AddressInterface
{
    protected $fillable = [
        'country',
        'country_code',
        'zip_code',
        'city',
        'name_of_public_place',
        'type_of_public_place',
        'number_of_house',
        'floor',
        'door',
        'latitude',
        'longitude',
        'parcel_number',
        'description',
        'type',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
