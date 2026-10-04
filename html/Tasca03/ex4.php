<?php
require_once __DIR__ . '/includes/functions.php';

$nivells = ["Bàsic", "Mitjà", "Perfeccionament"];
$idiomes = ["Anglès", "Francès", "Alemany", "Rus"];

// Estat inicial de l'acadèmia
$academia = obtenirAcademiaPerDefecte();
$missatgeError = '';
$missatgeExit = '';

// Mantenir l'estat mitjançant camp ocult
$dadesEstat = $_POST['academia_data'] ?? $_GET['academia_data'] ?? null; 
if (!empty($dadesEstat)) {
    $descodificat = json_decode($dadesEstat, true); // json_decode es converteix el string en JSON del camp ocult en un array associatiu.
    if (is_array($descodificat)) { // is_array es un metode per comprovar si una variable es un array.
        $academia = $descodificat;
    }
}

// POST per afegir, modificar (moure) o eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Afegir alumne a un grup
    if (isset($_POST['afegir_alumne'])) {
        $nom = trim($_POST['nom_alumne'] ?? ''); // trim es una funcio que treu els espais en blanc de les dades de l'usuari.
        $nivell = $_POST['nivell'] ?? '';
        $idioma = $_POST['idioma'] ?? '';

        if ($nom === '') { // Si el nom es buit llavors mostrem un error.
            $missatgeError = "El nom de l'alumne no pot estar buit.";
        } elseif (!isset($academia[$nivell][$idioma])) {
            $missatgeError = "El grup seleccionat no és vàlid.";
        } else {
            // Evitar duplicats en el mateix grup
            if (in_array($nom, $academia[$nivell][$idioma])) { // in_array simplement es si esta dins de aquell array per tant fa la comprovacio de si esta inclos.
                $missatgeError = "L'alumne '" . htmlspecialchars($nom) . "' ja està matriculat a aquest grup.";
            } else {
                $academia[$nivell][$idioma][] = $nom;
                $missatgeExit = "S'ha afegit '" . htmlspecialchars($nom) . "' al grup $idioma ($nivell).";
            }
        }
    }

    // Eliminar alumne
    if (isset($_POST['eliminar_alumne'])) {
        $nom = trim($_POST['nom_a_eliminar'] ?? '');
        $nivell = $_POST['nivell_eliminar'] ?? '';
        $idioma = $_POST['idioma_eliminar'] ?? '';

        if (isset($academia[$nivell][$idioma])) {
            $clau = array_search($nom, $academia[$nivell][$idioma]);
            if ($clau !== false) {
                unset($academia[$nivell][$idioma][$clau]);
                // Reindexar array
                $academia[$nivell][$idioma] = array_values($academia[$nivell][$idioma]);
                $missatgeExit = "S'ha donat de baixa l'alumne '" . htmlspecialchars($nom) . "'.";
            }
        }
    }
    // Fem post de tot l'array amb les temperatures inicials i les noves temperatures afegides i amb els camps ocults.
    if (isset($_POST['moure_alumne'])) {
        $nom = trim($_POST['nom_moure'] ?? '');
        $nivellOrigen = $_POST['nivell_origen'] ?? '';
        $idiomaOrigen = $_POST['idioma_origen'] ?? '';
        $nivellDesti = $_POST['nivell_desti'] ?? '';
        $idiomaDesti = $_POST['idioma_desti'] ?? '';

        if (!isset($academia[$nivellOrigen][$idiomaOrigen]) || !isset($academia[$nivellDesti][$idiomaDesti])) {
            $missatgeError = "Grup d'origen o destí no vàlid.";
        } elseif ($nivellOrigen === $nivellDesti && $idiomaOrigen === $idiomaDesti) {
            $missatgeError = "El grup de destí ha de ser diferent del d'origen.";
        } else {
            $clau = array_search($nom, $academia[$nivellOrigen][$idiomaOrigen]);
            if ($clau === false) {
                $missatgeError = "No s'ha trobat l'alumne al grup d'origen.";
            } else {
                // Eliminar d'origen i afegir a destí
                unset($academia[$nivellOrigen][$idiomaOrigen][$clau]);
                $academia[$nivellOrigen][$idiomaOrigen] = array_values($academia[$nivellOrigen][$idiomaOrigen]);
                $academia[$nivellDesti][$idiomaDesti][] = $nom;
                $missatgeExit = "S'ha mogut '" . htmlspecialchars($nom) . "' a $idiomaDesti ($nivellDesti).";
            }
        }
    }
}

// GET per a cerques
$cercaNom = isset($_GET['cerca_alumne']) ? trim($_GET['cerca_alumne']) : '';
$resultatsCerca = [];
if ($cercaNom !== '') {
    $resultatsCerca = cercarAlumne($academia, $cercaNom);
}

// Càlculs d'estadístiques amb les funcions requerides
$totalAlumnes = comptarTotalAlumnes($academia);
$totalPerIdioma = TotalPerIdioma($academia);
$grupMes = MesNombros($academia);
$grupMenys = MenysNombros($academia);
$mitjanaPerNivell = MitjanaPerNivell($academia);
$mitjanaPerIdioma = MitjanaPerIdioma($academia);

$jsonAcademia = htmlspecialchars(json_encode($academia));

include __DIR__ . '/includes/header.php';
?>

<div class="mb-4 pb-2 border-bottom">
    <h2 class="h3 fw-bold mb-0">Gestió d'Acadèmia d'Idiomes</h2>
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

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white fw-bold">
        Cercar alumne
    </div>
    <div class="card-body">
        <form action="" method="GET" class="row g-3">
            <input type="hidden" name="academia_data" value="<?= $jsonAcademia ?>">
            <div class="col-md-9">
                <input type="text" name="cerca_alumne" class="form-control"
                    placeholder="Introdueix el nom de l'alumne..." value="<?= htmlspecialchars($cercaNom) ?>">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Cercar</button>
                <?php if ($cercaNom !== ''): ?>
                    <a href="ex4.php?academia_data=<?= urlencode(json_encode($academia)) ?>"
                        class="btn btn-outline-secondary">Netejar</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if ($cercaNom !== ''): ?>
            <div class="mt-3">
                <?php if (empty($resultatsCerca)): ?>
                    <div class="alert alert-warning mb-0 py-2">
                        No s'ha trobat cap alumne amb el nom "<strong><?= htmlspecialchars($cercaNom) ?></strong>".
                    </div>
                <?php else: ?>
                    <div class="alert alert-info mb-0 py-2">
                        Coincidències trobades:
                        <ul class="mb-0 mt-1">
                            <?php foreach ($resultatsCerca as $r): ?>
                                <li>
                                    <strong><?= htmlspecialchars($r['nom']) ?></strong> pertany al grup de
                                    <strong><?= htmlspecialchars($r['idioma']) ?></strong> (Nivell
                                    <?= htmlspecialchars($r['nivell']) ?>).
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Matriu de Grups i Alumnes</span>
        <span class="badge bg-primary">Total: <?= $totalAlumnes ?> alumnes</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 15%;">Nivell \ Idioma</th>
                        <?php foreach ($idiomes as $idioma): ?>
                            <th class="text-center" style="width: 21.25%;">
                                <?= htmlspecialchars($idioma) ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($nivells as $nivell): ?>
                        <tr>
                            <th class="ps-3 table-light"><?= htmlspecialchars($nivell) ?></th>
                            <?php foreach ($idiomes as $idioma): ?>
                                <?php $llistaAlumnes = $academia[$nivell][$idioma] ?? []; ?>
                                <td class="p-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom">
                                        <span class="badge bg-secondary-subtle text-dark"><?= count($llistaAlumnes) ?>
                                            alumnes</span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php if (empty($llistaAlumnes)): ?>
                                            <span class="text-muted small fst-italic">Cap alumne</span>
                                        <?php else: ?>
                                            <?php foreach ($llistaAlumnes as $alumne): ?>
                                                <span class="badge bg-light text-dark border d-inline-flex align-items-center gap-1">
                                                    <?= htmlspecialchars($alumne) ?>
                                                    <form action="" method="POST" class="d-inline m-0 p-0"
                                                        onsubmit="return confirm('Donar de baixa aquest alumne?');">
                                                        <input type="hidden" name="academia_data" value="<?= $jsonAcademia ?>">
                                                        <input type="hidden" name="nom_a_eliminar"
                                                            value="<?= htmlspecialchars($alumne) ?>">
                                                        <input type="hidden" name="nivell_eliminar"
                                                            value="<?= htmlspecialchars($nivell) ?>">
                                                        <input type="hidden" name="idioma_eliminar"
                                                            value="<?= htmlspecialchars($idioma) ?>">
                                                        <button type="submit" name="eliminar_alumne" class="btn-close btn-close-sm"
                                                            style="font-size: 0.55rem;" aria-label="Eliminar"></button>
                                                    </form>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Afegir Alumne
            </div>
            <div class="card-body">
                <form action="" method="POST" class="row g-3">
                    <input type="hidden" name="academia_data" value="<?= $jsonAcademia ?>">
                    <div class="col-12">
                        <label for="nom_alumne" class="form-label fw-semibold">Nom:</label>
                        <input type="text" class="form-control" name="nom_alumne" id="nom_alumne"
                            placeholder="Ex: Maria Puig" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nivell" class="form-label fw-semibold">Nivell:</label>
                        <select name="nivell" id="nivell" class="form-select">
                            <?php foreach ($nivells as $n): ?>
                                <option value="<?= htmlspecialchars($n) ?>"><?= htmlspecialchars($n) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="idioma" class="form-label fw-semibold">Idioma:</label>
                        <select name="idioma" id="idioma" class="form-select">
                            <?php foreach ($idiomes as $i): ?>
                                <option value="<?= htmlspecialchars($i) ?>"><?= htmlspecialchars($i) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="afegir_alumne" class="btn btn-success w-100">Afegir Alumne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Moure Alumne entre grups
            </div>
            <div class="card-body">
                <form action="" method="POST" class="row g-3">
                    <input type="hidden" name="academia_data" value="<?= $jsonAcademia ?>">
                    <div class="col-12">
                        <label for="nom_moure" class="form-label fw-semibold">Nom de l'alumne:</label>
                        <input type="text" class="form-control" name="nom_moure" id="nom_moure"
                            placeholder="Nom exacte de l'alumne" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted">Origen (Nivell / Idioma):</label>
                        <select name="nivell_origen" class="form-select form-select-sm mb-1">
                            <?php foreach ($nivells as $n): ?>
                                <option value="<?= htmlspecialchars($n) ?>"><?= htmlspecialchars($n) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="idioma_origen" class="form-select form-select-sm">
                            <?php foreach ($idiomes as $i): ?>
                                <option value="<?= htmlspecialchars($i) ?>"><?= htmlspecialchars($i) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted">Destí (Nivell / Idioma):</label>
                        <select name="nivell_desti" class="form-select form-select-sm mb-1">
                            <?php foreach ($nivells as $n): ?>
                                <option value="<?= htmlspecialchars($n) ?>"><?= htmlspecialchars($n) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="idioma_desti" class="form-select form-select-sm">
                            <?php foreach ($idiomes as $i): ?>
                                <option value="<?= htmlspecialchars($i) ?>"><?= htmlspecialchars($i) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="moure_alumne" class="btn btn-primary w-100">Moure Alumne</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white fw-bold">
        Tasca 3: Estadístiques de l'Acadèmia
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="fw-bold text-muted border-bottom pb-2">Alumnes per Idioma</h6>
                <ul class="list-group list-group-flush mb-3">
                    <?php foreach ($totalPerIdioma as $idioma => $tot): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <?= htmlspecialchars($idioma) ?>
                            <span class="badge bg-primary rounded-pill"><?= $tot ?> alumnes (Mitjana:
                                <?= $mitjanaPerIdioma[$idioma] ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold text-muted border-bottom pb-2">Mitjana per Nivell</h6>
                <ul class="list-group list-group-flush mb-3">
                    <?php foreach ($mitjanaPerNivell as $nivell => $mitj): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Nivell <?= htmlspecialchars($nivell) ?>
                            <span class="badge bg-info-subtle text-dark border"><?= $mitj ?> alumnes/idioma</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row g-3 text-center">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <span class="text-muted d-block small">Grup Més Nombrós</span>
                    <strong class="fs-5 text-success">
                        <?= htmlspecialchars($grupMes['idioma']) ?> (<?= htmlspecialchars($grupMes['nivell']) ?>)
                    </strong>
                    <div class="small text-muted mt-1"><?= $grupMes['total'] ?> alumnes</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded border">
                    <span class="text-muted d-block small">Grup Menys Nombrós</span>
                    <strong class="fs-5 text-warning">
                        <?= htmlspecialchars($grupMenys['idioma']) ?> (<?= htmlspecialchars($grupMenys['nivell']) ?>)
                    </strong>
                    <div class="small text-muted mt-1"><?= $grupMenys['total'] ?> alumnes</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>