<?php

declare(strict_types=1);

use Elie\PHPDI\Config\ContainerFactory;
use Framework\DependencyInjectionContainer\ConfigPHPDIContainer;
use Psr\Container\ContainerInterface;

// Protect variables from global scope
return (static function (): ContainerInterface {
    $config  = require __DIR__ . '/config.php';
    $factory = new ContainerFactory();

    return $factory(new ConfigPHPDIContainer($config));
})();
