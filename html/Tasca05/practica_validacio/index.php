<?php
// Definim el títol de la pàgina i incloem la capçalera comuna
$titol = 'Benvingut/da al Sistema';
include __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="badge-estat">
        <span class="badge-dot"></span> Sistema de Seguretat Actiu
    </div>
    <h1>Benvingut/da al Sistema</h1>
    <p class="descripcio">
        Plataforma de registre d'usuaris amb arquitectura de validació robusta al servidor, protecció contra atacs CSRF mitjançant tokens criptogràfics, escapament contra injeccions XSS amb <code>htmlspecialchars()</code> i persistència de dades.
    </p>

    <div class="llista-caracteristiques">
        <div class="item-caracteristica">
            <span class="icona-check"></span> Protecció CSRF per sessió
        </div>
        <div class="item-caracteristica">
            <span class="icona-check"></span> Filtres i sanejament XSS
        </div>
        <div class="item-caracteristica">
            <span class="icona-check"></span> Validació tipificada al servidor
        </div>
    </div>

    <div class="destacat">
        <a href="registre.php" class="boto-destacat">
            <span>Comença el Registre d'Usuari</span>
            <span class="fletxa-dreta"></span>
        </a>
    </div>
</main>

<?php
include __DIR__ . '/includes/footer.php';
?>