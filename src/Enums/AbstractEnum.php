<?php

namespace Stylers\Address\Enums;

use Stylers\Address\Contracts\Enums\EnumInterface;
use \ReflectionClass;

/**
 * Class AbstractEnum
 * @package Stylers\Address\Enums
 */
abstract class AbstractEnum implements EnumInterface
{
    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getConstants(): array
    {
        $class = get_called_class();
        $reflection = new ReflectionClass($class);
        $constants = $reflection->getConstants();

        return array_sort($constants);
    }
}
