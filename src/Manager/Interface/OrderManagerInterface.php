<?php

namespace App\Manager\Interface;

use App\Model\Entity\Entity;

/**
 * Interface OrderManagerInterface
 *
 * @package App\Manager\Interface
 */
interface OrderManagerInterface
{
    public function createOrder(string $info, int $amount, int $printerId): Entity;

    public function getOrderList(int $printerId, int $page, int $limit): array;
}
