<?php

namespace Stylers\Address\Models;

use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Address
 * @package Stylers\Address\Models
 */
class Address extends Model implements AddressInterface
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'zip_code',
        'city',
        'name_of_public_place',
        'type_of_public_place',
        'number_of_house',
        'type',
    ];

    /**
     * @return MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
