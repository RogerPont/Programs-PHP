<?php

// 1. Funció per calcular l'àrea d'un rectangle
function calcularAreaRectangle(float $base, float $altura): float {
    return $base * $altura;
}

// Variables per al control del flux
$error = null;
$area = null;
$base = null;
$altura = null;

// 2. Rebre i validar les dades del formulari passades per $_GET
if (isset($_GET['base']) && isset($_GET['altura'])) {
    $base = $_GET['base'];
    $altura = $_GET['altura'];

    // Validem que siguin valors numèrics i positius
    if (!is_numeric($base) || !is_numeric($altura)) {
        $error = "La base i l'altura han de ser valors numèrics.";
    } elseif ($base <= 0 || $altura <= 0) {
        $error = "Els valors han de ser positius superiors a 0.";
    } else {
        // Convertim a tipus float per seguretat
        $base = (float) $base;
        $altura = (float) $altura;

        // 3. Cridar la funció i obtenir el resultat
        $area = calcularAreaRectangle($base, $altura);
    }
} else {
    $error = "No s'han rebut totes les dades del formulari.";
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 1 - Resultat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 1 - Resultat</h2>
            <a href="ex1.php" class="boto-tornar">← Tornar al formulari</a>
        </header>

        <div class="resultat">
            <?php if ($error !== null): ?>
                <div style="background-color: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 6px; margin-bottom: 15px;">
                    ❌ <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php else: ?>
                <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; border: 1px solid #dee2e6;">
                    <p><strong>Base introduïda:</strong> <?= htmlspecialchars($base) ?></p>
                    <p><strong>Altura introduïda:</strong> <?= htmlspecialchars($altura) ?></p>
                    <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">
                    <p style="font-size: 1.2rem; color: #198754; margin: 0;">
                        📐 <strong>Àrea calculada:</strong> <?= htmlspecialchars($area) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="index.php" style="font-size: 0.9em; text-decoration: underline;">Tornar a l'índex principal</a>
        </div>
    </div>
</body>
</html>
