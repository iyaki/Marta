<?php

declare(strict_types=1);

namespace App\Cuentas;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Cuenta
{
    #[Column, Id]
    private ?int $id;

    public function __construct(
        #[Column]
        private string $nombre
    )
    {}
}
