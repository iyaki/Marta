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
use Mezzio\Application;
use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ClockworkMezzioRoutedRequestMiddleware implements MiddlewareInterface
{
    public function __construct(
        private Application $app
    )
    {
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // vendor/itsgoingd/clockwork/Clockwork/DataSource/LumenDataSource.php:147
        //routes

        // plates

        $response = $handler->handle($request);

        \clock()->addDataSource(new MezzioExtrasDataSource($request, $this->app));

        return $response;
    }
}
