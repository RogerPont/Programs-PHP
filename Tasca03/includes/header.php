<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASCA-03 - Arrays, Funcions i Formularis</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estils personalitzats opcionals -->
    <link href="./assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <!-- Barra de navegació Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">PHP Exercicis</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'ex1.php' ? 'active' : '' ?>" href="ex1.php">Capitals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'ex2.php' ? 'active' : '' ?>" href="ex2.php">Temperatures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'ex3.php' ? 'active' : '' ?>" href="ex3.php">Arrays</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'ex4.php' ? 'active' : '' ?>" href="ex4.php">Acadèmia</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container my-4 flex-grow-1">
