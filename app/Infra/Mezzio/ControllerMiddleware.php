<?php

declare(strict_types=1);

namespace Marta\Infra\Mezzio;

use Marta\Presentation\Common\Controllers\ResourceControllerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @template Controller of object
 */
final readonly class ControllerMiddleware implements MiddlewareInterface
{
    public string $middlewareName;

    /**
     * @param class-string<Controller> $controller
     */
    public function __construct(
        private ContainerInterface $container,
        private string $controllerName,
        private string $methodName
    )
    {
        if (! \method_exists($controllerName, $methodName)) {
            throw new \InvalidArgumentException("Method {$methodName} does not exsists in {$controllerName}");
        }

        $this->middlewareName = $controllerName . '::' . $methodName;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return call_user_func(
            [
                $this->container->get($this->controllerName),
                $this->methodName
            ],
            $request
        );
    }


}
