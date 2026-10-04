<?php

require_once __DIR__ . '/includes/functions.php';

// Arrays inicials
$keysInicials = [
    "field1" => "first",
    "field2" => "second",
    "field3" => "third"
];

$valuesInicials = [
    "field1value" => "dinosaur",
    "field2value" => "pig",
    "field3value" => "platypus"
];


$combinatBucle = combinarArrayBucle($keysInicials, $valuesInicials);
$combinatNative = combinarArraysNative($keysInicials, $valuesInicials);

$missatgeError = '';
$missatgeExit = '';


$parellesActuals = $combinatNative;
if (!empty($_POST['dades_associatives'])) {
    $descodificat = json_decode($_POST['dades_associatives'], true);
    if (is_array($descodificat)) {
        $parellesActuals = $descodificat;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guardar_parella'])) {
        $key = trim($_POST['clau'] ?? '');
        $value = trim($_POST['valor'] ?? '');

        if ($key === '') {
            $missatgeError = "La clau no pot estar buida.";
        } else {
            $esModificacio = isset($parellesActuals[$key]);
            $parellesActuals[$key] = $value;
            $missatgeExit = $esModificacio 
                ? "S'ha modificat el valor de la clau '" . htmlspecialchars($key) . "'."
                : "S'ha afegit correctament la nova parella '" . htmlspecialchars($key) . "'.";
        }
    }
    if (isset($_POST['eliminar_clau'])) {
        $keyAEliminar = trim($_POST['key_a_eliminar'] ?? '');
        if (isset($parellesActuals[$keyAEliminar])) {
            unset($parellesActuals[$keyAEliminar]);
            $missatgeExit = "S'ha eliminat la parella amb clau '" . htmlspecialchars($keyAEliminar) . "'.";
        }
    }
}

$parelles_data = htmlspecialchars(json_encode($parellesActuals));

include __DIR__ . '/includes/header.php';
?>

<div class="mb-4 pb-2 border-bottom">
    <h2 class="h3 fw-bold mb-0">Arrays Associatius</h2>
</div>

<?php if (!empty($missatgeError)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($missatgeError) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($missatgeExit)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($missatgeExit) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Tasca 1: Combinat amb bucles
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded border mb-0"><code><?= htmlspecialchars(print_r($combinatBucle, true)) ?></code></pre>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Tasca 2: Combinat amb <code>array_combine()</code>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded border mb-0"><code><?= htmlspecialchars(print_r($combinatNative, true)) ?></code></pre>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white fw-bold">
        Tasca 3: Afegir o modificar parella clau-valor
    </div>
    <div class="card-body">
        <form action="" method="POST" class="row g-3 align-items-end">
            <!-- type hidden -->
            <input type="hidden" name="dades_associatives" value="<?= $parelles_data ?>">
            
            <div class="col-md-5">
                <label for="clau" class="form-label fw-semibold">Clau:</label>
                <input type="text" class="form-control" name="clau" id="clau" placeholder="Ex: fourth, animal..." required>
                <div class="form-text">Si la clau ja existeix, es modificarà el seu valor.</div>
            </div>
            <div class="col-md-5">
                <label for="valor" class="form-label fw-semibold">Valor:</label>
                <input type="text" class="form-control" name="valor" id="valor" placeholder="Ex: monkey, blue..." required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="guardar_parella" class="btn btn-primary w-100">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Llistat de parelles actuals amb accions -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Parelles Clau-Valor Actuals</span>
        <form action="" method="POST" class="d-inline m-0">
            <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Restablir valors inicials?');">
                Restablir
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <?php if (empty($parellesActuals)): ?>
            <div class="p-4 text-center text-muted">
                No hi ha cap parella a l'array. Pots afegir-ne una utilitzant el formulari superior.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 40%;">Clau</th>
                            <th style="width: 45%;">Valor</th>
                            <th class="text-end pe-4" style="width: 15%;">Accions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parellesActuals as $c => $v): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-secondary-subtle text-dark border px-2 py-1 font-monospace">
                                        <?= htmlspecialchars($c) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium text-primary">
                                        <?= htmlspecialchars($v) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <form action="" method="POST" class="d-inline" onsubmit="return confirm('Segur que vols eliminar aquesta clau?');">
                                        <input type="hidden" name="parelles_data" value="<?= $parelles_data ?>">
                                        <input type="hidden" name="clau_a_eliminar" value="<?= htmlspecialchars($c) ?>">
                                        <button type="submit" name="eliminar_clau" class="btn btn-outline-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>
