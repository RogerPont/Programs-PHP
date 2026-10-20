<?php
session_start();

// Generar token CSRF per a la sessió si encara no existeix
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Recuperar les dades anteriors i els errors si venim d'una redirecció
$dades = $_SESSION['dades'] ?? [];
$errors = $_SESSION['errors'] ?? [];

// Un cop llegits, esborrar de la sessió perquè no tornin a aparèixer en recarregar la pàgina (F5)
unset($_SESSION['dades']);
unset($_SESSION['errors']);

$titol = "Registre d'Usuari";
include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <h1>Registre d'Usuari</h1>

    <form action="valida_registre.php" method="POST" novalidate>
        <div class="camp-formulari">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" maxlength="50" required
                   value="<?= htmlspecialchars($dades['nom'] ?? '') ?>"
                   class="<?= isset($errors['nom']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['nom'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['nom']) ?></p>
            <?php endif; ?>
        </div>

        <div class="camp-formulari">
            <label for="cognoms">Cognoms</label>
            <input type="text" name="cognoms" id="cognoms" maxlength="50" required
                   value="<?= htmlspecialchars($dades['cognoms'] ?? '') ?>"
                   class="<?= isset($errors['cognoms']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['cognoms'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['cognoms']) ?></p>
            <?php endif; ?>
        </div>

        <div class="camp-formulari">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required
                   value="<?= htmlspecialchars($dades['email'] ?? '') ?>"
                   class="<?= isset($errors['email']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['email'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div class="camp-formulari">
            <label for="edat">Edat (anys)</label>
            <input type="text" name="edat" id="edat" required
                   value="<?= htmlspecialchars($dades['edat'] ?? '') ?>"
                   class="<?= isset($errors['edat']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['edat'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['edat']) ?></p>
            <?php endif; ?>
        </div>

        <div class="camp-formulari">
            <label for="telefon">Telèfon</label>
            <input type="text" name="telefon" id="telefon"
                   value="<?= htmlspecialchars($dades['telefon'] ?? '') ?>"
                   class="<?= isset($errors['telefon']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['telefon'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['telefon']) ?></p>
            <?php endif; ?>
        </div>

        <div class="camp-formulari">
            <label for="poblacio">Població</label>
            <input type="text" name="poblacio" id="poblacio" maxlength="50" required
                   value="<?= htmlspecialchars($dades['poblacio'] ?? '') ?>"
                   class="<?= isset($errors['poblacio']) ? 'camp-error' : '' ?>">
            <?php if (isset($errors['poblacio'])): ?>
                <p class="error-missatge"><?= htmlspecialchars($errors['poblacio']) ?></p>
            <?php endif; ?>
        </div>

        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <button type="submit" class="boto-enviar">Registrar</button>
    </form>

    <p><a href="index.php" class="enllac-tornar">&larr; Tornar a l'inici</a></p>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>