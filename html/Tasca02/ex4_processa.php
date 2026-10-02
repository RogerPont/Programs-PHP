<?php
function validaciodecontrasenya(string $contrasenya): array 
{
    $erros = [];
    
    // 1. Longitud mínima de 8 caràcters
    if (strlen($contrasenya) < 8) {
        $erros[] = "La contrasenya ha de tindre almenys 8 caràcters";
    }
    
    // Banderes per comprovar els requisits sense expressions regulars
    $teMajuscula = false;
    $teNumero = false;
    $teEspecial = false;

    // Recorrem cada caràcter de la contrasenya
    for ($i = 0; $i < strlen($contrasenya); $i++) {
        $c = $contrasenya[$i];

        if (ctype_upper($c)) {
            $teMajuscula = true;
        } elseif (ctype_digit($c)) {
            $teNumero = true;
        } elseif (!ctype_alnum($c)) {
            $teEspecial = true;
        }
    }

    // 2. Almenys una lletra majúscula
    if (!$teMajuscula) {
        $erros[] = "Ha de contenir almenys alguna majúscula";
    }

    // 3. Almenys un número
    if (!$teNumero) {
        $erros[] = "Ha de contenir almenys un número";
    }

    // 4. Almenys un caràcter especial
    if (!$teEspecial) {
        $erros[] = "Ha de contenir almenys un caràcter especial (@, #, $, etc.)";
    }

    return $erros;
}

// TODO: Rebre la contrasenya de $_POST
$contrasenya = $_POST['contrasenya'] ?? null;
$errors = [];

// TODO: Cridar la funció i comprovar si és vàlida o quins errors té
if ($contrasenya !== null) {
    $errors = validaciodecontrasenya($contrasenya);
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 4 - Resultat Validació</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 4 - Resultat</h2>
            <a href="ex4.php" class="boto-tornar">← Tornar al formulari</a>
        </header>

        <div class="resultat">
            <?php if ($contrasenya === null): ?>
                <div style="background-color: #fff3cd; color: #856404; padding: 12px 16px; border-radius: 6px; margin-bottom: 15px;">
                    <strong>Atenció:</strong> No s'ha rebut cap contrasenya des del formulari.
                </div>
            <?php elseif (empty($errors)): ?>
                <div style="background-color: #d1e7dd; color: #0f5132; padding: 16px 20px; border-radius: 8px; border: 1px solid #badbcc;">
                    <h3 style="margin-top: 0; margin-bottom: 8px; font-size: 1.15rem;">Contrasenya correcta!</h3>
                    <p style="margin: 0;">La contrasenya compleix tots els criteris de seguretat requerits.</p>
                </div>
            <?php else: ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 16px 20px; border-radius: 8px; border: 1px solid #f5c2c7;">
                    <h3 style="margin-top: 0; margin-bottom: 10px; font-size: 1.15rem;">La contrasenya no és vàlida:</h3>
                    <p style="margin: 0 0 8px 0;">No compleix els següents requisits:</p>
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li style="margin-bottom: 4px;"><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="index.php" style="font-size: 0.9em; text-decoration: underline;">Tornar a l'índex principal</a>
        </div>
    </div>
</body>
</html>
