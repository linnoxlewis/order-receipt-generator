<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class Order
 *
 * @package App\Model\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks()
 */
class Order extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid",unique=true)
     */
    private string $id;

    /**
     * @ORM\Column(type="string",length=3000, nullable=false)
     *
     */
    private ?string $info;

    /**
     * @var int|null
     *
     * @ORM\Column(type="integer",nullable=false)
     */
    private ?int $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entity\Printer", inversedBy="orders")
     */
    private ?Printer $printer;

    /**
     * @ORM\OneToOne(targetEntity="App\Model\Entity\Check", inversedBy="check")
     */
    private ?Check $check;

    private int $printerId;
    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid6();
    }

    /**
     * Get printer Id.
     *
     * @return int
     */
    public function getPrinterId(): int
    {
        return $this->printerId;
    }

    /**
     * Set order Id.
     *
     * @param int $id printer id
     *
     * @return Order
     */
    public function setPrinterId(int $id): static
    {
        $this->printerId= $id;

        return $this;
    }

    /**
     * Get printer Id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set order Id.
     *
     * @param string $id printer id
     *
     * @return Order
     */
    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get order details.
     *
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * Set order details.
     *
     * @param string $value order details in json
     *
     * @return Order
     */
    public function setInfo(string $value): static
    {
        $this->info = $value;

        return $this;
    }

    /**
     * Get order total amount.
     *
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * Set order total amount.
     *
     * @param int $value order amount
     *
     * @return Order
     */
    public function setAmount(int $value): static
    {
        $this->amount = $value;

        return $this;
    }

    /**
     * Get printer.
     *
     * @return Printer|null
     */
    public function getPrinter(): ?Printer
    {
        return $this->printer;
    }

    /**
     * Set printer.
     *
     * @param Printer $value printer entity
     *
     * @return Order
     */
    public function setPrinter(Printer $value): static
    {
        $this->printer = $value;

        return $this;
    }

    /**
     * Get printer.
     *
     * @return Check|null
     */
    public function getCheck(): ?Check
    {
        return $this->check;
    }

    /**
     * Set printer.
     *
     * @param Check $value check entity
     *
     * @return Order
     */
    public function setCheck(Check $value): static
    {
        $this->check = $value;

        return $this;
    }
}
