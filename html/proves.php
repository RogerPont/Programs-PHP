<?php

declare(strict_types=1);

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom'], $_POST['tema'])) {
        $nom = $_POST['nom'];       
        $tema = $_POST['tema'];
        setcookie("nom", $nom, time() + 86400);
        setcookie("tema", $tema, time() + 86400);
    }
}
$nom = $_POST['nom'] ?? $_COOKIE['nom'] ?? '';
$tema_pref = isset($_COOKIE['tema']) ? $_COOKIE['tema'] : 'clar';
if ($tema_pref == 'clar') {
    $fons = '#ffffff';
    $text = '#333333';

}elseif ($tema_pref == 'fosc') {
    $fons = '#333333';
    $text = '#ffffff';
}else{
    $fons = '#ffffff';
    $text = '#333333';
};

?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proves</title>
</head>
<body style="background-color: <?= $fons ?>; color: <?= $text ?>;">
    <h1>Proves</h1>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <label for="nom">Nom:</label>
        <input type="text" placeholder="Nom" name="nom" id="nom" value="<?= htmlspecialchars($nom ?? '') ?>">
        <label for="tema">Tema:</label>
        <select name="tema" id="tema">
            <option value="clar" <?= $tema_pref === 'clar' ? 'selected' : '' ?>>Clar</option>
            <option value="fosc" <?= $tema_pref === 'fosc' ? 'selected' : '' ?>>Fosc</option>
        </select>
        <input type="submit" value="Guardar">
    </form>    
</body>
</html>