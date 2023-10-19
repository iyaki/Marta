<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use App\Common\Persistence\EntityRepository;
use App\Cuentas\Cuenta;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

class CuentasNuevoHandler implements RequestHandlerInterface
{
    /**
     * @param EntityRepository<Cuenta> $repository
     */
    public function __construct(
        private readonly TemplateRendererInterface $renderer,
        private readonly UrlHelperInterface $urlHelper,
        #[Inject(EntityRepository::class . Cuenta::class)]
        private readonly EntityRepository $repository
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
