<?php

declare(strict_types=1);

namespace Marta\Presentation\Cuentas\Controllers;

use Marta\Domain\Shared\EntityRepository;
use Marta\Domain\Cuentas\Cuenta;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Marta\Presentation\Common\Responses\ResponseFactory;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class CuentasNuevoHandler implements RequestHandlerInterface
{
    public function __construct(
        private ResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->responseFactory->createTemplatedHtmlResponse('cuentas::pages/nuevo');
    }
}
