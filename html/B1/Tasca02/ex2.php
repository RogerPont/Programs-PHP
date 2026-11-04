<?php
/**
 * TASCA-02: Funcions en PHP
 * Exercici 2: Declara un array de 2 dimensions amb els mesos i el nombre de dies corresponent.
 * Fes una funció que donat un mes que passem per GET ens digui quants dies té.
 */
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 2 - Dies del Mes</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 2</h2>
            <a href="index.php" class="boto-tornar">← Tornar a l'índex</a>
        </header>

        <p><strong>Enunciat:</strong> Declara un array de 2 dimensions amb els mesos i el nombre de dies corresponent.
            Fes una funció que donat un mes que passem per GET ens digui quants dies té.</p>

        <!-- Formulari enviat per mètode GET cap a ex2_processa.php -->
        <form action="ex2_processa.php" method="get">
            <!-- TODO: Afegeix aquí el camp per triar o escriure el mes (input text, select, etc.) i el botó per enviar -->
            <label for="mes">Mes:</label>
            <input type="text" id="mes" name="mes" placeholder="Escriu o tria un mes"required>
            <details id="llista-mesos">
                <option value="Gener">Gener</option>
                <option value="Febrer">Febrer</option>
                <option value="Març">Març</option>
                <option value="Abril">Abril</option>
                <option value="Maig">Maig</option>
                <option value="Juny">Juny</option>
                <option value="Juliol">Juliol</option>
                <option value="Agost">Agost</option>
                <option value="Septembre">Septembre</option>
                <option value="Octubre">Octubre</option>
                <option value="Novembre">Novembre</option>
                <option value="Desembre">Desembre</option>
            </details>
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>

</html>