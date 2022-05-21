<?php

namespace App\Repository;

use App\Model\Entity\Printer;
use App\Repository\Interface\PrinterRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

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
     * Remove Printer
     *
     * @param int id printer Id
     *
     * @return void
     * @throws EntityNotFoundException
     */
    public function removePrinter(int $id): void
    {
        $printer = $this->getById($id);
        $this->_em->remove($printer);
        $this->_em->flush();
    }

    /**
     * Get entity class.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Printer::class;
    }
}
