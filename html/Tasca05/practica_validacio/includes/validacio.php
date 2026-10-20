<?php
function validarNom(?string $nom): ?string {
    if ($nom === null || $nom === '') {
        return "El nom és obligatori.";
    }
    $len = mb_strlen($nom, 'UTF-8');
    if ($len < 2 || $len > 50) {
        return "El nom ha de tenir entre 2 i 50 caràcters.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]*$/u", $nom)) {
        return "El nom només pot contenir lletres, espais, apòstrofs i guions.";
    }
    return null;
}

function validarCognoms(?string $cognoms): ?string {
    if ($cognoms === null || $cognoms === '') {
        return "Els cognoms són obligatoris.";
    }
    $len = mb_strlen($cognoms, 'UTF-8');
    if ($len < 2 || $len > 50) {
        return "Els cognoms han de tenir entre 2 i 50 caràcters.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]*$/u", $cognoms)) {
        return "Els cognoms només poden contenir lletres, espais, apòstrofs i guions.";
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

function validarEdat(?string $edat): ?string {
    if ($edat === null || $edat === '') {
        return "L'edat és obligatòria.";
    }
    if (!preg_match('/^\d+$/', $edat)) {
        return "L'edat ha de ser un nombre enter sense decimals.";
    }
    $edatInt = (int)$edat;
    if ($edatInt < 18 || $edatInt > 120) {
        return "L'edat ha de ser entre 18 i 120 anys.";
    }
    return null;
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

function validarPoblacio(?string $poblacio): ?string {
    if ($poblacio === null || $poblacio === '') {
        return "La població és obligatòria.";
    }
    $len = mb_strlen($poblacio, 'UTF-8');
    if ($len < 2 || $len > 50) {
        return "La població ha de tenir entre 2 i 50 caràcters.";
    }
    if (!preg_match("/^[\p{L}][\p{L} '\-]*$/u", $poblacio)) {
        return "La població només pot contenir lletres, espais, apòstrofs i guions.";
    }
    return null;
}

function normalitzarPoblacio(string $poblacio): string {
    $poblacio = trim($poblacio);
    if ($poblacio === '') {
        return '';
    }
    // Converteix cada paraula a majúscula inicial (compatible UTF-8)
    $res = mb_convert_case($poblacio, MB_CASE_TITLE, 'UTF-8');
    // Normalitza partícules catalanes com d' o l' (ex: D'urgell -> d'Urgell)
    $res = preg_replace_callback('/\b([dl])\'([\p{L}])/ui', function($m) {
        return mb_strtolower($m[1], 'UTF-8') . "'" . mb_strtoupper($m[2], 'UTF-8');
    }, $res);
    // Assegura que el primer caràcter absolut sigui majúscula
    return mb_strtoupper(mb_substr($res, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($res, 1, null, 'UTF-8');
}