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
        $paths = [
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $paths,
            isDevMode: $container->get('config')['debug'] ?? false,
            reportFieldsWhereDeclared: true
        );

        /** @psalm-var array{driver: string, host: sring, user: string, password: string, dbname: string}|null */
        $params = $container->get('config')['doctrine']['connection']['params'] ?? null;
        ;

        \assert($params !== null);

        $connection = DriverManager::getConnection($params);

        return new EntityManager($connection, $config);
    }
}
