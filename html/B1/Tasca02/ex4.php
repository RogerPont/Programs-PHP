
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercici 4 - Validador de Contrasenyes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenidor" style="max-width: 600px;">
        <header class="capcalera" style="display: flex; justify-content: space-between; align-items: center;">
            <h2>Exercici 4</h2>
            <a href="index.php" class="boto-tornar">← Tornar a l'índex</a>
        </header>

        <p><strong>Enunciat:</strong> Validador de contrasenyes mitjançant un formulari per POST i una funció de validació (sense expressions regulars).</p>
        <ul style="margin-bottom: 15px; font-size: 0.9em; opacity: 0.85;">
            <li>Almenys 8 caràcters de longitud.</li>
            <li>Conté almenys una lletra majúscula.</li>
            <li>Conté almenys un número.</li>
            <li>Conté almenys un caràcter especial (com ara @, #, $, etc.).</li>
        </ul>

        <!-- Formulari enviat per mètode POST cap a ex4_processa.php -->
        <form action="ex4_processa.php" method="post">
            <label for="contrasenya">Contrasenya:</label>
            <input type="password" id="contrasenya" name="contrasenya" placeholder="Introdueix la contrasenya" required>
            
            <input type="submit" value="Validar Contrasenya">
        </form>
    </div>
</body>
</html>
