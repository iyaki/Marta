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
        $clockwork = Clockwork::instance();
        return new JsonResponse($clockwork->getMetadata($request->getAttribute('request')));
    }

}
