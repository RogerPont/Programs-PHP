<?php
declare(strict_types=1);

// 1. Inici de sessió
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;
$missatge_info = null;
$email = '';

// Si l'usuari ja ha iniciat sessió prèviament, el redirigim al catàleg
if (isset($_SESSION['usuari'])) {
    header('Location: cataleg.php');
    exit;
}

// Comprovem si venim redirigits per sessió caducada (timeout)
if (isset($_GET['expirada']) && $_GET['expirada'] === '1') {
    $missatge_info = "La sessió ha caducat per inactivitat. Si us plau, torna a iniciar sessió.";
}

// 2. Carreguem les dades d'usuaris i funcions auxiliars
$dades = require __DIR__ . '/inc/dades.php';
require_once __DIR__ . '/inc/funcions.php';

// 3. Processament del formulari per mètode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $contrasenya = $_POST['contrasenya'] ?? '';

    // Validació bàsica de camps omplerts
    if ($email === '' || $contrasenya === '') {
        $error = "Cal indicar tant l'adreça de correu com la contrasenya.";
    } else {
        // Cerquem l'usuari a la llista d'usuaris registrats
        $usuari = buscaUsuari($dades['usuaris'], $email);

        // Verifiquem si l'usuari existeix i si el hash de la contrasenya coincideix
        if ($usuari && (password_verify($contrasenya, $usuari['contrasenya']) || $contrasenya === $usuari['contrasenya'])) {
            // Regenerem l'ID de sessió per prevenir atacs de fixació de sessió
            session_regenerate_id(true);

            // Guardem les dades de l'usuari i la marca de temps actual a la sessió
            $_SESSION['usuari'] = $usuari;
            $_SESSION['ultim_acces'] = time();

            // Redirigim a la vista principal del catàleg
            header('Location: cataleg.php');
            exit;
        } else {
            $error = "Credencials incorrectes. Comprova el correu i la contrasenya.";
        }
    }
}

// Títol per a la pestanya del navegador
$titol_pagina = 'Iniciar Sessió';
require_once __DIR__ . '/inc/capcalera.php';
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="card-title text-center h4 mb-3 fw-bold">Accés a la Cantina</h2>
                <p class="text-muted text-center small mb-4">Introdueix les teves credencials per continuar</p>

                <?php if ($missatge_info): ?>
                    <div class="alert alert-warning py-2 small" role="alert">
                        <?= htmlspecialchars($missatge_info) ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold">Correu electrònic:</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="<?= htmlspecialchars($email) ?>" placeholder="nom@lacetania.cat" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="contrasenya" class="form-label small fw-semibold">Contrasenya:</label>
                        <input type="password" id="contrasenya" name="contrasenya" class="form-control"
                            placeholder="Contrasenya" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Entrar</button>
                </form>

                <div class="mt-4 pt-3 border-top text-center text-muted small">
                    <span class="d-block fw-semibold text-secondary mb-1">Usuaris de prova:</span>
                    <span>alumne@lacetania.cat / admin</span><br>
                    <span>cantina@lacetania.cat / admin</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/inc/peu.php'; ?>