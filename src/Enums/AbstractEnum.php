<?php

namespace Stylers\Address\Enums;

use Stylers\Address\Contracts\Enums\EnumInterface;
use \ReflectionClass;

abstract class AbstractEnum implements EnumInterface
{
    public static function getConstants(): array
    {
        $class = get_called_class();
        $reflection = new ReflectionClass($class);
        $constants = $reflection->getConstants();

        return array_sort($constants);
    }
}
