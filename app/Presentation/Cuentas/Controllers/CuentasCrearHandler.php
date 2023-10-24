<?php

declare(strict_types=1);

namespace Marta\Presentation\Cuentas\Controllers;

use Marta\Domain\Shared\EntityRepository;
use Marta\Domain\Cuentas\Cuenta;
use Marta\Presentation\Cuentas\Requests\CuentaPayload;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Marta\Presentation\Common\Responses\ResponseFactory;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;
use Nette\Schema\Expect;

final readonly class CuentasCrearHandler implements RequestHandlerInterface
{
    /**
     * @param EntityRepository<Cuenta> $repository
     */
    public function __construct(
        #[Inject(EntityRepository::class . Cuenta::class)]private EntityRepository $repository,
        private ResponseFactory $responseFactory
    ) {
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $payload = CuentaPayload::fromRequest($request);

        $cuentaNueva = new Cuenta($payload->nombre);
        $this->repository->add($cuentaNueva);

        return $this->responseFactory->createNamedRedirectResponse('cuentas.indice');
    }
}