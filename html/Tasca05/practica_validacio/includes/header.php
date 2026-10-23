<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="css/estils.css?v=<?= file_exists(__DIR__ . '/../css/estils.css') ? filemtime(__DIR__ . '/../css/estils.css') : time() ?>">
    <title><?= htmlspecialchars($titol ?? 'Pràctica Validació') ?></title>
</head>
<body>
    <header class="capcalera">
        <nav class="nav-principal">
            <span class="logo">Sistema de Registre</span>
            <ul class="nav-links">
                <li><a href="index.php">Inici</a></li>
                <li><a href="registre.php">Registre d'Usuari</a></li>
            </ul>
        </nav>
    </header>