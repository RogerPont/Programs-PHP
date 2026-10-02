<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 3 - Conversor de Temperatura</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 3</h2>
            <a href="index.php" class="boto-tornar">← Tornar a l'índex</a>
        </header>

        <p><strong>Enunciat:</strong> Fes una pàgina on a partir d'un formulari on es recull una temperatura i en quina escala està, ens fa la conversió.</p>

        <!-- Formulari cap a ex3_processa.php -->
        <form action="ex3_processa.php" method="post">
            <!-- TODO: Afegeix aquí els selectors d'escala d'origen (Fahrenheit, Celsius, Kelvin), el camp de temperatura, els selectors d'escala de destí i el botó per enviar -->
             <select  name="escala_origen" id="escala_origen">
                <option value="">Escala d'origen</option>
                <option value="celsius">Celsius</option>
                <option value="fahrenheit">Fahrenheit</option>
                <option value="kelvin">Kelvin</option>
             </select>
             <input type="number" name="temperatura" id="temperatura">
             <select  name="escala_desti" id="escala_desti">
                <option value="">Escala de destí</option>
                <option value="celsius">Celsius</option>
                <option value="fahrenheit">Fahrenheit</option>
                <option value="kelvin">Kelvin</option>
             </select>
             <input type="submit" value="Convertir">
            
        </form>
    </div>
</body>
</html>
