<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use App\Common\Persistence\EntityRepository;
use App\Cuentas\Cuenta;
use App\Cuentas\Requests\CuentaPayload;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;
use Nette\Schema\Expect;

class CuentasCrearHandler implements RequestHandlerInterface
{
    /**
     * @param EntityRepository<Cuenta> $repository
     */
    public function __construct(
        private readonly UrlHelperInterface $urlHelper,
        #[Inject(EntityRepository::class . Cuenta::class)]
        private readonly EntityRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $payload = CuentaPayload::fromRequest($request);

        $cuentaNueva = new Cuenta($payload->nombre);
        $this->repository->add($cuentaNueva);

        return new RedirectResponse($this->urlHelper->generate('cuentas.indice'));
    }
}