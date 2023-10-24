<?php

declare(strict_types=1);

namespace Marta\Presentation\Common\Responses;

use InvalidArgumentException;
use Mezzio\Helper\Exception\RuntimeException as ExceptionRuntimeException;
use Mezzio\Helper\UrlHelperInterface;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

final readonly class ResponseFactory
{

    private const HEADER_CONTENT_TYPE = 'content-type';
    private const HEADER_LOCATION = 'location';
    private const CONTENT_TYPE_HTML = 'text/html; charset=utf-8';

    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private UrlHelperInterface $urlHelper,
        private TemplateRendererInterface $renderer
    ){
        $this->renderer->addDefaultParam(
            TemplateRendererInterface::TEMPLATE_ALL,
            'urlHelper',
            $this->urlHelper
        );
    }

    private function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->responseFactory->createResponse($code, $reasonPhrase);
    }

    private function createHtmlResponse(string $html, int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        $response = $this->createResponse($code, $reasonPhrase)
            ->withAddedHeader(self::HEADER_CONTENT_TYPE, self::CONTENT_TYPE_HTML)
        ;
        $response->getBody()->write($html);

        return $response;
    }

    /**
     * @param non-empty-string $templateName
     * @param array<string, mixed> $params
     */
    public function createTemplatedHtmlResponse(string $templateName, array $params = [], int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->createHtmlResponse(
            $this->renderer->render(
                $templateName,
                $params
            ),
            $code,
             $reasonPhrase
        );
    }

    private function createRedirectResponse(string $uri, int $code = 302, string $reasonPhrase = ''): ResponseInterface
    {
        return $this
            ->createResponse($code, $reasonPhrase)
            ->withHeader(self::HEADER_LOCATION, $uri)
        ;
    }

    /**
     * @param non-empty-string $routeName
     * @param array<string, mixed> $routeParams
     * @param array<string, mixed> $queryParams
     */
    public function createNamedRedirectResponse(
        string $routeName,
        array $routeParams = [],
        array $queryParams = [],
        ?string $fragmentIdentifier = null,
        int $code = 302,
        string $reasonPhrase = ''
    ): ResponseInterface {
        return $this->createRedirectResponse(
            $this->urlHelper->generate(
                $routeName,
                $routeParams,
                $queryParams,
                $fragmentIdentifier
            ),
            $code,
            $reasonPhrase
        );
    }
}
