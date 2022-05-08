<?php

namespace App\Repository;

use App\Model\Entity\Printer;
use App\Repository\Interface\PrinterRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Printer repository model
 *
 * Class PrinterRepository
 *
 * @package App\Repository
 */
class PrinterRepository extends Repository implements PrinterRepositoryInterface
{
    /**
     * PrinterRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Printer::class);
    }

    /**
     * Remove Printer
     *
     * @param int id printer Id
     *
     * @throws EntityNotFoundException
     * @return void
     */
    public function removePrinter(int $id): void
    {
        $printer = $this->getById($id);
        $this->_em->remove($printer);
        $this->_em->flush();
    }
}
