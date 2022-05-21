<?php

namespace App\Model\Entity;

use App\Helper\EncryptHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Printer model
 *
 * @ORM\Entity(repositoryClass="App\Repository\PrinterRepository")
 * @ORM\Table(name="`printer`")
 * @ORM\HasLifecycleCallbacks()
 */
class Printer extends Entity implements EntityInterface
{
    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255,nullable=false,unique=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string",length=255,nullable=false)
     */
    private ?string $type;

    /**
     * @ORM\Column(name="api_key",type="string",length=255,nullable=false,unique=true)
     */
    private ?string $apiKey = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Entity\Order", mappedBy="printer")
     */
    private Collection $orders;

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * Get printer Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set printer Id.
     *
     * @param int id printer id
     *
     * @return Printer
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get printer name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set printer Id.
     *
     * @param string name printer name
     *
     * @return Printer
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get printer api key.
     *
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * Set api key
     *
     * @param string $value api key
     *
     * @return $this
     */
    public function setApiKey(string $value)
    {
        $this->apiKey = $value;
        return $this;
    }

    /**
     * Get printer Type.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set printer Id.
     *
     * @param string type printer type
     *
     * @return Printer
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Encrypt apiKey.
     *
     * @ORM\PrePersist
     */
    public function beforeSave()
    {
        $this->setApiKey(EncryptHelper::encryptKey());
    }
}
