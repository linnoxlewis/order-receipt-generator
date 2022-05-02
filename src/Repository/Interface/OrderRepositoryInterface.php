<?php

namespace App\Repository\Interface;

/**
 * Interface OrderRepositoryInterface
 *
 * @package App\Repository
 */
interface OrderRepositoryInterface extends BaseInterface
{
    public function list(int $printerId, int $limit, int $offset): array;
}