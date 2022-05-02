<?php
namespace App\Manager\Model;

use App\Manager\Interface\PrinterManagerInterface;
use App\Manager\Exception\ManagerException;
use App\Model\Entity\Printer;
use App\Repository\Interface\CheckRepositoryInterface;
use App\Repository\Interface\PrinterRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use \App\Model\Entity\Entity;

/**
 * Manager for work to Printer
 *
 * Class PrinterManager
 *
 * @package App\Manager\Model
 */
class PrinterManager implements PrinterManagerInterface
{
    /**
     * Interface repository
     *
     * @var PrinterRepositoryInterface
     */
    private PrinterRepositoryInterface $repo;

    /**
     * Interface check repository
     *
     * @var CheckRepositoryInterface
     */
    private CheckRepositoryInterface $checkRepo;

    /**
     * Logger component
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * PrinterManager constructor.
     *
     * @param PrinterRepositoryInterface $repo
     * @param CheckRepositoryInterface $checkRepo
     * @param LoggerInterface $logger
     */
    public function __construct(PrinterRepositoryInterface $repo,
                                CheckRepositoryInterface $checkRepo,
                                LoggerInterface $logger)
    {
        $this->repo = $repo;
        $this->checkRepo = $checkRepo;
        $this->logger = $logger;
    }

    /**
     * Create new Printer
     *
     * @param string $name printer name
     * @param string $type printer type
     *
     * @return Entity
     * @throws \Exception
     */
    public function addPrinter(string $name, string $type): Entity
    {
        $entity = new Printer();
        $entity->setName($name)->setType($type);
        try {
            $printer = $this->repo->createEntity($entity);
            $this->logger->info('Create new printer:' . $printer->getId());

            return $printer;
        } catch (\Exception $ex) {
            $this->logger->error("Error create Printer $name:" . $ex->getMessage());
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Remove printer
     *
     * @param int $printerId
     *
     * @return bool
     * @throws ManagerException
     */
    public function removePrinter(int $printerId): bool
    {
        try {
            $this->repo->removePrinter($printerId);
            $this->logger->info("Printer $printerId was deleted");

            return true;
        } catch (EntityNotFoundException $ex) {
            throw new ManagerException($ex->getMessage());
        } catch (\Throwable $ex) {
            $this->logger->error("Delete printer $printerId error:" . $ex->getMessage());
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * Get completed checks
     *
     * @param int $printerId
     *
     * @return array
     * @throws \Exception
     */
    public function getCompleteChecks(int $printerId): array {
        try {
           return $this->checkRepo->getCompletedChecksForPrinter($printerId);
        } catch (\Throwable $ex) {
            $this->logger->error("Get $printerId checks error:" . $ex->getMessage());
            throw new \Exception($ex->getMessage());
        }
    }
}
