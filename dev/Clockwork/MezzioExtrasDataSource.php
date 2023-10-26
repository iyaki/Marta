<?php

declare(strict_types=1);

namespace MartaDev\Clockwork;

use Clockwork\DataSource\DataSource;
use Clockwork\Request\Request;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ServerRequestInterface;

final class MezzioExtrasDataSource extends DataSource
{
    public function __construct(
        private readonly ServerRequestInterface $psrRequest
    )
    {}

    public function resolve(Request $request)
    {
        /** @var RouteResult $routeResult */
        $routeResult = $this->psrRequest->getAttribute(RouteResult::class);
        $matchedRoute = $routeResult->getMatchedRoute();
        $handler = $matchedRoute->getMiddleware()->middlewareName;

        $request->controller = $handler;
    }
}
