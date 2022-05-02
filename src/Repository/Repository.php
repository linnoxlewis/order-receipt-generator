<?php

namespace App\Repository;

use App\Model\Entity\Entity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Check repository model
 *
 * Class CheckRepository
 *
 * @package App\Repository
 */
abstract class Repository extends ServiceEntityRepository
{
    /**
     * Get entity by id
     *
     * @param int|string $id entity id
     *
     * @return object
     *
     * @throws EntityNotFoundException
     */
    public function getById(int|string $id): object
    {
        $entity = $this->_em->find($this->getEntityName(), $id);
        if (empty($entity)) {
            throw new EntityNotFoundException("Entity not found");
        }

        return $entity;
    }

    /**
     * Create entity model
     *
     * @param Entity $entity model
     *
     * @return Entity
     */
    public function createEntity(Entity $entity): Entity
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }
}
