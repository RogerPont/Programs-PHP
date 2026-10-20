<?php
session_start();

require_once __DIR__ . '/includes/validacio.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}


if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Accés denegat: token CSRF invàlid');
}


$camps = ['nom', 'cognoms', 'email', 'edat', 'telefon', 'poblacio'];
$dades = [];
foreach ($camps as $camp) {
    $dades[$camp] = isset($_POST[$camp]) && is_string($_POST[$camp]) ? trim($_POST[$camp]) : '';
}


$errors = [];

foreach ($dades as $camp => $valor) {
    $err = match ($camp) {
        'nom'      => validarNom($valor),
        'cognoms'  => validarCognoms($valor),
        'email'    => validarEmail($valor),
        'edat'     => validarEdat($valor),
        'telefon'  => validarTelefon($valor),
        'poblacio' => validarPoblacio($valor),
        default    => null,
    };
    if ($err !== null) {
        $errors[$camp] = $err;
    }
}



if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades'] = $dades;
    header('Location: registre.php');
    exit;
}


$dadesValidades = [
    'nom' => $dades['nom'],
    'cognoms' => $dades['cognoms'],
    'email' => mb_strtolower($dades['email'], 'UTF-8'),
    'edat' => (int)$dades['edat'],
    'telefon' => !empty($dades['telefon']) ? preg_replace('/[\s\-]/', '', $dades['telefon']) : '',
    'poblacio' => normalitzarPoblacio($dades['poblacio'])
];

$_SESSION['dades_validades'] = $dadesValidades;
header('Location: resultat.php');
exit;