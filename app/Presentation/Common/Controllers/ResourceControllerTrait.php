<?php

declare(strict_types=1);

namespace Marta\Presentation\Common\Controllers;

trait ResourceControllerTrait
{
    public const ROUTE_BASE = '/' . self::RESOURCE;

    public const INDICE = self::RESOURCE . '.indice';
    public const NUEVO = self::RESOURCE . '.nuevo';
    public const CREAR = self::RESOURCE . '.crear';
    public const EDICION = self::RESOURCE . '.edicion';
    public const ACTUALIZAR = self::RESOURCE . '.actualizar';
    public const DESTRUIR = self::RESOURCE . '.destruir';
}
