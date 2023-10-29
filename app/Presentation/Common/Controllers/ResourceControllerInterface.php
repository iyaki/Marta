<?php

declare(strict_types=1);

namespace Marta\Presentation\Common\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ResourceControllerInterface
{
    public const RESOURCE = '';

    public const ROUTE_BASE = '/' . self::RESOURCE;

    public const INDICE = self::RESOURCE . 'indice';
    public const NUEVO = self::RESOURCE . 'nuevo';
    public const CREAR = self::RESOURCE . 'crear';
    public const EDICION = self::RESOURCE . 'edicion';
    public const ACTUALIZAR = self::RESOURCE . 'actualizar';
    public const DESTRUIR = self::RESOURCE . 'destruir';

    public function indice(ServerRequestInterface $request): ResponseInterface;
    public function nuevo(ServerRequestInterface $request): ResponseInterface;
    public function crear(ServerRequestInterface $request): ResponseInterface;
    public function edicion(ServerRequestInterface $request): ResponseInterface;
    public function actualizar(ServerRequestInterface $request): ResponseInterface;
    public function destruir(ServerRequestInterface $request): ResponseInterface;
}
