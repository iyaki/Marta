<?php

declare(strict_types=1);

namespace App\Cuentas;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Cuenta
{
    #[Column, Id, GeneratedValue]
    private ?int $id = null;

    public function __construct(
        #[Column]
        private string $nombre
    )
    {}

    public function id(): ?int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}
