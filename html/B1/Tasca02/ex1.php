<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 1 - Àrea d'un Rectangle</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 1</h2>
            <a href="index.php" class="boto-tornar">← Tornar a l'índex</a>
        </header>

        <p><strong>Enunciat:</strong> Fes una funció per calcular l'àrea d'un rectangle. Les dades provenen d'un formulari i tenint en compte que la mida dels costats es passa per GET.</p>

        <!-- Formulari enviat per mètode GET cap a ex1_processa.php -->
        <form action="ex1_processa.php" method="get">
            <label for="base">Base (en cm o m):</label>
            <input type="number" id="base" name="base" step="any" min="0.01" placeholder="Ex: 10" required>
            
            <label for="altura">Altura (en cm o m):</label>
            <input type="number" id="altura" name="altura" step="any" min="0.01" placeholder="Ex: 5" required>
            
            <input type="submit" value="Calcular Àrea">
        </form>
    </div>
</body>
</html>
