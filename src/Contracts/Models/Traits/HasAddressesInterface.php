<?php

namespace Stylers\Address\Contracts\Models\Traits;

use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface HasAddressesInterface
{
    public function addresses(): MorphMany;

    public function hasAddress(string $type = null): bool;

    public function updateOrCreateAddress(array $attributes, string $type = null): AddressInterface;

    public function deleteAddress(string $type = null): bool;

    public function syncAddresses(array $arrayOfAttributes): Collection;
}