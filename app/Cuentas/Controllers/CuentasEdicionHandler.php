<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use App\Common\Persistence\EntityRepository;
use App\Cuentas\Cuenta;
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

class CuentasEdicionHandler implements RequestHandlerInterface
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
            'app::cuentas-edicion',
            [
                'urlHelper' => $this->urlHelper,
                'cuenta' => $this->repository->find((int) $request->getAttribute('id'))
            ] // parameters to pass to template
        ));
    }

}
