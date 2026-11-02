<?php
// Iniciem sessió per gestionar tokens i dades temporals
session_start();

// Carreguem les funcions de validació que tenim a includes
require_once __DIR__ . '/includes/validacio.php';

// Comprovem que s'hagi enviat el formulari per POST; si no, redirigim
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}

// Verifiquem el token CSRF per protegir el formulari d'atacs entre llocs
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    exit('Accés denegat: token CSRF invàlid');
}

// Llista de camps esperats; els recollim i traiem espais en blanc dels extrems (trim)
$camps = ['nom', 'cognoms', 'email', 'edat', 'telefon', 'poblacio'];
$dades = [];
foreach ($camps as $camp) {
    $dades[$camp] = isset($_POST[$camp]) && is_string($_POST[$camp]) ? trim($_POST[$camp]) : '';
}

// Validem cada camp cridant la funció específica amb una expressió match
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

// Si hi ha algun error, guardem els errors i les dades a la sessió (sticky form) i tornem al formulari
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades'] = $dades;
    header('Location: registre.php');
    exit;
}

// Si tot és correcte, sanegem i convertim els tipus de dades finals
$dadesValidades = [
    'nom' => $dades['nom'],
    'cognoms' => $dades['cognoms'],
    'email' => mb_strtolower($dades['email'], 'UTF-8'),
    'edat' => (int)$dades['edat'],
    'telefon' => !empty($dades['telefon']) ? preg_replace('/[\s\-]/', '', $dades['telefon']) : '',
    'poblacio' => normalitzarPoblacio($dades['poblacio'])
];

// Guardem les dades finals a la sessió i anem a la pantalla de resultat
$_SESSION['dades_validades'] = $dadesValidades;
header('Location: resultat.php');
exit;