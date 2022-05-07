<?php

namespace App\Repository\Interface;

/**
 * Interface OrderRepositoryInterface.
 *
 * @package App\Repository
 */
interface OrderRepositoryInterface extends BaseInterface
{
    public function list($printer, int $limit, int $offset): array;
}