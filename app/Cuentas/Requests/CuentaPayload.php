<?php

declare(strict_types=1);

namespace App\Cuentas\Requests;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CuentaPayload
{
    private function __construct(
        public readonly string $nombre
    )
    {}

    static public function fromRequest(ServerRequestInterface $request): static
    {
        $body = (object) \json_decode(
            json: \json_encode($request->getParsedBody()),
            flags: JSON_THROW_ON_ERROR
        );

        $nombre = $body->nombre;

        \assert(is_string($nombre));
        $nombre = trim($nombre);
        \assert($nombre !== '');

        return new static(
            $nombre
        );
    }
}
