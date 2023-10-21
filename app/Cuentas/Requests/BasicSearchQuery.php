<?php

declare(strict_types=1);

namespace App\Cuentas\Requests;
use Psr\Http\Message\ServerRequestInterface;

final class BasicSearchQuery
{
    private function __construct(
        public readonly ?string $query
    )
    {}

    static public function fromRequest(ServerRequestInterface $request): static
    {
        $queryParams = (object) \json_decode(
            json: \json_encode($request->getQueryParams()),
            flags: JSON_THROW_ON_ERROR
        );

        $query = \property_exists($queryParams, 'q') ? trim((string) $queryParams->q) : null;

        return new static($query);

    }

}
