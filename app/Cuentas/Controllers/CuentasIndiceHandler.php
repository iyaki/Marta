<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use App\Common\Persistence\EntityRepository;
use App\Cuentas\Cuenta;
use App\Cuentas\Requests\BasicSearchQuery;
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

final readonly class CuentasIndiceHandler implements RequestHandlerInterface
{
    /**
     * @param EntityRepository<Cuenta> $repository
     */
    public function __construct(
        private TemplateRendererInterface $renderer,
        private UrlHelperInterface $urlHelper,
        #[Inject(EntityRepository::class . Cuenta::class)]private EntityRepository $repository
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

        return new HtmlResponse($this->renderer->render(
            'app::cuentas-indice',
            [
                'urlHelper' => $this->urlHelper,
                'query' => $query->query,
                'cuentas' => $cuentas,
            ] // parameters to pass to template
        ));
    }
}
