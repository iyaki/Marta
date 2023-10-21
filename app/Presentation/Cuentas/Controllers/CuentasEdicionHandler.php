<?php

declare(strict_types=1);

namespace Marta\Presentation\Cuentas\Controllers;

use Marta\Domain\Shared\EntityRepository;
use Marta\Domain\Cuentas\Cuenta;
use DI\Attribute\Inject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class CuentasEdicionHandler implements RequestHandlerInterface
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
        return new HtmlResponse($this->renderer->render(
            'app::cuentas-edicion',
            [
                'urlHelper' => $this->urlHelper,
                'cuenta' => $this->repository->find((int) $request->getAttribute('id'))
            ] // parameters to pass to template
        ));
    }

}
