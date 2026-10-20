<?php
declare(strict_types=1);

// 1. Control d'autenticació i expiració de sessió
require_once __DIR__ . '/inc/protegeix.php';

// 2. Càrrega de les dades del catàleg
$dades = require __DIR__ . '/inc/dades.php';
$productes = $dades['productes'] ?? [];

// 3. Gestió de la petició per afegir un producte al cistell (paràmetres per GET)
if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = (int) $_GET['id'];
    $quantitat = isset($_GET['quantitat']) ? (int) $_GET['quantitat'] : 1;

    // Validem que el producte existeixi i que la quantitat estigui compresa entre 1 i 10
    if (isset($productes[$id]) && $quantitat > 0 && $quantitat <= 10) {
        // Inicialitzem l'array del cistell a la sessió si encara no existeix
        if (!isset($_SESSION['cistell'])) {
            $_SESSION['cistell'] = [];
        }

        // Acumulem la quantitat seleccionada a l'article corresponent
        $_SESSION['cistell'][$id] = ($_SESSION['cistell'][$id] ?? 0) + $quantitat;

        // Redirigim amb patró PRG (Post/Redirect/Get) per evitar duplicats en recarregar la pàgina
        header('Location: cataleg.php?afegit=1');
        exit;
    }
}

// 4. Inclusió de la capçalera
$titol_pagina = 'Catàleg de Productes';
require_once __DIR__ . '/inc/capcalera.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h2 class="h3 mb-1 fw-bold text-dark">Catàleg de la Cantina</h2>
        <p class="text-muted small mb-0">Selecciona els productes que vulguis i afegeix-los al teu cistell</p>
    </div>
    <a href="cistell.php" class="btn btn-outline-primary btn-sm">
        Veure el cistell
    </a>
</div>

<?php if (isset($_GET['afegit'])): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center shadow-sm" role="alert">
        <span>Producte afegit correctament al cistell de la compra.</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tancar"></button>
    </div>
<?php endif; ?>

<!-- Graella responsive de productes -->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($productes as $id => $producte): ?>
        <div class="col">
            <div class="card h-100 shadow-sm border-0 producte-card">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="card-title h5 fw-bold text-dark mb-0">
                                <?= htmlspecialchars($producte['nom']) ?>
                            </h3>
                            <span class="badge bg-success-subtle text-success border border-success-subtle fs-6">
                                <?= number_format($producte['preu'], 2) ?> €
                            </span>
                        </div>
                        <p class="card-text text-muted small mb-3">
                            Producte fresc preparat diàriament a la cantina de l'institut.
                        </p>
                    </div>

                    <!-- Formulari individual per afegir al cistell -->
                    <form action="cataleg.php" method="GET" class="mt-3 pt-3 border-top">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="row g-2 align-items-center">
                            <div class="col-5">
                                <label for="quantitat-<?= $id ?>" class="visually-hidden">Quantitat</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-secondary">Qtt</span>
                                    <input type="number" id="quantitat-<?= $id ?>" name="quantitat"
                                        class="form-control text-center" value="1" min="1" max="10" required>
                                </div>
                            </div>
                            <div class="col-7">
                                <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                                    Afegir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/inc/peu.php'; ?>