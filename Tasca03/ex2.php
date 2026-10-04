<?php
require_once __DIR__ . '/includes/functions.php';

// Array de temperatures inicial en Fahrenheit segons l'enunciat
$temperaturesInicials = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73,
    68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73
];

// Mantenir l'estat amb camps ocults en servir type="hidden"
$temperatures = $temperaturesInicials;
$missatgeError = '';
$missatgeExit = '';

// Recuperem les dades serialitzades de l'estat previ si existeixen
$dadesEstat = $_POST['temperatures_data'] ?? $_GET['temperatures_data'] ?? null;
if (!empty($dadesEstat)) {
    $descodificat = json_decode($dadesEstat, true);
    if (is_array($descodificat)) {
        $temperatures = $descodificat;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['afegir_temp'])) {
    $novaTemp = trim($_POST['nova_temperatura'] ?? '');
    if ($novaTemp === '' || !is_numeric($novaTemp)) {
        $missatgeError = "Si us plau, introdueix un valor numèric vàlid per a la temperatura.";
    } else {
        $temperatures[] = (float) $novaTemp;
        $missatgeExit = "Temperatura afegida correctament (" . htmlspecialchars($novaTemp) . " °F).";
    }
}

// GET per a cerques i filtres (en aquest cas, canvi d'escala F / C)
$escala = isset($_GET['escala']) && $_GET['escala'] === 'C' ? 'C' : 'F';
$simbol = $escala === 'C' ? '°C' : '°F';

// Convertim les temperatures segons l'escala triada per a les estadístiques
$tempMostrades = array_map(function ($t) use ($escala) {
    return $escala === 'C' ? fahrenheiaCelsius((float)$t) : (float)$t;
}, $temperatures);

// Càlculs estadístics amb les funcions de functions.php
$mitjana = calcularMitjana($tempMostrades);
$mediana = calcularMediana($tempMostrades);
$maxima = temperaturaMaxima($tempMostrades);
$minima = temperaturaMinima($tempMostrades);

$topAltes = temperaturesAltes($tempMostrades, 5);
$topBaixes = temperaturesBaixes($tempMostrades, 5);

// Per a la taula inferior, mostrem totes les temperatures ordenades com a la captura
$totesOrdenades = $tempMostrades;
sort($totesOrdenades, SORT_NUMERIC);

// Serialitzem l'array actual per al camp hidden
$temperatures_data = htmlspecialchars(json_encode($temperatures));

include __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <h2 class="h3 fw-bold mb-0">Anàlisi de Temperatures</h2>
    <div>
        <span class="text-muted small me-2">Escala de temperatura:</span>
        <div class="btn-group" role="group">
            <a href="?escala=F&temperatures_data=<?= urlencode(json_encode($temperatures)) ?>" 
               class="btn btn-sm <?= $escala === 'F' ? 'btn-primary' : 'btn-outline-primary' ?>">
                Fahrenheit
            </a>
            <a href="?escala=C&temperatures_data=<?= urlencode(json_encode($temperatures)) ?>" 
               class="btn btn-sm <?= $escala === 'C' ? 'btn-primary' : 'btn-outline-primary' ?>">
                Celsius
            </a>
        </div>
    </div>
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

<!-- Formulari d'afegir nova temperatura (POST amb camp hidden de dades) -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="" method="POST" class="row g-3 align-items-end">
            <!-- Estat persistent en camp hidden -->
            <input type="hidden" name="temperatures_data" value="<?= $temperatures_data ?>">
            <div class="col-md-6 col-lg-5">
                <label for="nova_temperatura" class="form-label fw-semibold">
                    Afegir nova temperatura (<?= htmlspecialchars($simbol) ?>):
                </label>
                <input type="number" step="any" class="form-control" id="nova_temperatura" name="nova_temperatura" placeholder="Ex: 75.5" required>
            </div>
            <div class="col-auto">
                <button type="submit" name="afegir_temp" class="btn btn-primary px-4">
                    Afegir
                </button>
            </div>
            <div class="col-auto ms-auto">
                <a href="ex2.php" class="btn btn-outline-secondary btn-sm" onclick="return confirm('Vols restablir les temperatures als valors inicials?');">
                    Restablir valors inicials
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Panells d'Estadístiques Bàsiques i Top 5 (com a la captura de la pàgina 6) -->
<div class="row g-4 mb-4">
    <!-- Columna 1: Estadístiques Bàsiques -->
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Estadístiques Bàsiques
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <tbody>
                        <tr>
                            <td class="ps-3 text-muted">Mitjana:</td>
                            <td class="text-end pe-3 fw-bold"><?= number_format($mitjana, 2) ?><?= htmlspecialchars($simbol) ?></td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">Mediana:</td>
                            <td class="text-end pe-3 fw-bold"><?= number_format($mediana, 2) ?><?= htmlspecialchars($simbol) ?></td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">Temperatura màxima:</td>
                            <td class="text-end pe-3 fw-bold text-danger"><?= number_format($maxima, 2) ?><?= htmlspecialchars($simbol) ?></td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">Temperatura mínima:</td>
                            <td class="text-end pe-3 fw-bold text-primary"><?= number_format($minima, 2) ?><?= htmlspecialchars($simbol) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Columna 2: Top 5 Temperatures -->
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Top 5 Temperatures
            </div>
            <div class="card-body p-0">
                <div class="p-3 pb-1 border-bottom">
                    <h6 class="text-danger fw-semibold mb-2">Més altes:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($topAltes as $t): ?>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-6 px-3 py-2">
                                <?= number_format($t, 2) ?><?= htmlspecialchars($simbol) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="p-3">
                    <h6 class="text-primary fw-semibold mb-2">Més baixes:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($topBaixes as $t): ?>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6 px-3 py-2">
                                <?= number_format($t, 2) ?><?= htmlspecialchars($simbol) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Taula inferior amb totes les temperatures -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Totes les temperatures</span>
        <span class="badge bg-secondary"><?= count($temperatures) ?> registres</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th class="ps-3" style="width: 80px;">#</th>
                        <th>Temperatura (<?= htmlspecialchars($simbol) ?>)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($totesOrdenades as $idx => $t): ?>
                        <tr>
                            <td class="ps-3 text-muted"><?= $idx + 1 ?></td>
                            <td class="fw-semibold"><?= number_format($t, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>