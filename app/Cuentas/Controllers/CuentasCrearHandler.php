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
        $processor = new \Nette\Schema\Processor();
        $schema = Expect::structure([
            'nombre' => Expect::string()
                ->min(3)
                ->max(255)
                ->required()
        ]);
        try {
            $data = $processor->process($schema, $request->getParsedBody());
        } catch (\Nette\Schema\ValidationException $e) {
            return new HtmlResponse('Data is invalid: ' . $e->getMessage());
        }

        $cuentaNueva = new Cuenta($data->nombre);
        $this->repository->add($cuentaNueva);

        return new RedirectResponse($this->urlHelper->generate('cuentas.indice'));
    }
}
