<?php
namespace App\EventSubscriber;

use App\Event\CreateOrderEvent;
use App\Message\PrintingCheck;
use App\Model\Entity\Check;
use App\Repository\Interface\CheckRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Order subscriber - create check when order was created.
 *
 * Class OrderSubscriber
 *
 * @package App\EventSubscriber
 */
class OrderSubscriber implements EventSubscriberInterface
{
    /**
     * Check repository.
     *
     * @var CheckRepositoryInterface
     */
    private CheckRepositoryInterface $checkRepository;

    /**
     * Logger.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Queue message.
     *
     * @var MessageBusInterface
     */
    private MessageBusInterface $messageBus;

    /**
     * OrderSubscriber constructor.
     *
     * @param CheckRepositoryInterface $checkRepository
     * @param LoggerInterface $logger
     * @param MessageBusInterface $messageBus
     */
    public function __construct(CheckRepositoryInterface $checkRepository,
                                LoggerInterface $logger,
                                MessageBusInterface $messageBus,
    )
    {
        $this->checkRepository = $checkRepository;
        $this->logger = $logger;
        $this->messageBus = $messageBus;
    }

    /**
     * Get events list.
     *
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            CreateOrderEvent::NAME => 'createCheck'
        ];
    }

    /**
     * Create check when order was created.
     *
     * @param CreateOrderEvent $event
     */
    public function createCheck(CreateOrderEvent $event)
    {
        try {
            $order = $event->getOrder();
            $check = new Check($order);
            $this->checkRepository->createEntity($check);
            $this->logger->info('Create check' . $check->getId()
                . 'for order' . $order->getId());
            $this->messageBus->dispatch(new PrintingCheck($check));
        } catch (\Throwable $ex) {
            $this->logger->error('Error creating check: ' . $ex->getMessage());
        }
    }
}
