<?php
$titol = 'Benvingut/da al Sistema';
include __DIR__ . '/includes/header.php';
?>

<main class="container">
    <h1>Benvingut/da al Sistema</h1>
    <p class="descripcio">
        Aquest és un sistema de registre d'usuaris amb validació robusta al servidor, protecció contra atacs CSRF mitjançant tokens criptogràfics, escapament contra injeccions XSS amb <code>htmlspecialchars()</code> i persistència de dades en cas d'error.
    </p>
    <div class="destacat">
        <a href="registre.php" class="boto-destacat">Registre d'Usuari</a>
    </div>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>