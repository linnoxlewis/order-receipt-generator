<?php

namespace App\Model\Enum;

/**
 * Check statuses class
 *
 * Class CheckStatus
 *
 * @package App\Model\Enum
 */
class CheckStatus extends Enum
{
    /**
     * Check is new.
     *
     * @var int
     */
    const STATUS_NEW = 0;

    /**
     * Print check in process.
     *
     * @var int
     */
    const STATUS_PRINTING_IN_PROCESS = 1;

    /**
     * Print check is done.
     *
     * @var int
     */
   public const STATUS_PRINTING_DONE = 2;

    /**
     * Get types list
     *
     * @return int[]
     */
    public static function getList(): array
    {
        return [
            static::STATUS_NEW,
            static::STATUS_PRINTING_IN_PROCESS,
            static::STATUS_PRINTING_DONE
        ];
    }
}
