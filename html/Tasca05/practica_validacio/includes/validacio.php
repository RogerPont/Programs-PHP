<?php

function validarNom(?string $nom): ?string {
    if ($nom === null || $nom === '') {
        return "El nom és obligatori.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]{1,49}$/u", $nom)) {
        return "El nom ha de tenir entre 2 i 50 caracters.";
    }
    return null;
}

function validarCognoms(?string $cognoms): ?string {
    if ($cognoms === null || $cognoms === '') {
        return "El cognom és obligatori.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]{1,49}$/u", $cognoms)) {
        return "El cognom ha de tenir entre 2 i 50 caracters.";
    }
    return null;
}

function validarEdat(?string $edat): ?string {
    if ($edat === null || $edat === '') {
        return "L'edat és obligatòria.";
    }
    if (!ctype_digit($edat) || $edat < 18 || $edat > 120) {
        return "L'edat ha de ser un número vàlid entre 18 i 120.";
    }
    return null;
}

function validarPoblacio(?string $poblacio): ?string {
    if ($poblacio === null || $poblacio === '') {
        return "La població és obligatòria.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]{1,49}$/u", $poblacio)) {
        return "La població ha de tenir entre 2 i 50 caracters.";
    }
    return null;
}

function normalPobliaci(?string $poblacio): ?string {
    $primera = mb_strtoupper(mb_substr($poblacio, 0, 1, 'UTF-8'), 'UTF-8');
    $altres = mb_strtolower(mb_substr($poblacio, 1, null, 'UTF-8'), 'UTF-8');
    return $primera . $altres;
}

function validarTelefon(?string $telefon): ?string {
    if ($telefon === null || $telefon === '') {
        return null; 
    }

    $telefonNet = preg_replace('/[\s\-]/', '', $telefon);

    if (!preg_match('/^\d{9}$/', $telefonNet)) {
        return "El telèfon ha de tenir exactament 9 dígits.";
    }

    return null; 
}

function validarEmail(?string $email): ?string {
    if ($email === null || $email === '') {
        return "L'email és obligatori.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El format de l'email no és vàlid.";
    }
    return null;
}

?>