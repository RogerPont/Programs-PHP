<?php
declare(strict_types=1);

namespace Biblioteca\Models;

use Biblioteca\Traits\Auditoria;

abstract class Material
{
    use Auditoria;

    protected bool $disponible = true;

    public function __construct(
        protected int $id,
        protected string $titol,
        protected string $autor,
        protected int $anyPublicacio,
    ){}

    abstract public function calcularMulta(int $diesRetard): float;
    abstract public function getTipus(): string;
    
}

