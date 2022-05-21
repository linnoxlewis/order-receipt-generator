<?php

namespace App\Consumer;

use App\Model\Entity\Order;
use App\Model\Enum\CheckStatus;
use App\Repository\Interface\CheckRepositoryInterface;
use App\Service\Convertator\Interface\ConvertInterface;
use App\Service\HtmlGenerator\Interface\HtmlGeneratorInterface;
use Psr\Log\LoggerInterface;
use App\Message\PrintingCheck;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class PrintingCheckHandler
 *
 * @package App\Message
 */
class PrintingCheckHandler implements MessageHandlerInterface
{
    /**
     * Check repository.
     *
     * @var CheckRepositoryInterface
     */
    private CheckRepositoryInterface $repo;

    /**
     * Logger component.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Html generator service.
     *
     * @var HtmlGeneratorInterface
     */
    private HtmlGeneratorInterface $htmlGenerator;

    /**
     * Convert pdf service.
     *
     * @var ConvertInterface
     */
    private ConvertInterface $convert;

    /**
     * PrintingCheckHandler constructor.
     *
     * @param CheckRepositoryInterface $repo
     * @param LoggerInterface $logger
     * @param HtmlGeneratorInterface $htmlGenerator
     * @param ConvertInterface $convert
     */
    public function __construct(CheckRepositoryInterface $repo,
                                LoggerInterface          $logger,
                                HtmlGeneratorInterface   $htmlGenerator,
                                ConvertInterface         $convert)
    {
        $this->logger = $logger;
        $this->repo = $repo;
        $this->htmlGenerator = $htmlGenerator;
        $this->convert = $convert;
    }

    /**
     * Create check.
     *
     * @param PrintingCheck $check
     */
    public function __invoke(PrintingCheck $check)
    {
        try {
            $this->logger->info('Start printing check');
            $id = $check->getCheckId();
            $checkEntity = $this->repo->getById($id);

            if (empty($checkEntity) || $checkEntity->getStatus() != CheckStatus::STATUS_NEW) {
                throw new \Exception('Invalid check ' . $id);
            }
            //TODO: BEGIN transaction
            $this->repo->updateCheckStatus(CheckStatus::STATUS_PRINTING_IN_PROCESS, $id);

            $this->createPdf($checkEntity->getOrder());

            $this->repo->updateCheckStatus(CheckStatus::STATUS_PRINTING_DONE, $id);
            $this->logger->info("Printing check id done");
        } catch (\Throwable $ex) {
            $this->logger->error('Printing check error:' . $ex->getMessage());

            echo $ex->getMessage();
        }
    }

    /**
     * Create pdf file.
     *
     * @param Order $order Order Model.
     *
     * @return void
     */
    private function createPdf(Order $order): void
    {
        $htmlCheck = $this->htmlGenerator
            ->setOrder($order)
            ->parseOrderToHtml();

        $this->convert
            ->setData($htmlCheck)
            ->toPdf($order->getId());
    }
}
