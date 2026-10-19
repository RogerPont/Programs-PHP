<?php

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$camps = ['nom', 'cognoms', 'edat', 'email', 'telefon', 'poblacio'];
foreach ($camps as $camp) {
    $$camp = $$camp ?? '';
}

$titol = "Registre d'Usuari";
include __DIR__ .'/includes/header.php';

?>
    <h1>Registre d'Usuari</h1>
    <form action="valida_registre.php" method="POST">
        <label for="nom">Nom</label><br>
        <input type="text" name="nom" id="" value="<?= htmlspecialchars($nom) ?>"><br>
        <label for="cognoms">Cognoms</label><br>
        <input type="text" name="cognoms" id="" value="<?= htmlspecialchars($cognoms) ?>"><br>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="" value="<?= htmlspecialchars($email) ?>"><br>
        <label for="edat">Edat (anys)</label><br>
        <input type="text" name="edat" id="" value="<?= htmlspecialchars($edat) ?>"><br>
        <label for="telefon">Telèfon</label><br>
        <input type="text" name="telefon" id="" value="<?= htmlspecialchars($telefon) ?>"><br>
        <label for="poblacio">Població</label><br>
        <input type="text" name="poblacio" id="" value="<?= htmlspecialchars($poblacio) ?>"><br>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <button type="submit">Registrar</button>
    </form>
    <a href="index.php">Tornar a l'inici</a>
<?php
    include __DIR__ .'/includes/footer.php';
?>