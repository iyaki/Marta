<?php

declare(strict_types=1);

namespace MartaDev\Clockwork;

use Clockwork\DataSource\DataSource;
use Clockwork\DataSource\DataSourceInterface;
use Clockwork\DataSource\DoctrineDataSource;
use Clockwork\DataSource\XdebugDataSource;
use Clockwork\Request\Request;
use Clockwork\Support\Vanilla\Clockwork;
use Doctrine\ORM\EntityManagerInterface;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ClockworkMezzioRoutedRequestMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        \clock()->addDataSource(new MezzioExtrasDataSource($request));

        // vendor/itsgoingd/clockwork/Clockwork/DataSource/LumenDataSource.php:147
        //routes

        // plates



        return $handler->handle($request);
    }
}
