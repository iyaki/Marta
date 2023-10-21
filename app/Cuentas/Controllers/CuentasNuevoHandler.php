<?php

declare(strict_types=1);

namespace Marta\Cuentas\Controllers;

use Marta\Common\Persistence\EntityRepository;
use Marta\Cuentas\Cuenta;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class CuentasNuevoHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $renderer,
        private UrlHelperInterface $urlHelper
    ) {
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse($this->renderer->render(
            'app::cuentas-nuevo',
            ['urlHelper' => $this->urlHelper] // parameters to pass to template
        ));
    }
}
