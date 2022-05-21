<?php

namespace App\Repository\Interface;

use App\Model\Entity\Entity;

/**
 * Interface BaseInterface
 *
 * @package App\Repository\Interface
 */
interface BaseInterface
{
    public function getById(string|int $id): object;

    public function createEntity(Entity $entity): Entity;
}