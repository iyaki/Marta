<?php

declare(strict_types=1);

namespace MartaDev\Clockwork;

use Clockwork\Support\Slim\Legacy\ClockworkMiddleware as ClockworkClockworkMiddleware;
use Clockwork\Support\Vanilla\Clockwork;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ClockworkMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $clockwork = Clockwork::init([
            'register_helpers' => true,
        ]);
        $response = $handler->handle($request);
        return $clockwork->usePsrMessage($request, $response)->requestProcessed();
    }
}
