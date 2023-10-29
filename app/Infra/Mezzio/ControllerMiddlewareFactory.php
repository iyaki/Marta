<?php

declare(strict_types=1);

namespace Marta\Infra\Mezzio;

use Psr\Container\ContainerInterface;

final readonly class ControllerMiddlewareFactory
{
    public function __construct(private ContainerInterface $container)
    {}

    public function create(string $controllerName, string $methodName): ControllerMiddleware
    {
        return new ControllerMiddleware($this->container, $controllerName, $methodName);
    }

}
