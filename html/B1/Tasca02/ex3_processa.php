<?php

// TODO: Definir la funció o funcions per convertir entre escales (Celsius, Fahrenheit, Kelvin)

function conversioTemperatura(string $escala_origen, string $escala_desti, float $temperatura): float
{
    return match ([$escala_origen, $escala_desti]) {
        ['celsius', 'fahrenheit'] => ($temperatura * 9 / 5) + 32,
        ['celsius', 'kelvin']     => $temperatura + 273.15,
        ['fahrenheit', 'celsius'] => ($temperatura - 32) * 5 / 9,
        ['fahrenheit', 'kelvin']  => ($temperatura - 32) * 5 / 9 + 273.15,
        ['kelvin', 'celsius']     => $temperatura - 273.15,
        ['kelvin', 'fahrenheit']  => ($temperatura - 273.15) * 9 / 5 + 32,
        default                   => null, // En cas que no es compleixi cap condició
    };
}
// TODO: Rebre les dades del formulari ($_POST o $_GET)
$escala_origen = $_POST['escala_origen'];
$escala_desti = $_POST['escala_desti'];
$temperatura = $_POST['temperatura'];

// TODO: Cridar la funció de conversió corresponent
$resultat = conversioTemperatura($escala_origen, $escala_desti, $temperatura);

// TODO: Mostrar el resultat de la conversió (ex: 12 Fahrenheit = -11.1111111111 Celsius)
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 3 - Resultat Conversió</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 3 - Resultat</h2>
            <a href="ex3.php" class="boto-tornar">← Tornar al formulari</a>
        </header>

        <div class="resultat">
            <!-- TODO: Mostrar el resultat de la conversió (ex: 12 Fahrenheit = -11.1111111111 Celsius) -->

        </div>

        <div style="margin-top: 20px;">
            <a href="index.php" style="font-size: 0.9em; text-decoration: underline;">Tornar a l'índex principal</a>
        </div>
    </div>
</body>

</html>