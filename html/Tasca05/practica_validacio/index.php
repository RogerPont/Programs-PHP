<?php
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici</title>
</head>
<body>
    <h1>Benvingut/da al Sistema</h1>
    <p>Aqui tenim un sistema de validacio de entrada antiXSS mitjançant htmlspecialchars() amb PHP i les funcions preg_match() 
        per validar que els camps nom, cognoms i nom_usuari estiguin formats exclusivament per caracters alfabetics.
        Tambe fem validacio per comprovar que l'email sigui correcte, que la contrasenya i la seva confirmacio coincideixin,
        i que els camps de text no estiguin buits. Sistema AntiBurles 100% Funcional i Comprat amb els millors Programadors
        del mon! </p>
    <a href="registre.php">Registre d'Usuari</a>
</body>
<footer>
    <p>copyright <?= date('Y') ?> Roger Pont Ponsà</p>
</footer>
</html>