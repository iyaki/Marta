<?php

declare(strict_types=1);

namespace MartaDev\Clockwork;

use Clockwork\DataSource\DataSource;
use Clockwork\Request\Request;
use Mezzio\Application;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Middleware\LazyLoadingMiddleware;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ServerRequestInterface;
use rectObj;

final class MezzioExtrasDataSource extends DataSource
{
    public function __construct(
        private readonly ServerRequestInterface $psrRequest,
        private readonly Application $app
    )
    {}

    public function resolve(Request $request)
    {
        /** @var RouteResult $routeResult */
        $routeResult = $this->psrRequest->getAttribute(RouteResult::class);
        $matchedRoute = $routeResult->getMatchedRoute();
        $middleware = $matchedRoute->getMiddleware();

        if ($middleware instanceof LazyLoadingMiddleware) {
            $request->controller = $middleware->middlewareName;

        }

        $routes = $this->app->getRoutes();
        foreach ($routes as $route) {
            foreach ($route->getAllowedMethods() as $method) {
                $middleware = $route->getMiddleware();

                $action = '';

                if (\property_exists($middleware, 'middlewareName')) {
                    $action = $middleware->middlewareName;
                }

                $request->addRoute(
                    $method,
                    $route->getPath(),
                    $action,
                    ['name' => $route->getName()]
                );
            }
        }

    }
}
