<?php
declare(strict_types=1);

function buscaUsuari(array $usuaris, string $email): ?array
{
    foreach ($usuaris as $usuari) {
        if ($usuari['email'] === $email) {
            return $usuari;
        }
    }
    return null;
}

function unitatsCistell(array $cistell): int
{
    return array_sum($cistell);
}


function totalCistell(array $cistell, array $productes): float
{
    $total = 0.0;
    foreach ($cistell as $id => $quantitat) {
        // Comprovem que el producte encara existeixi al catàleg
        if (isset($productes[$id])) {
            $total += $productes[$id]['preu'] * $quantitat;
        }
    }
    return $total;
}

function afegeixMissatge(string $text): void
{
    $_SESSION['flash'] = $text;
}

function llegeixMissatge(): ?string
{
    if (isset($_SESSION['flash'])) {
        $missatge = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $missatge;
    }
    return null;
}