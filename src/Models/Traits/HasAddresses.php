<?php

namespace Stylers\Address\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasAddresses
{
    /**
     * @return MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(app(AddressInterface::class), 'addressable');
    }

    /**
     * @param string|null $type
     * @return bool
     */
    public function hasAddress(string $type = null): bool
    {
        return (bool)$this->addresses()->where('type', $type)->first();
    }


    /**
     * @param array $attributes
     * @param string|null $type
     * @return AddressInterface|Model
     */
    public function updateOrCreateAddress(array $attributes, string $type = null): AddressInterface
    {
        $attributes['type'] = $type;
        return $this->addresses()->updateOrCreate(['type' => $type], $attributes);
    }


    /**
     * @param string|null $type
     * @return bool
     * @throws \Exception|ModelNotFoundException
     */
    public function deleteAddress(string $type = null): bool
    {
        return $this->addresses()->where('type', $type)->firstOrFail()->delete();
    }

    /**
     * @param array $arrayOfAttributes
     * @return Collection
     */
    public function syncAddresses(array $arrayOfAttributes): Collection
    {
        $collection = new Collection();
        foreach ($arrayOfAttributes as $type => $attributes) {
            $address = $this->updateOrCreateAddress($attributes, $type);
            $collection->push($address);
        }

        $ids = $collection->pluck('id')->toArray();
        $this->addresses()->whereNotIn('id', $ids)->each(function ($address) {
            $address->delete();
        });

        return $collection;
    }
}