<?php

declare(strict_types=1);

namespace App\Cuentas\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class GetCuentasResourceHandler implements RequestHandlerInterface
{
    public function __construct(
        private TemplateRendererInterface $renderer
    ) {
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        return new HtmlResponse($this->renderer->render(
            'app::cuentas-resource',
            [] // parameters to pass to template
        ));
    }

}
