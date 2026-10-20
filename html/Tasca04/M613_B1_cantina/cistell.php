<?php
declare(strict_types=1);

// 1. Assegurem la sessió de l'usuari i control d'inactivitat
require_once __DIR__ . '/inc/protegeix.php';

// 2. Carreguem les dades dels productes per calcular preus i noms
$dades = require __DIR__ . '/inc/dades.php';
$productes = $dades['productes'] ?? [];

// 3. Gestió de les accions del cistell per paràmetres GET
$accio = $_GET['accio'] ?? null;

if ($accio === 'buidar') {
    // Esborrem completament tots els articles de la sessió
    $_SESSION['cistell'] = [];
    $_SESSION['missatge_cistell'] = "S'ha buidat el cistell de la compra.";
    header('Location: cistell.php');
    exit;

} elseif ($accio === 'eliminar' && isset($_GET['id'])) {
    // Eliminem un article concret pel seu identificador
    $id = (int) $_GET['id'];
    if (isset($_SESSION['cistell'][$id])) {
        unset($_SESSION['cistell'][$id]);
        $_SESSION['missatge_cistell'] = "S'ha eliminat el producte del cistell.";
    }
    header('Location: cistell.php');
    exit;

} elseif ($accio === 'finalitzar') {
    // Finalitzem la compra si hi ha productes al cistell
    if (!empty($_SESSION['cistell'])) {
        $_SESSION['missatge_cistell'] = "Comanda realitzada amb èxit! Pots passar a recollir-la a la cantina.";
        $_SESSION['cistell'] = [];
    }
    header('Location: cistell.php?completada=1');
    exit;
}

// Missatge informatiu guardat a la sessió
$missatge_informativa = $_SESSION['missatge_cistell'] ?? null;
unset($_SESSION['missatge_cistell']);

// 4. Inclusió de la capçalera
$titol_pagina = 'El teu cistell';
require_once __DIR__ . '/inc/capcalera.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h2 class="h3 mb-1 fw-bold text-dark">El teu Cistell</h2>
        <p class="text-muted small mb-0">Revisa els productes afegits abans de confirmar la teva comanda</p>
    </div>
    <a href="cataleg.php" class="btn btn-outline-secondary btn-sm">
        Seguir comprant
    </a>
</div>

<?php if ($missatge_informativa): ?>
    <div class="alert <?= isset($_GET['completada']) ? 'alert-success' : 'alert-info' ?> alert-dismissible fade show shadow-sm" role="alert">
        <span><?= htmlspecialchars($missatge_informativa) ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tancar"></button>
    </div>
<?php endif; ?>

<?php if (empty($_SESSION['cistell'])): ?>
    <div class="card shadow-sm border-0 text-center py-5">
        <div class="card-body">
            <h3 class="h5 fw-bold text-secondary mb-2">El teu cistell està actualment buit</h3>
            <p class="text-muted small mb-4">No tens cap article afegit a la comanda actual.</p>
            <a href="cataleg.php" class="btn btn-primary px-4 fw-semibold">
                Explorar el Catàleg
            </a>
        </div>
    </div>
<?php else: ?>
    <!-- Taula de desglossament d'articles -->
    <div class="card shadow-sm border-0 mb-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-3 py-3 text-secondary text-uppercase small">Producte</th>
                        <th class="text-end py-3 text-secondary text-uppercase small">Preu unitari</th>
                        <th class="text-center py-3 text-secondary text-uppercase small">Quantitat</th>
                        <th class="text-end py-3 text-secondary text-uppercase small">Subtotal</th>
                        <th class="text-center pe-3 py-3 text-secondary text-uppercase small" style="width: 110px;">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_comanda = 0.0;
                    foreach ($_SESSION['cistell'] as $id => $quantitat):
                        if (isset($productes[$id])):
                            $producte = $productes[$id];
                            $subtotal = $producte['preu'] * $quantitat;
                            $total_comanda += $subtotal;
                    ?>
                        <tr>
                            <td class="ps-3 fw-semibold text-dark">
                                <?= htmlspecialchars($producte['nom']) ?>
                            </td>
                            <td class="text-end text-muted">
                                <?= number_format($producte['preu'], 2) ?> €
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-2 py-1">
                                    <?= (int) $quantitat ?>
                                </span>
                            </td>
                            <td class="text-end fw-bold text-dark">
                                <?= number_format($subtotal, 2) ?> €
                            </td>
                            <td class="text-center pe-3">
                                <a href="cistell.php?accio=eliminar&id=<?= $id ?>"
                                    class="btn btn-outline-danger btn-sm"
                                    title="Eliminar línia"
                                    onclick="return confirm('Segur que vols eliminar aquest producte?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </tbody>
                <tfoot class="table-light border-top">
                    <tr>
                        <td colspan="3" class="ps-3 text-end fw-bold text-uppercase small py-3">Total a Pagar:</td>
                        <td class="text-end fw-bold text-primary fs-5 py-3">
                            <?= number_format($total_comanda, 2) ?> €
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Botons d'acció de la comanda -->
    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
        <a href="cistell.php?accio=buidar"
            class="btn btn-outline-secondary order-2 order-sm-1"
            onclick="return confirm('Segur que vols buidar tot el cistell?');">
            Buidar Cistell
        </a>
        <a href="cistell.php?accio=finalitzar"
            class="btn btn-success fw-bold px-4 py-2 order-1 order-sm-2">
            Confirmar Comanda
        </a>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc/peu.php'; ?>