<?php

declare(strict_types=1);

namespace App\Common\Persistence\Adapters;

use App\Common\Persistence\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository as ORMEntityRepository;

/**
 * @template T
 * @psalm-template T of object
 * @implements EntityRepository<T>
 */
final class EntityRepositoryDoctrine implements EntityRepository
{
    /**
     * @var ORMEntityRepository<T>
     */
    private readonly ORMEntityRepository $repo;

    /**
     * @psalm-param class-string<T> $entityName
     */
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly string $entityName
    ) {
        $this->repo = $em->getRepository($entityName);
    }

    public function all(): ArrayCollection
    {
        return new ArrayCollection($this->repo->findAll());
    }

    public function find(int $id): object|null
    {
        return $this->repo->find($id);
    }

    public function get(int $id): object
    {
        $entity = $this->find($id);
        if ($entity === null) {
            throw new \UnexpectedValueException("No existe entidad de tipo: {$this->entityName} con id: {$id}");
        }

        return $entity;
    }

    public function matching(Criteria $criteria): ArrayCollection
    {
        return new ArrayCollection(\array_values(
            $this->repo->matching($criteria)->toArray()
        ));
    }

    public function add(object $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
