<?php
declare(strict_types=1);

namespace App\Models;

use App\Interfaces\Reservable;
use InvalidArgumentException;

class DVD extends Material implements Reservable
{
    private int $duracio;

    public function __construct(int $id, string $titol, string $autor, int $anyPublicacio, int $duracio)
    {
        parent::__construct($id, $titol, $autor, $anyPublicacio);
        $this->setDuracio($duracio);
    }

    public function calcularMulta(int $diesRetard): float
    {
        return $diesRetard * 1.00;
    }

    public function getTipus(): string
    {
        return 'DVD';
    }

    public function getDuracio(): int
    {
        return $this->duracio;
    }
    public function getDuracioFormatada(): string {
        $hores = intdiv($this->duracio, 60);
        $minuts = $this->duracio % 60;
        return "{$hores}h {$minuts}min";
    }
    
    public function setDuracio(int $minuts): void
    {
        if ($minuts <= 0) {
            throw new InvalidArgumentException('El número de Duració ha de ser major que 0');
        }
        $this->duracio = $minuts;
    }
}

