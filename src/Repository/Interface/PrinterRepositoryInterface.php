<?php
namespace App\Repository\Interface;

/**
 * Interface PrinterRepositoryInterface
 *
 * @package App\Repository\Interface
 */
interface PrinterRepositoryInterface extends BaseInterface
{
    public function removePrinter(int $id): void;
}