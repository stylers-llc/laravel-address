<?php

namespace Stylers\Address\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stylers\Address\Contracts\Models\AddressInterface;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasAddresses
{
    public function addresses(): MorphMany
    {
        return $this->morphMany(app(AddressInterface::class), 'addressable');
    }

    public function hasAddress(string $type = null): bool
    {
        return (bool)$this->addresses()->where('type', $type)->first();
    }

    public function updateOrCreateAddress(array $attributes, string $type = null): AddressInterface
    {
        $attributes['type'] = $type;

        return $this->addresses()->updateOrCreate(['type' => $type], $attributes);
    }

    public function deleteAddress(string $type = null): bool
    {
        return $this->addresses()->where('type', $type)->firstOrFail()->delete();
    }

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