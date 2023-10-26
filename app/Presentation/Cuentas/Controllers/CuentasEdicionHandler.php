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
use Marta\Presentation\Common\Responses\ResponseFactory;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;

final readonly class CuentasEdicionHandler implements RequestHandlerInterface
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
        /** @var string $id */
        $id = $request->getAttribute('id');

        return $this->responseFactory->createTemplatedHtmlResponse(
            'cuentas::pages/edicion',
            ['cuenta' => $this->repository->find((int) $id)]
        );
    }

}
