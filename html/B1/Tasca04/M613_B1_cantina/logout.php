<?php
declare(strict_types=1);

// 1. Iniciem la sessió per poder accedir-hi
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Buidem totes les variables de la sessió en memòria
$_SESSION = [];

// 3. Si s'utilitzen cookies de sessió, forcem l'expiració de la cookie al navegador
if (ini_get("session.use_cookies")) {
    $cookie_params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $cookie_params["path"],
        $cookie_params["domain"],
        $cookie_params["secure"],
        $cookie_params["httponly"]
    );
}

// 4. Destruïm definitivament la sessió
session_destroy();

// 5. Redirigim a la pàgina d'inici
header('Location: index.php');
exit;