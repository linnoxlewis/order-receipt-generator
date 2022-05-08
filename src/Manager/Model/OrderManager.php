<?php

namespace App\Manager\Model;

use App\Event\CreateOrderEvent;
use App\Manager\Exception\ManagerException;
use App\Manager\Interface\OrderManagerInterface;
use App\Model\Entity\Entity;
use App\Model\Entity\Order;
use App\Repository\Interface\OrderRepositoryInterface;
use App\Repository\Interface\PrinterRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Psr\Log\LoggerInterface;
use App\Service\Serializer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Manager for orders.
 *
 * Class OrderManager.
 *
 * @package App\Manager\Model
 */
class OrderManager implements OrderManagerInterface
{
    /**
     * Order repository.
     *
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $repo;

    /**
     * Printer repository.
     *
     * @var PrinterRepositoryInterface
     */
    private PrinterRepositoryInterface $printerRepo;

    /**
     * Logger.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Serializer service.
     *
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * Event creating check after order was created.
     *
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * OrderManager constructor.
     *
     * @param OrderRepositoryInterface $repo
     * @param PrinterRepositoryInterface $printerRepo
     * @param LoggerInterface $logger
     * @param Serializer $serializer
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(OrderRepositoryInterface $repo,
                                PrinterRepositoryInterface $printerRepo,
                                LoggerInterface $logger,
                                Serializer $serializer,
                                EventDispatcherInterface $eventDispatcher
    )
    {
        $this->repo = $repo;
        $this->printerRepo = $printerRepo;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Create new Order.
     *
     * @param string $info
     * @param int $amount
     * @param int $printerId
     *
     * @return Entity
     * @throws Exception
     * @throws ManagerException
     */
    public function createOrder(string $info, int $amount, int $printerId): Entity
    {
        try {
            $printer = $this->printerRepo->getById($printerId);
            if (empty($printer)) {
                throw new ManagerException("Printer not found");
            }

            $entity = new Order();
            $entity->setInfo($info)
                ->setAmount($amount)
                ->setPrinter($printer);

            $order = $this->repo->createEntity($entity);
            $this->logger->info('Create new order:' . $order->getId());

            $orderCreateEvent = new CreateOrderEvent($order);
            $this->eventDispatcher->dispatch($orderCreateEvent, $orderCreateEvent::NAME);

            return $order;
        } catch (EntityNotFoundException $ex) {
            throw new ManagerException("Printer $printerId not found");
        } catch (Exception $ex) {
            $this->logger->error("Error create order:" . $ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Get order list by printer.
     *
     * @param int $printerId id printer.
     * @param int $page      current page.
     * @param int $limit     max limit view value.
     *
     * @return Order[]
     * @throws ExceptionInterface|ManagerException
     */
    public function getOrderList(int $printerId, int $page, int $limit): array
    {
        $offset = ($page == 1) ? 1 : ($page - 1) * $limit;
        $printer = $this->printerRepo->getById($printerId);
        if (empty($printer)) {
            throw new ManagerException("Printer not found");
        }
        $list = $this->repo->list($printer, $limit, $offset);

        return (empty($list)) ? [] : $this->serializeList($list);
    }

    /**
     * Serialize order list to array.
     *
     * @param $list
     *
     * @return array
     * @throws ExceptionInterface
     */
    protected function serializeList($list): array
    {
        $result = [];
        $fields = ["id", "amount", "printerId", "info"];
        $callback = ["info" => function ($innner) {
            return json_decode($innner, true);
        }];
        foreach ($list as $data) {
            $result[] = $this->serializer->normalize($data, null, $fields, $callback);
        }

        return $result;
    }
}
