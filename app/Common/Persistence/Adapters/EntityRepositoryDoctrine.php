<?php

declare(strict_types=1);

namespace App\Common\Persistence\Adapters;

use App\Common\Persistence\EntityRepository as PersistenceEntityRepository;
use Doctrine\ORM\EntityRepository;

final class EntityRepositoryDoctrine extends EntityRepository implements PersistenceEntityRepository
{
    public function add(Object $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function get(int $id): object
    {
        $entity = $this->find($id);
        if ($entity === null) {
            throw new \UnexpectedValueException("No existe entidad de tipo: {$this->_entityName} con id: {$id}");
        }

        return $entity;
    }
}
