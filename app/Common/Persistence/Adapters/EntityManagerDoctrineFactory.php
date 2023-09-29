<?php

declare(strict_types=1);

namespace App\Common\Persistence\Adapters;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

final class EntityManagerDoctrineFactory
{
    public function __invoke(ContainerInterface $container): EntityManager
    {
        $configData = $container->get('config');
        $configDoctrine = $configData['doctrine'];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $configDoctrine['entitiesPaths'] ?? [],
            isDevMode: $configData['debug'] ?? false,
            reportFieldsWhereDeclared: true
        );
        $config->setDefaultRepositoryClassName(EntityRepositoryDoctrine::class);

        /** @psalm-var array{driver: string, host: sring, user: string, password: string, dbname: string}|null */
        $params = $configDoctrine['connection']['params'] ?? null;

        \assert($params !== null);

        $connection = DriverManager::getConnection($params);

        return new EntityManager($connection, $config);
    }
}
