<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasca03</title>
    <!-- Posat el Bootstrap requerit a la pràctica -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <form action="" method="GET" class="mb-4">
        <label for="cerca">Cerca per país o capital:</label>
        <input type="text" name="cerca" id="cerca">
        <label for="ordenarCapitals">Filtrar per lletra inicial</label>
        <select name="filtrador" id="filtrador">
            <option value="all">Totes</option>
            <option value="asc">Ascendent</option>
            <option value="desc">Descendent</option>
        </select>
        <input type="submit" value="Cercar" name="ordenarCapitals">
    </form>
    <?php
    if (isset($_GET["ordenarCapitals"])) {
        include "./Tasca03/includes/functions.php";
        Form($_GET, $ceu);
    }
    ?>
</body>

</html>