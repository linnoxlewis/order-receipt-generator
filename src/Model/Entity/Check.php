<?php

namespace App\Model\Entity;

use App\Model\Enum\CheckStatus;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class Check
 *
 * @package App\Model\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CheckRepository")
 * @ORM\Table(name="`check`")
 * @ORM\HasLifecycleCallbacks()
 */
class Check extends Entity
{
    /**
     * Check id
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid",unique=true)
     */
    private string $id;

    /**
     * Check status
     *
     * @var int
     *
     * @ORM\Column(type="integer",nullable=false,options={"default" : 0})
     */
    private int $status;

    /**
     * Order
     *
     * @var Order
     *
     * @ORM\OneToOne(targetEntity="App\Model\Entity\Order", inversedBy="order")
     */
    private Order $order;

    /**
     * Check constructor.
     *
     *
     */
    public function __construct()
    {
        $this->id = Uuid::uuid6();
    }

    /**
     * Get check Id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set check Id.
     *
     * @param string $id check id
     *
     * @return Check
     */
    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get check status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set order details.
     *
     * @param int $value check status
     *
     * @return Check
     */
    public function setStatus(int $value): static
    {
        $this->status = $value;

        return $this;
    }

    /**
     * Get order.
     *
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param Order $value order entity
     *
     * @return Check
     */
    public function setOrder(Order $value): static
    {
        $this->order = $value;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->status = CheckStatus::STATUS_NEW;
        parent::onPrePersist();
    }
}
