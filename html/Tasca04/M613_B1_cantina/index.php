<?php
declare(strict_types=1);

// Iniciem la sessió per poder llegir l'estat de l'usuari
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ja hi ha un usuari autenticat a la sessió, el portem directament al catàleg
if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
    exit;
}

// En cas contrari, redirigim a la pàgina d'inici de sessió
header('Location: login.php');
exit;