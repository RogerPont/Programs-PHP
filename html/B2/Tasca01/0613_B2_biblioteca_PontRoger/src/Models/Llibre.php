<?php
declare(strict_types=1);

namespace App\Models;

use App\Interfaces\Reservable;
use InvalidArgumentException;

class Llibre extends Material implements Reservable
{
    private int $numeroPagines;

    public function __construct(int $id, string $titol, string $autor, int $anyPublicacio, int $numeroPagines)
    {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setNumeroPagines($numeroPagines);
    }

    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 0.50;
    }

    public function getTipus(): string
    {
        return 'Llibre';
    }

    public function getNumeroPagines(): int
    {
        return $this->numeroPagines;
    }

    public function setNumeroPagines(int $pagines): void
    {
        if ($pagines <= 0) {
            throw new InvalidArgumentException('El número de pàgines ha de ser major que 0');
        }
        $this->numeroPagines = $pagines;
    }



}
