<?php

namespace App\Model\Enum;

/**
 * Base class for enums model
 *
 * Class Enum
 *
 * @package App\Model\Enum
 */
abstract class Enum
{
    abstract public static function getList(): array;
}