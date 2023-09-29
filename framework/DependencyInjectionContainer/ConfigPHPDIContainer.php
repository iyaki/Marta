<?php

declare(strict_types=1);

namespace Framework\DependencyInjectionContainer;

use DI\ContainerBuilder;
use Elie\PHPDI\Config\Config;

final class ConfigPHPDIContainer extends Config
{
    public function configureContainer(ContainerBuilder $builder): void
    {
        parent::configureContainer($builder);

        $builder->useAttributes(true);
    }

    /**
     * @codeCoverageIgnore
     */
    public function __clone()
    {
        throw new \Exception('Cloning this class is not allowed');
    }

    /**
     * @codeCoverageIgnore
     */
    public function __sleep()
    {
        throw new \Exception('This class can\'t be serialized');
    }
}
