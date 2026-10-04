<?php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';


// Array de països i capitals donat a l'enunciat
$ceu = [
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid",
    "Sweden" => "Stockholm",
    "United Kingdom" => "London",
    "Cyprus" => "Nicosia",
    "Lithuania" => "Vilnius",
    "Czech Republic" => "Prague",
    "Estonia" => "Tallinn",
    "Hungary" => "Budapest",
    "Latvia" => "Riga",
    "Malta" => "Valletta",
    "Austria" => "Vienna",
    "Poland" => "Warsaw"
];

// GET per a cerques i filtres
$cerca = isset($_GET['cerca']) ? trim($_GET['cerca']) : '';
$lletraTriada = isset($_GET['lletra']) ? trim($_GET['lletra']) : 'all';

// Ordenar l'array per capital mantenint el país
$capitalsOrdenades = ordenarPerCapital($ceu);

// Cerca parcial i/o filtrat per lletra inicial del país
$lletraFiltre = ($lletraTriada === 'all') ? '' : $lletraTriada;
$capitalsFiltrades = filtrarCapitals($capitalsOrdenades, $cerca, $lletraFiltre);

// Obtenim totes les inicials disponibles per al desplegable
$lletresDisponibles = obtenirLletresInicials($ceu);
?>

<div class="mb-4 pb-2 border-bottom">
    <h2 class="h3 fw-bold mb-0">Capitals Europees</h2>
</div>

<!-- Requisit: Formulari amb action="" i GET per a cerca i filtres -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="cerca" class="form-label fw-semibold">Cerca per país o capital:</label>
                <input type="text" class="form-control" name="cerca" id="cerca" 
                       value="<?= htmlspecialchars($cerca) ?>" placeholder="Ex: Spain, Paris...">
            </div>
            <div class="col-md-4">
                <label for="lletra" class="form-label fw-semibold">Filtrar per lletra inicial:</label>
                <select name="lletra" id="lletra" class="form-select">
                    <option value="all" <?= $lletraTriada === 'all' ? 'selected' : '' ?>>Totes</option>
                    <?php foreach ($lletresDisponibles as $lletra): ?>
                        <option value="<?= htmlspecialchars($lletra) ?>" <?= $lletraTriada === $lletra ? 'selected' : '' ?>>
                            <?= htmlspecialchars($lletra) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 flex-grow-1">Cercar</button>
                <?php if ($cerca !== '' || $lletraTriada !== 'all'): ?>
                    <a href="ex1.php" class="btn btn-outline-secondary">Netejar</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Taula de resultats segons captura pàgina 4 -->
<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Llistat de Capitals (ordenades per capital)</span>
        <span class="badge bg-secondary"><?= count($capitalsFiltrades) ?> països</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($capitalsFiltrades)): ?>
            <div class="p-4 text-center text-muted">
                No s'ha trobat cap país ni capital que coincideixi amb els criteris de cerca.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">País</th>
                            <th>Capital</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($capitalsFiltrades as $pais => $capital): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= htmlspecialchars($pais) ?></td>
                                <td><?= htmlspecialchars($capital) ?></td>
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