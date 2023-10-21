<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Elie\PHPDI\Config\ContainerFactory;
use Psr\Container\ContainerInterface;
use Elie\PHPDI\Config\Config;

// Protect variables from global scope
return (static function (): ContainerInterface {
    $config = require __DIR__ . '/config.php';
    $factory = new ContainerFactory();

    return $factory(new class($config) extends Config {
        public function configureContainer(ContainerBuilder $builder): void
        {
            parent::configureContainer($builder);

            $builder->useAttributes(true);
        }
    });
})();
