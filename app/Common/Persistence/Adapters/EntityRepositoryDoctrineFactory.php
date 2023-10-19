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

        $entity = $matches[1] ?? null;

        return $em->getRepository($entity);
    }

    private function entryRegex(): string
    {
        $repo = \str_replace('\\', '\\\\', EntityRepository::class);
        return "/{$repo}(.*)/";
    }
}
