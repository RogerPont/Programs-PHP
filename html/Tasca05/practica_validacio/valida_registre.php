<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}



$camps = ['nom', 'cognoms', 'edat', 'email', 'telefon', 'poblacio'];

$dades = [];
foreach ($camps as $camp) {
    $dades[$camp] = isset($_POST[$camp]) && is_string($_POST[$camp]) ? trim($_POST[$camp]) : null;
}


if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Accés denegat: token CSRF invàlid');
}

$errors = [];


if ($errors = validarNom($dades['nom'])) {
    $errors['nom'] = $err;

}
if ($errors = validarCognoms($dades['cognoms'])) {
    $errors['cognoms'] = $err;
}
if ($errors = validarPoblacio($dades['poblacio'])) {
    $errors['poblacio'] = $err;
}
if ($errors = validarEdat($dades['edat'])) {
    $errors['edat'] = $err;
}
if ($errors = validarEmail($dades['email'])) {
    $errors['email'] = $err;
}
if ($errors = validarTelefon($dades['telefon'])) {
    $errors['telefon'] = $err;
}

if(!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades'] = $dades;
    header('Location: registre.php');
    exit;
}

require_once __DIR__ . 'includes/validacio.php';

?>