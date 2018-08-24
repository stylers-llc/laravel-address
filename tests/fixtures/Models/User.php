<?php

namespace Stylers\Address\Tests\Fixtures\Models;

use Stylers\Address\Contracts\Models\Traits\HasAddressesInterface;
use Stylers\Address\Models\Traits\HasAddresses;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package Stylers\Address\Tests\Fixtures\Models
 */
class User extends Authenticatable implements HasAddressesInterface
{
    use HasAddresses;
}
