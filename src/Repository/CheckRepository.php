<?php

namespace App\Repository;

use App\Model\Entity\Check;
use App\Model\Enum\CheckStatus;
use App\Repository\Interface\CheckRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * Check repository model
 *
 * Class CheckRepository
 *
 * @package App\Repository
 */
class CheckRepository extends Repository implements CheckRepositoryInterface
{
    /**
     * CheckRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Check::class);
    }

    /**
     * Update check status
     *
     * @param int $status
     * @param $id
     *
     * @return bool
     * @throws EntityNotFoundException
     */
    public function updateCheckStatus(int $status, $id): bool
    {
        $check = $this->getById($id);

        $check->setStatus($status);
        $this->_em->flush();

        return true;
    }

    /**
     * Get completed check for printer
     *
     * @param int $printerId
     *
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function getCompletedChecksForPrinter(int $printerId): array
    {
        $sql = 'SELECT ch.id as check_id,o.id as order_id FROM "order" AS o  
                    INNER JOIN  "check" AS ch ON o.id = ch.order_id
                WHERE o.printer_id = :printerId AND ch.status = :status';

        $conn = $this->_em->getConnection();

        return $conn->prepare($sql)
            ->executeQuery([
                'printerId' => $printerId,
                'status' => CheckStatus::STATUS_PRINTING_DONE
            ])->fetchAllAssociative();
    }
}
