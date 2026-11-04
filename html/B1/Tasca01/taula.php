<?php
require_once 'dades.php';
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taula - <?= NOM_BIBLIOTECA ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor">
        <header class="capcalera">
            <div>
                <h1><?= NOM_BIBLIOTECA ?></h1>
                <p class="subtitol">Vista en format taula</p>
            </div>
            <a href="index.php" class="btn btn-secundari">← Tornar a l'índex</a>
        </header>

        <div class="taula-contenidor">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Títol</th>
                        <th>Autor</th>
                        <th>Any</th>
                        <th>Gènere</th>
                        <th>Estat</th>
                        <th>Valoració</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($biblioteca as $llibre): ?>
                        <tr>
                            <td style="color: #6c757d;"><?= $llibre['id'] ?></td>
                            <td><strong><?= htmlspecialchars($llibre['titol']) ?></strong></td>
                            <td><?= htmlspecialchars($llibre['autor']) ?></td>
                            <td><?= $llibre['any'] ?></td>
                            <td><span class="badge badge-genere"><?= htmlspecialchars($llibre['genere']) ?></span></td>
                            <td>
                                <?php if ($llibre['llegit']): ?>
                                    <span class="badge badge-llegit">Llegit</span>
                                <?php else: ?>
                                    <span class="badge badge-pendent">Pendent</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($llibre['llegit']): ?>
                                    <span class="estrelles"><?= str_repeat('★', $llibre['valoracio']) ?></span>
                                <?php else: ?>
                                    <span class="sense-valoracio">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="contenidor-sticky-bottom">
            <button id="btn-tema" class="boto-tema-sticky">🌙 Mode fosc</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>