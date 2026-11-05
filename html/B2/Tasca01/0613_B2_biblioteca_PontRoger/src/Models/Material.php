<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditoria;



abstract class Material
{
    use Auditoria;

    protected bool $disponible = true;

    public function __construct(
        protected int $id,
        protected string $titol,
        protected string $autor,
        protected int $anyPublicacio,
    ) {
    }

    abstract public function calcularMulta(int $diesRetard): float;
    abstract public function getTipus(): string;


    public function prestar(): bool
    {
        if ($this->disponible) {
            $this->disponible = false;
            $this->registrarAccio('prestat');
            return true;
        }
        return false;
    }
    public function retornar(): void
    {
        $this->disponible = true;
        $this->registrarAccio('retornat');
    }


    public function __toString(): string
    {
        $estat = $this->disponible ? 'Disponible' : 'No disponible';
        return "[{$this->getTipus()}] #{$this->id} - {$this->titol} ({$this->autor}, {$this->anyPublicacio}) - {$estat}";
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getTitol(): string
    {
        return $this->titol;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getAnyPublicacio(): int
    {
        return $this->anyPublicacio;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

}

