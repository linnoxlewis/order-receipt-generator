<?php

namespace App\Repository\Interface;

/**
 * Interface CheckInterface
 *
 * @package App\Repository\Interface
 */
interface CheckRepositoryInterface extends BaseInterface
{
    public function updateCheckStatus(int $status, $id): bool;

    public function getCompletedChecksForPrinter(int $printerId): array;
}