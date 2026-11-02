<?php
// Iniciem la sessió per recuperar les dades validades
session_start();

// Si s'hi accedeix sense dades validades a la sessió, redirigir a registre.php
if (empty($_SESSION['dades_validades'])) {
    header('Location: registre.php');
    exit;
}

// Recuperar les dades validades i esborrar-les de la sessió
$dades = $_SESSION['dades_validades'];
unset($_SESSION['dades_validades']);

$titol = 'Resultat del Registre';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="badge-estat badge-exit">
        <span class="badge-dot badge-dot-exit"></span>
        Registre completat
    </div>

    <h1>Resultat del Registre</h1>
    <p class="subtitol">Les dades s'han validat amb èxit. A continuació es mostra el resum del registre:</p>

    <table class="taula-resultats">
        <tbody>
            <tr>
                <th>Nom</th>
                <td><?= htmlspecialchars((string)($dades['nom'] ?? '')) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars((string)($dades['email'] ?? '')) ?></td>
            </tr>
            <tr>
                <th>Edat</th>
                <td><?= htmlspecialchars((string)($dades['edat'] ?? '')) ?></td>
            </tr>
            <tr>
                <th>Telèfon</th>
                <td><?= !empty($dades['telefon']) ? htmlspecialchars((string)$dades['telefon']) : 'No indicat' ?></td>
            </tr>
            <tr>
                <th>Població</th>
                <td><?= htmlspecialchars((string)($dades['poblacio'] ?? '')) ?></td>
            </tr>
        </tbody>
    </table>

    <p><a href="index.php" class="enllac-tornar">&larr; Tornar a l'inici</a></p>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>
