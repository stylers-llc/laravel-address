<?php

namespace Stylers\Address\Enums;

/**
 * Class AddressTypeEnum
 * @package Stylers\Address\Enums
 */
abstract class AddressTypeEnum extends AbstractEnum
{
    const PRIMARY = "primary";
    const MAILING = "mailing";
    const BILLING = "billing";
}