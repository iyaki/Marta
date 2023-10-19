<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use App\Common\Persistence\EntityRepository;
use App\Cuentas\Cuenta;
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
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

class CuentasIndiceHandler implements RequestHandlerInterface
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
        $query = $request->getQueryParams()['q'] ?? null;

        $cuentas = (
            $query === null
            ? $this->repository->findAll()
            : $this->repository->matching(
                new Criteria(Criteria::expr()->contains('nombre', $query))
            )
        );

        return new HtmlResponse($this->renderer->render(
            'app::cuentas-indice',
            [
                'urlHelper' => $this->urlHelper,
                'query' => $query,
                'cuentas' => $cuentas,
            ] // parameters to pass to template
        ));
    }
}
