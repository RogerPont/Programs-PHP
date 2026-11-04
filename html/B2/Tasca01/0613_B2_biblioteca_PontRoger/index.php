<?php
declare(strict_types=1);

// Carregar l'autoloader de Composer (si ja s'ha generat)
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Únic punt d'entrada (Router bàsic)
$page = $_GET['page'] ?? 'inici';

switch ($page) {
    case 'materials':
        require __DIR__ . '/views/materials.php';
        break;
    case 'inici':
    default:
        require __DIR__ . '/views/inici.php';
        break;
}

