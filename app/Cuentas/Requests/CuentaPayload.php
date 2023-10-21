<?php

declare(strict_types=1);

namespace Marta\Cuentas\Requests;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

final readonly class CuentaPayload
{
    private function __construct(
        public string $nombre
    )
    {}

    static public function fromRequest(ServerRequestInterface $request): static
    {
        $body = (object) \json_decode(
            json: \json_encode($request->getParsedBody(), JSON_THROW_ON_ERROR),
            flags: JSON_THROW_ON_ERROR
        );

        $nombre = $body->nombre;

        \assert(is_string($nombre));
        $nombre = trim($nombre);
        \assert($nombre !== '');

        return new self(
            $nombre
        );
    }
}
