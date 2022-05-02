<?php

namespace App\Repository;

use App\Model\Entity\Order;
use App\Repository\Interface\OrderRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Order repository model
 *
 * Class OrderRepository
 *
 * @package App\Repository
 */
class OrderRepository extends Repository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * Get order list by printer id
     *
     * @param int $printerId printer id
     * @param int $limit limit
     * @param int $offset offset
     *
     * @return Order[]
     */
    public function list(int $printerId, int $limit, int $offset): array
    {
        return $this->findBy(
            ['printerId' => $printerId],
            null,
            $limit,
            $offset
        );
    }
}
