<?php

declare(strict_types=1);

namespace Marta\Domain\Shared;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\Common\Collections\Selectable;

/**
 * @template T of object
 */
interface EntityRepository
{
    /**
     * @return ArrayCollection<int<0, max>,T>
     */
    public function all(): ArrayCollection;

    /**
     * @return T|null
     */
    public function find(int $id): object|null;

    /**
     * @return T
     * @throws \UnexpectedValueException
     */
    public function get(int $id): object;

    /**
     * @return ArrayCollection<int<0, max>, T>
     */
    public function matching(Criteria $criteria): ArrayCollection;

    /**
     * @param T $entity
     */
    public function add(object $entity): void;
}
