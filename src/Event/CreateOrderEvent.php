<?php
namespace App\Event;

use App\Model\Entity\Order;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Creating check for order
 *
 * Class CreateCheckEvent
 *
 * @package App\Event
 */
class CreateOrderEvent extends Event
{
    /**
     * Event name.
     *
     * @var string
     */
    public const NAME = 'order.create';

    /**
     * Order
     *
     * @var Order
     */
    protected Order $order;

    /**
     * CreateOrderEvent constructor.
     *
     * @param Order $order
     */
    function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order entity
     *
     * @return Order
     */
    public function getOrder(): Order {
        return  $this->order;
    }
}
