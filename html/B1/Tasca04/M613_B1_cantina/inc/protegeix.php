<?php
declare(strict_types=1);

// 1. Iniciem la sessió només si encara no està activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Comprovem si l'usuari té una sessió vàlida iniciada
if (!isset($_SESSION['usuari'])) {
    // Si no està autenticat, redirigim cap al formulari de login
    header('Location: login.php');
    exit;
}

// 3. Control de temps d'expiració per inactivitat (10 minuts = 600 segons)
$timeout = 600;

if (isset($_SESSION['ultim_acces'])) {
    $temps_inactiu = time() - $_SESSION['ultim_acces'];

    if ($temps_inactiu > $timeout) {
        // La sessió ha caducat per inactivitat: buidem les dades de sessió
        $_SESSION = [];

        // Eliminem la cookie de la sessió del client
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destruïm la sessió al servidor i redirigim informant de la caducitat
        session_destroy();
        header('Location: login.php?expirada=1');
        exit;
    }
}

// 4. Actualitzem la marca de temps de l'últim accés per mantenir la sessió viva
$_SESSION['ultim_acces'] = time();