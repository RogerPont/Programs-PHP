<?php

// TODO: Declarar l'array bidimensional amb els mesos i el nombre de dies

$array=array(
    array("Gener","Febrer","Març","Abril","Maig","Juny","Juliol","Agost","Septembre","Octubre","Novembre","Desembre"),
    array("31","28/29","31","30","31","30","31","31","30","31","30","31")
);


// TODO: Definir la funció que rep el mes i retorna els dies corresponents
function diesMes(string $mes, $dades){
    foreach ($dades as $value) {
        if ($value[0] == $mes) {
            return $value[1];
        }
    }
    return "Mes no trobat";
}


// TODO: Rebre el mes passat per $_GET

$mes = $_GET['mes'];

// TODO: Cridar la funció i obtenir el resultat
$dies = diesMes($mes,$array);

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 2 - Resultat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 2 - Resultat</h2>
            <a href="ex2.php" class="boto-tornar">← Tornar al formulari</a>
        </header>

        <div class="resultat">
            <!-- TODO: Mostrar el resultat indicant quants dies té el mes consultat -->
            <p><strong>Mes:</strong> <?= htmlspecialchars($mes) ?></p>
            <p><strong>Dies:</strong> <?= htmlspecialchars($dies) ?></p>
        </div>

        <div style="margin-top: 20px;">
            <a href="index.php" style="font-size: 0.9em; text-decoration: underline;">Tornar a l'índex principal</a>
        </div>
    </div>
</body>
</html>
