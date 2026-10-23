<?php
// Iniciem la sessió per accedir a les dades que hem validat
session_start();

// Si l'usuari entra directament sense dades validades a la sessió, el redirigim al registre
if (empty($_SESSION['dades_validades'])) {
    header('Location: registre.php');
    exit;
}

// Guardem les dades en una variable local per treballar més còmodament a la plantilla
$dades = $_SESSION['dades_validades'];

require_once __DIR__ . '/includes/header.php';
?>

<main class="container">
    <div class="badge-estat badge-exit">
        <span class="badge-dot badge-dot-exit"></span> Validat amb èxit
    </div>
    <h1>Registre completat amb èxit</h1>
    <p class="subtitol">Aquestes són les dades que s'han validat i processat correctament pel servidor:</p>
    <table class="taula-resultats">
        <tbody>
            <tr>
                <th>Nom:</th>
                <td><?= htmlspecialchars($dades['nom'] ?? '') ?></td>
            </tr>
            <!-- Si s'han introduït cognoms (camp opcional), mostrem la fila -->
            <?php if (!empty($dades['cognoms'])): ?>
            <tr>
                <th>Cognoms:</th>
                <td><?= htmlspecialchars($dades['cognoms'] ?? '') ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>Email:</th>
                <td><?= htmlspecialchars($dades['email'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Edat:</th>
                <td><?= htmlspecialchars((string)($dades['edat'] ?? '')) ?> anys</td>
            </tr>
            <tr>
                <th>Telèfon:</th>
                <td>
                    <!-- El telèfon és opcional; si no en tenim indiquem que no s'ha posat -->
                    <?php if (!empty($dades['telefon'])): ?>
                        <?= htmlspecialchars($dades['telefon']) ?>
                    <?php else: ?>
                        <em>No indicat</em>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Població:</th>
                <td><?= htmlspecialchars($dades['poblacio'] ?? '') ?></td>
            </tr>
        </tbody>
    </table>
    <p style="margin-top: 1.5rem;">
        <a href="index.php" class="enllac-tornar">&larr; Tornar a l'inici</a>
    </p>
</main>
<?php
include __DIR__ . '/includes/footer.php';
?>