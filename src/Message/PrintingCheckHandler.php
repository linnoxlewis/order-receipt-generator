<?php
namespace App\Message;

use App\Model\Enum\CheckStatus;
use App\Repository\Interface\CheckRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class PrintingCheckHandler
 *
 * @package App\Message
 */
class PrintingCheckHandler implements MessageHandlerInterface
{
    private CheckRepositoryInterface $repo;

    private LoggerInterface $logger;

    /**
     * PrintingCheckHandler constructor.
     *
     * @param CheckRepositoryInterface $repo
     * @param LoggerInterface $logger
     */
    public function __construct(CheckRepositoryInterface $repo,
                                LoggerInterface $logger){
        $this->logger = $logger;
        $this->repo = $repo;

    }

    /**
     * Create check
     *
     * @param PrintingCheck $check
     */
   public function __invoke(PrintingCheck $check) {
       try {
           $this->logger->info('Start printing check');

           $id = $check->getCheckId();
           $check = $this->repo->getById($id);
           if (empty($check) || $check->getStatus() != CheckStatus::STATUS_NEW) {
               throw new \Exception('Invalid check '. $id);
           }

           $this->repo->updateCheckStatus(CheckStatus::STATUS_PRINTING_IN_PROCESS,$id);

           //TODO:логика печати
           $this->logger->info("Printing check id done");
           $this->repo->updateCheckStatus(CheckStatus::STATUS_PRINTING_DONE,$id);
       } catch (\Throwable $ex) {
           $this->logger->error('Creating check error:' . $ex->getMessage());

           echo $ex->getMessage();
       }

   }
}
