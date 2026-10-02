<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici - <?= NOM_BIBLIOTECA ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 650px;">
        <header class="capcalera" style="display: block; text-align: center; border-bottom: none; margin-bottom: 10px;">
            <span class="badge badge-genere">Tasca 1 B1 613</span>
            <h1 style="margin-top: 10px;"><?= NOM_BIBLIOTECA ?></h1>
            <p class="subtitol">Panell d'estadístiques i explorador de llibres</p>
        </header>

        <div class="panell-estadistiques">
            <div class="caixa-estadistica">
                <h3>Llibres llegits</h3>
                <p class="valor"><?= $llibresLlegits ?></p>
            </div>
            <div class="caixa-estadistica">
                <h3>Pendents</h3>
                <p class="valor"><?= $llibresNoLlegits ?></p>
            </div>
            <div class="caixa-estadistica">
                <h3>Mitjana</h3>
                <p class="valor"><?= $valoracioMitjana ?> <span class="escala">/ 5</span></p>
            </div>
        </div>

        <div class="menu-vistes">
            <a href="llista.php" class="enllac-vista">Veure llibres en llista (targetes)</a>
            <a href="taula.php" class="enllac-vista">Veure llibres en taula detallada</a>
        </div>

        <div class="contenidor-sticky-bottom">
            <button id="btn-tema" class="boto-tema-sticky">🌙 Mode fosc</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>