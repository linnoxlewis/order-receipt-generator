<?php

namespace App\Manager\Interface;

use App\Model\Entity\EntityInterface;

/**
 * Interface PrinterManagerInterface
 *
 * @package App\Manager\Interface
 */
interface PrinterManagerInterface
{
    public function addPrinter(string $name, string $type): EntityInterface;

    public function removePrinter(int $printerId): bool;

    public function getCompleteChecks(int $printerId): array;
}
