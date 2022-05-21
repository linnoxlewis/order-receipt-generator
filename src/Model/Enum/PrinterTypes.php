<?php

namespace App\Model\Enum;

/**
 * Enum printer`s types.
 *
 * Class PrinterTypes
 *
 * @package App\Model\Enum
 */
class PrinterTypes extends Enum
{
    /**
     * type client printer.
     *
     * @var string
     */
    const CLIENT_TYPE = 'client';

    /**
     * type kitchen printer.
     *
     * @var string
     */
    const KITCHEN_TYPE = 'kitchen';

    /**
     * Get types list.
     *
     * @return string[]
     */
    public static function getList(): array
    {
        return [
            static::CLIENT_TYPE,
            static::KITCHEN_TYPE
        ];
    }
}