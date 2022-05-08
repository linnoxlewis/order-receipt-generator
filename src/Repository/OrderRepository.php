<?php

namespace App\Repository;

use App\Model\Entity\Order;
use App\Model\Entity\Printer;
use App\Repository\Interface\OrderRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Order repository model.
 *
 * Class OrderRepository
 *
 * @package App\Repository
 */
class OrderRepository extends Repository implements OrderRepositoryInterface
{
    /**
     * OrderRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * Get order list by printer id.
     *
     * @param Printer $printer printer model
     * @param int     $limit limit
     * @param int     $offset offset
     *
     * @return Order[]
     */
    public function list($printer, int $limit, int $offset): array
    {
       return $this->findBy(
            ['printer' => $printer],
            null,
           $limit,
           $offset -1
        );
    }
}
