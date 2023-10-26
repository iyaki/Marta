<?php

declare(strict_types=1);

namespace MartaDev\Clockwork;

use Clockwork\Support\Vanilla\Clockwork;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ClockworkHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Clockwork $clockwork */
        $clockwork = Clockwork::instance();

        $requestId = $request->getAttribute('request');

        if (\strtoupper($request->getMethod()) === 'POST') {
            $clockwork->updateMetadata($requestId);
        }

        return new JsonResponse($clockwork->getMetadata($requestId));
    }

}
