<?php


namespace Stylers\Address\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Interface AddressInterface
 * @package Stylers\Address\Contracts\Models
 */
interface AddressInterface
{
    /**
     * @return MorphTo
     */
    public function addressable(): MorphTo;
}