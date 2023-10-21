<?php

declare(strict_types=1);

namespace Marta\Infra\Shared;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

/**
 * @psalm-import-type Params from DriverManager
 */
final class EntityManagerDoctrineFactory
{
    public function __invoke(ContainerInterface $container): EntityManager
    {
        /**
         * @psalm-var array{
         *  debug?: bool,
         *  doctrine?: array{
         *      entitiesPaths?: array<array-key, string>,
         *      connection?: array{params?: Params}
         *  }
         * } */
        $configData = $container->get('config');
        $configDoctrine = $configData['doctrine'] ?? [];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $configDoctrine['entitiesPaths'] ?? [],
            isDevMode: $configData['debug'] ?? false,
            reportFieldsWhereDeclared: true
        );
        // $config->setDefaultRepositoryClassName(EntityRepositoryDoctrine::class);

        $params = $configDoctrine['connection']['params'] ?? null;

        \assert($params !== null);

        $connection = DriverManager::getConnection($params);

        return new EntityManager($connection, $config);
    }
}
