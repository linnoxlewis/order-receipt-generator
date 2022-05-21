<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Base entity.
 *
 * Class Entity.
 *
 * @package App\Model\Entity
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Entity implements EntityInterface
{
    /**
     * @ORM\Column(name="created_at",type="datetime",nullable=true)
     */
    protected ? \DateTime $createdAt = null;

    /**
     * @ORM\Column(name="updated_at",type="datetime",nullable=true)
     */
    protected ?\DateTime $updatedAt = null;

    /**
     * Get check create date.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt->format("Y-m-d H:i:s");
    }

    /**
     * Set create date
     *
     * @param \DateTimeImmutable $value
     *
     * @return static
     */
    public function setCreatedAt(\DateTimeImmutable $value): static
    {
        $this->createdAt = $value;

        return $this;
    }

    /**
     * Get check create date.
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set create date
     *
     * @param \DateTimeImmutable $value
     *
     * @return static
     */
    public function setUpdatedAt(\DateTimeImmutable $value): static
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
