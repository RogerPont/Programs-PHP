<?php
declare(strict_types=1);

// 1. Control d'autenticació i sessió activa
require_once __DIR__ . '/inc/protegeix.php';

// 2. Control d'autorització: només usuaris amb rol 'admin' poden accedir-hi
if (!isset($_SESSION['usuari']['rol']) || $_SESSION['usuari']['rol'] !== 'admin') {
    // Si no és administrador, el redirigim al catàleg general
    header('Location: cataleg.php');
    exit;
}

// 3. Càrrega de dades del sistema per a la gestió administrativa
$dades = require __DIR__ . '/inc/dades.php';
$usuaris = $dades['usuaris'] ?? [];
$productes = $dades['productes'] ?? [];

// 4. Inclusió de la capçalera
$titol_pagina = 'Administració';
require_once __DIR__ . '/inc/capcalera.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h2 class="h3 mb-1 fw-bold text-dark">Panell d'Administració</h2>
        <p class="text-muted small mb-0">Gestió global de la cantina (només visible per a perfils d'administració)</p>
    </div>
    <span class="badge bg-danger text-white px-3 py-2 text-uppercase">Accés Restringit</span>
</div>

<!-- Targetes de resum (KPIs de la cantina) -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-md-4">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-body">
                <span class="text-secondary small text-uppercase fw-semibold">Productes al Catàleg</span>
                <h3 class="h2 fw-bold text-dark mb-0 mt-2"><?= count($productes) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-body">
                <span class="text-secondary small text-uppercase fw-semibold">Usuaris Registrats</span>
                <h3 class="h2 fw-bold text-dark mb-0 mt-2"><?= count($usuaris) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-body">
                <span class="text-secondary small text-uppercase fw-semibold">Usuari Actual</span>
                <p class="mb-0 mt-2 fw-semibold text-truncate"><?= htmlspecialchars($_SESSION['usuari']['email']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Taula de productes registrats -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h4 class="h6 mb-0 fw-bold text-dark">Llistat de Productes</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-2 small text-secondary">ID</th>
                            <th class="py-2 small text-secondary">Nom del Producte</th>
                            <th class="text-end pe-3 py-2 small text-secondary">Preu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productes as $id => $item): ?>
                            <tr>
                                <td class="ps-3 text-muted small">#<?= (int) $id ?></td>
                                <td class="fw-semibold text-dark"><?= htmlspecialchars($item['nom']) ?></td>
                                <td class="text-end pe-3 text-success fw-bold"><?= number_format($item['preu'], 2) ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Taula d'usuaris registrats -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h4 class="h6 mb-0 fw-bold text-dark">Usuaris del Sistema</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 py-2 small text-secondary">Nom</th>
                            <th class="py-2 small text-secondary">Correu</th>
                            <th class="text-end pe-3 py-2 small text-secondary">Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuaris as $u): ?>
                            <tr>
                                <td class="ps-3 small fw-semibold"><?= htmlspecialchars($u['nom']) ?></td>
                                <td class="small text-muted"><?= htmlspecialchars($u['email']) ?></td>
                                <td class="text-end pe-3">
                                    <span class="badge <?= $u['rol'] === 'admin' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-secondary-subtle text-secondary border' ?> text-uppercase" style="font-size: 0.65rem;">
                                        <?= htmlspecialchars($u['rol']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/inc/peu.php'; ?>