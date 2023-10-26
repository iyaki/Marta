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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class ClockworkBaseMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Clockwork $clockwork */
        $clockwork = Clockwork::init([
            'register_helpers' => true,
        ]);
        $clockwork->addDataSource(new DoctrineDataSource($this->entityManager));

        $response = $handler->handle($request);

        $clockwork->addDataSource(new XdebugDataSource());

        // monolog
        // notifications?
        // events?
        // cache?
        // sessionData?

        return $clockwork->usePsrMessage($request, $response)->requestProcessed();
    }
}
