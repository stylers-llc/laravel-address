<?php

namespace Stylers\Address\Contracts\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface AddressInterface
{
    public function addressable(): MorphTo;
}