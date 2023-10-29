<?php

declare(strict_types=1);

namespace Marta\Presentation\Cuentas\Controllers;

use DI\Attribute\Inject;
use Doctrine\Common\Collections\Criteria;
use Marta\Domain\Cuentas\Cuenta;
use Marta\Domain\Shared\EntityRepository;
use Marta\Presentation\Common\Controllers\ResourceControllerInterface;
use Marta\Presentation\Common\Controllers\ResourceControllerTrait;
use Marta\Presentation\Common\Requests\BasicSearchQuery;
use Marta\Presentation\Common\Responses\ResponseFactory;
use Marta\Presentation\Cuentas\Requests\CuentaPayload;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CuentasController implements ResourceControllerInterface
{
    use ResourceControllerTrait;

    public const RESOURCE = 'cuentas';

    /**
     * @param EntityRepository<Cuenta> $repository
     */
    public function __construct(
        #[Inject(EntityRepository::class . Cuenta::class)]private EntityRepository $repository,
        private ResponseFactory $responseFactory
    ) {
    }

    public function indice(ServerRequestInterface $request): ResponseInterface
    {
        $query = BasicSearchQuery::fromRequest($request);

        if ($query->query === null) {
            $cuentas = $this->repository->all();
        } else {
            $cuentas = $this->repository->matching(
                new Criteria(Criteria::expr()->contains('nombre', $query->query))
            );
        }

        return $this->responseFactory->createTemplatedHtmlResponse(
            'cuentas::pages/indice',
            [
                'query' => (string) $query->query,
                'cuentas' => $cuentas,
            ]
        );
    }

    public function nuevo(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->createTemplatedHtmlResponse('cuentas::pages/nuevo');
    }

    public function crear(ServerRequestInterface $request): ResponseInterface
    {
        $payload = CuentaPayload::fromRequest($request);

        $cuentaNueva = new Cuenta($payload->nombre);
        $this->repository->add($cuentaNueva);

        return $this->responseFactory->createNamedRedirectResponse(self::INDICE);
    }

    public function edicion(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $id */
        $id = $request->getAttribute('id');

        return $this->responseFactory->createTemplatedHtmlResponse(
            'cuentas::pages/edicion',
            ['cuenta' => $this->repository->find((int) $id)]
        );
    }

    public function actualizar(ServerRequestInterface $request): ResponseInterface
    {
        /** @var string $id */
        $id = $request->getAttribute('id');
        $payload = CuentaPayload::fromRequest($request);

        $cuenta = $this->repository->get((int) $id);
        $cuenta->setNombre($payload->nombre);
        $this->repository->add($cuenta);

        return $this->responseFactory->createNamedRedirectResponse(self::INDICE);
    }

    public function destruir(ServerRequestInterface $request): ResponseInterface
    {
    }
}
