<?php

namespace App\Repository;

use App\Model\Entity\Entity;
use App\Model\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Check repository model.
 *
 * Class CheckRepository
 *
 * @package App\Repository
 */
abstract class Repository extends ServiceEntityRepository
{
    /**
     * CheckRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());
    }

    /**
     * Get entity by id.
     *
     * @param int|string $id entity id
     *
     * @return object
     *
     * @throws EntityNotFoundException|\Exception
     */
    public function getById(string|int $id): object
    {
        $entity = $this->_em->find($this->getEntityName(), $id);
        if (empty($entity)) {
            throw new EntityNotFoundException("Entity not found");
        }

        return $entity;
    }

    /**
     * Create entity model.
     *
     * @param Entity $entity model
     *
     * @return Entity
     */
    public
    function createEntity(EntityInterface $entity): Entity
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    /**
     * Get entity class.
     *
     * @return string
     */
    abstract protected function getEntityClass(): string;
}
