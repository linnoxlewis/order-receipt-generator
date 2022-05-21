<?php

namespace App\Repository;

use App\Model\Entity\Entity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Log\LoggerInterface;

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
    public function getById(string|int $id): object
    {
        try {
            var_dump("ID:" . $id);
            $entity = $this->_em->find($this->getEntityName(), $id);
            if (empty($entity)) {
                throw new EntityNotFoundException("Entity not found");
            }
            var_dump($entity->getId());
            return $entity;
        } catch (\Throwable $ex) {
            throw new \Exception("Ex:" . $ex);
        }
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
