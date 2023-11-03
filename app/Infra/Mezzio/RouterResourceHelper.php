<?php

declare(strict_types=1);

namespace Marta\Infra\Mezzio;

use Marta\Presentation\Common\Controllers\ResourceControllerInterface;
use Mezzio\Application;

final readonly class RouterResourceHelper
{
    public function __construct(
        private Application $app,
        private ControllerMiddlewareFactory $controllerHelper
    ) {}

    /**
     * @param class-string<ResourceControllerInterface> $controllerName
     */
    public function __invoke(string $controllerName): void
    {
        $this->app->get(
            $controllerName::ROUTE_BASE,
            $this->controllerHelper->create($controllerName, ResourceControllerInterface::INDICE),
            $controllerName::INDICE
        );
        $this->app->get(
            $controllerName::ROUTE_BASE . '/nuevo',
            $this->controllerHelper->create($controllerName, ResourceControllerInterface::NUEVO),
            $controllerName::NUEVO
        );
        $this->app->post(
            $controllerName::ROUTE_BASE,
            $this->controllerHelper->create($controllerName, ResourceControllerInterface::CREAR),
            $controllerName::CREAR
        );
        $this->app->get(
            $controllerName::ROUTE_BASE . '/{id:\d+}/edicion',
            $this->controllerHelper->create($controllerName, ResourceControllerInterface::EDICION),
            $controllerName::EDICION
        );
        // TODO: Convertir este POST en un PUT
        $this->app->put(
            $controllerName::ROUTE_BASE . '/{id:\d+}',
            $this->controllerHelper->create($controllerName, ResourceControllerInterface::ACTUALIZAR),
            $controllerName::ACTUALIZAR
        );
        // $this->app->delete($controller::ROUTE_BASE . '/destruir', $controller::DESTRUIR);
    }
}
