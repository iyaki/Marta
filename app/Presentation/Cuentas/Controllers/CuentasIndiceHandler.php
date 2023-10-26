<?php

declare(strict_types=1);

namespace Marta\Presentation\Cuentas\Controllers;

use Marta\Domain\Shared\EntityRepository;
use Marta\Domain\Cuentas\Cuenta;
use Marta\Presentation\Common\Requests\BasicSearchQuery;
use DI\Attribute\Inject;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Framework\DependencyInjectionContainer\EntityRepositoryHelper;
use Nette\Schema\Expect;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Marta\Presentation\Common\Responses\ResponseFactory;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class CuentasIndiceHandler implements RequestHandlerInterface
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
}
