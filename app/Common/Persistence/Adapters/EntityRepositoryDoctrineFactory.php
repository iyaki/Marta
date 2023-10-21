<?php

declare(strict_types=1);

namespace App\Common\Persistence\Adapters;

use App\Common\Persistence\EntityRepository;
use DI\Factory\RequestedEntry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

final class EntityRepositoryDoctrineFactory
{
    public function __invoke(EntityManagerInterface $em, RequestedEntry $entry): EntityRepositoryDoctrine
    {
        $matches = [];
        \preg_match($this->entryRegex(), $entry->getName(), $matches);

        $entity = $matches[1] ?? '';

        \assert(class_exists($entity));

        return new EntityRepositoryDoctrine($em, $entity);
    }

    /**
     * @psalm-return non-empty-string
     */
    private function entryRegex(): string
    {
        $repo = \str_replace('\\', '\\\\', EntityRepository::class);
        return "/{$repo}(.*)/";
    }
}
