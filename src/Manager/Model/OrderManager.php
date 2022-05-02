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

class OrderManager implements OrderManagerInterface
{
    private OrderRepositoryInterface $repo;
    private PrinterRepositoryInterface $printerRepo;
    private LoggerInterface $logger;
    private Serializer $serializer;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(OrderRepositoryInterface $repo,
                                PrinterRepositoryInterface $printerRepo,
                                LoggerInterface $logger,
                                Serializer $serializer,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->repo = $repo;
        $this->printerRepo = $printerRepo;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Create new Order
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
            $entity = new Order();
            $entity->setInfo($info)
                ->setAmount($amount)
                ->setPrinter($printer);
            $order = $this->repo->createEntity($entity);
            $this->logger->info('Create new order:' . $order->getId());

            $orderCreateEvent = new CreateOrderEvent($order);
            $this->eventDispatcher->dispatch($orderCreateEvent,$orderCreateEvent::NAME);

            return $order;
        } catch (EntityNotFoundException $ex) {
            throw new ManagerException("Printer $printerId not found");
        } catch (Exception $ex) {
            $this->logger->error("Error create order:" . $ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Get order list by printer
     *
     * @param int $printerId
     * @param int $page
     * @param int $limit
     *
     * @return Order[]
     * @throws ExceptionInterface
     */
    public function getOrderList(int $printerId, int $page, int $limit): array
    {
        $result = [];
        $offset = ($page == 1) ? 1 : ($page - 1) * $limit;

        $list = $this->repo->list($printerId, $limit, $offset);
        if (!empty($list)) {
            $fields = ["id", "amount", "printerId","info"];
            $callback = ["info" => function ($innner) {
                return json_decode($innner, true);
            }];
            foreach ($list as $data){
                $result[] = $this->serializer->normalize($data,null,$fields,$callback);
            }
        }

        return  $result;
    }
}
