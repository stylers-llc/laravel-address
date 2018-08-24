<?php

namespace Stylers\Address\Contracts\Models\Traits;

use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * Interface HasAddressesInterface
 * @package Stylers\Address\Contracts\Models\Traits
 */
interface HasAddressesInterface
{
    /**
     * @return MorphMany
     */
    public function addresses(): MorphMany;

    /**
     * @param null|string $type
     * @return bool
     */
    public function hasAddress(string $type = null): bool;

    /**
     * @param array $attributes
     * @param null|string $type
     * @return AddressInterface
     */
    public function updateOrCreateAddress(array $attributes, string $type = null): AddressInterface;

    /**
     * @param null|string $type
     * @return bool
     * @throws \Exception|ModelNotFoundException
     */
    public function deleteAddress(string $type = null): bool;

    /**
     * @param array $arrayOfAttributes
     * @return Collection
     */
    public function syncAddresses(array $arrayOfAttributes): Collection;
}