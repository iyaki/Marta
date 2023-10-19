<?php

declare(strict_types=1);

namespace App\Common\Persistence;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;

/**
 * @template-covaraint T of object
 */
interface EntityRepository extends Selectable
{
    /**
     * @psalm-return list<T>.
     */
    public function findAll();

    /**
     * @return object|null
     * @psalm-return ?T
     */
    public function find($id);

    /**
     * @psalm-return T
     * @throws \UnexpectedValueException
     */
    public function get(int $id): object;

    /**
     * @return \Doctrine\Common\Collections\ReadableCollection<mixed>&\Doctrine\Common\Collections\Selectable<mixed>
     * @psalm-return \Doctrine\Common\Collections\ReadableCollection<TKey,T>&\Doctrine\Common\Collections\Selectable<TKey,T>
     */
    // public function matching(Criteria $criteria);

    /**
     * @psalm-param T
     */
    public function add(object $entity): void;
}
