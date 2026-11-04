<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista - <?= NOM_BIBLIOTECA ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor">
        <header class="capcalera">
            <div>
                <h1><?= NOM_BIBLIOTECA ?></h1>
                <p class="subtitol">Vista en targetes</p>
            </div>
            <a href="index.php" class="btn btn-secundari">← Tornar a l'índex</a>
        </header>

        <ul class="graella-llibres">
            <?php foreach ($biblioteca as $llibre): ?>
                <li class="targeta-llibre">
                    <div>
                        <h3><?= htmlspecialchars($llibre['titol']) ?></h3>
                        <p><strong>Autor:</strong> <?= htmlspecialchars($llibre['autor']) ?></p>
                        <p><strong>Any:</strong> <?= $llibre['any'] ?></p>
                        <p><strong>Gènere:</strong> <span class="badge badge-genere"><?= htmlspecialchars($llibre['genere']) ?></span></p>
                        <p>
                            <strong>Estat:</strong>
                            <?php if ($llibre['llegit']): ?>
                                <span class="badge badge-llegit">Llegit</span>
                            <?php else: ?>
                                <span class="badge badge-pendent">Pendent</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <?php if ($llibre['llegit']): ?>
                        <div class="estrelles">
                            <?= str_repeat('★', $llibre['valoracio']) ?>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="contenidor-sticky-bottom">
            <button id="btn-tema" class="boto-tema-sticky">🌙 Mode fosc</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>