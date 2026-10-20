<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fitxer actual per marcar la pestanya activa al menú
$pagina_actual = basename($_SERVER['PHP_SELF']);
$usuari_loguejat = $_SESSION['usuari'] ?? null;

// Càlcul del nombre d'articles per mostrar al badge del menú
$total_articles = 0;
if (!empty($_SESSION['cistell']) && is_array($_SESSION['cistell'])) {
    $total_articles = array_sum($_SESSION['cistell']);
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titol_pagina) ? htmlspecialchars($titol_pagina) . ' - ' : '' ?>Cantina Institut Lacetània</title>
    <!-- Framework CSS Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estils propis del projecte -->
    <link rel="stylesheet" href="css/estils.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                    <span class="badge bg-primary text-white me-2 px-2 py-1">CL</span>
                    Cantina Lacetània
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal" aria-expanded="false" aria-label="Alternar navegació">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <?php if ($usuari_loguejat): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $pagina_actual === 'cataleg.php' ? 'active fw-semibold' : '' ?>"
                                    href="cataleg.php">Catàleg</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= $pagina_actual === 'cistell.php' ? 'active fw-semibold' : '' ?>"
                                    href="cistell.php">
                                    Cistell
                                    <?php if ($total_articles > 0): ?>
                                        <span class="badge bg-warning text-dark ms-1"><?= $total_articles ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php if (is_array($usuari_loguejat) && ($usuari_loguejat['rol'] ?? '') === 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= $pagina_actual === 'admin.php' ? 'active fw-semibold' : '' ?>"
                                        href="admin.php">Administració</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <?php if ($usuari_loguejat): ?>
                            <div class="navbar-text text-light small me-2">
                                <span class="text-white-50">Sessió:</span>
                                <span class="fw-medium text-white ms-1">
                                    <?= htmlspecialchars(is_array($usuari_loguejat) ? ($usuari_loguejat['nom'] ?? $usuari_loguejat['email']) : $usuari_loguejat) ?>
                                </span>
                                <?php if (is_array($usuari_loguejat) && !empty($usuari_loguejat['rol'])): ?>
                                    <span class="badge bg-secondary text-uppercase ms-1" style="font-size: 0.7rem;">
                                        <?= htmlspecialchars($usuari_loguejat['rol']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <a href="logout.php" class="btn btn-outline-danger btn-sm">Sortir</a>
                        <?php else: ?>
                            <?php if ($pagina_actual !== 'login.php'): ?>
                                <a href="login.php" class="btn btn-outline-light btn-sm">Iniciar sessió</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contingut dinàmic de la pàgina -->
    <main class="container my-4 flex-grow-1">