<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/basedades.php';

function buscarusuari($users, $email, $contrasenya) {
    $usuariTrobat = null;
    foreach ($users as $usuari) {
        if ($usuari['email'] === $email && $usuari['contrasenya'] === $contrasenya) {
            $usuariTrobat = $usuari;
            break;
        }
    }
    return $usuariTrobat;
}



$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $contrasenya = $_POST['contrasenya'] ?? '';

    if ($email === "" || $contrasenya === "") {
        $error = "Cal indicar tant l'adreça de correu com la contrasenya.";
    } else{
        $usuari = buscarusuari($users, $email, $contrasenya);

        if ($usuari != null) {
            header('Location: /index.php');
            exit();
        } else{
            $error = "El correu o la contrasenya no son correctes.";
        }
    }

}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de Sessió</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1>Inici de Sessió</h1>
            <p>Introdueix les teves credencials per accedir</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alerta-error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke-width="2"/>
                    <line x1="12" y1="8" x2="12" y2="12" stroke-width="2"/>
                    <circle cx="12" cy="16" r="1" fill="currentColor"/>
                </svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <label for="email">Correu electrònic</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="exemple@correu.com" 
                        value="<?= htmlspecialchars($email ?? '') ?>" 
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="contrasenya">Contrasenya</label>
                <div class="input-wrapper">
                    <input 
                        type="contrasenya" 
                        id="contrasenya" 
                        name="contrasenya" 
                        class="form-input" 
                        placeholder="••••••••" 
                        required
                    >
                </div>
            </div>

            <div class="form-options">
                <label class="checkbox-label">
                    <input type="checkbox" name="recorda">
                    <span>Recorda'm</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Iniciar Sessió
            </button>
        </form>

        <div class="login-footer">
            Sistema de Gestió &copy; <?= date('Y') ?>
        </div>
    </div>

</body>
</html>