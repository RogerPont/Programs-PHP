<?php
function ordenarPerCapital(array $ceu): array {
    $ordenat = $ceu;
    asort($ordenat, SORT_NATURAL | SORT_FLAG_CASE);
    return $ordenat;
}


function filtrarCapitals(array $ceu, string $cerca = '', string $lletra = ''): array {
    $filtrat = [];
    $cerca = trim($cerca); // Trim neteja els espais en blanc del inici i final de un string
    $lletra = trim(mb_strtoupper($lletra)); // El mb_strtoupper converteix tot allò que contingui $lletres en majúscules

    foreach ($ceu as $pais => $capital) {
        // Filtre per lletra inicial del país
        if ($lletra !== '' && $lletra !== 'TOTES') {
            $primeraLletra = mb_strtoupper(mb_substr($pais, 0, 1)); // El ús de mb_substr es per agafar el primer caràcter de la paraula, mentres que l'ús del mb_strlen es per agafar la llargada de la paraula.
            if ($primeraLletra !== $lletra) {
                continue;
            }
        }

        // Filtre per text (cerca parcial i insensible a majúscules/minúscules)
        if ($cerca !== '') {
            $trobatPais = (stripos($pais, $cerca) !== false);
            $trobatCapital = (stripos($capital, $cerca) !== false); // L'ús de stripos es que et retorna la posició de on es troba el string, si no el troba et retorna false.
            if (!$trobatPais && !$trobatCapital) { // També el ús del ! es un invertor de booleans, en aquest cas vol dir que si no troba el string en cap dels dos casos, llavors no el inclou
                continue;
            }
        }

        $filtrat[$pais] = $capital;
    }

    return $filtrat;
}


// Retornem les lletres inicials ordenades per l'array
function obtenirLletresInicials(array $ceu): array {
    $lletres = [];
    foreach (array_keys($ceu) as $pais) {
        $inicial = mb_strtoupper(mb_substr($pais, 0, 1)); // 
        if (!in_array($inicial, $lletres)) {
            $lletres[] = $inicial;
        }
    }
    sort($lletres);
    return $lletres;
}

// Conversio de fahrenheit a Celsius amb round (2 decimals)
function fahrenheiaCelsius(float $fahrenheit): float {
    return round(($fahrenheit - 32) * 5 / 9, 2);
}

// Converso de celsius a Faherenheit amb round (2 decimals)
function celsiusaFahrenheit(float $celsius): float {
    return round(($celsius * 9 / 5) + 32, 2);
}

// Retorna la mitjana de les temperatures
function calcularMitjana(array $temperatures): float {
    return round(array_sum($temperatures) / count($temperatures), 2);
}

// Retorna la mediana de les temperatures
function calcularMediana(array $temperatures): float {
    $ordenat = $temperatures;
    sort($ordenat, SORT_NUMERIC);

    $total = count($ordenat);
    $mig = (int) floor($total / 2);

    if ($total % 2 !== 0) {
        return (float) $ordenat[$mig];
    } else {
        return round(($ordenat[$mig - 1] + $ordenat[$mig]) / 2, 2);
    }
}

// Retorna les temperatures mes Altes
function temperaturesAltes(array $temperatures, int $quantitat = 5): array {
    $ordenat = $temperatures;
    rsort($ordenat, SORT_NUMERIC);
    return array_slice($ordenat, 0, $quantitat);
}

// Retorna les temperatures mes baixes
function temperaturesBaixes(array $temperatures, int $quantitat = 5): array {
    $ordenat = $temperatures;
    sort($ordenat, SORT_NUMERIC);
    return array_slice($ordenat, 0, $quantitat);
}

// Retornem temperatures maximes de l'array
function temperaturaMaxima(array $temperatures): float {
    return empty($temperatures) ? 0.0 : (float) max($temperatures);
}

// Retornem temperatures minimes de l'array
function temperaturaMinima(array $temperatures): float {
    return empty($temperatures) ? 0.0 : (float) min($temperatures);
}

// Combinem els arrays amb bucles
function combinarArrayBucle(array $keysArray, array $valuesArray): array {
    $resultat = [];
    $keysValues = array_values($keysArray);
    $valsValues = array_values($valuesArray);
    $limit = min(count($keysValues), count($valsValues));

    for ($i = 0; $i < $limit; $i++) {
        $resultat[$keysValues[$i]] = $valsValues[$i];
    }

    return $resultat;
}

// Combinem els arrays amb la funcio nativa array_combine
function combinarArraysNative(array $keysArray, array $valuesArray): array {
    $keysValues = array_values($keysArray);
    $valsValues = array_values($valuesArray);
    return array_combine($keysValues, $valsValues);
}

// Retorna un array amb les dades per defecte de l'academia.
function obtenirAcademiaPerDefecte(): array {
    return [
        "Bàsic" => [
            "Anglès" => ["Marc", "Laia", "Pol", "Mireia"],
            "Francès" => ["Jordi", "Anna"],
            "Alemany" => ["Clara", "Sergi", "David"],
            "Rus" => ["Alex"]
        ],
        "Mitjà" => [
            "Anglès" => ["Laura", "Oriol", "Pau", "Carla", "Joan"],
            "Francès" => ["Sara", "Eric", "Aina"],
            "Alemany" => ["Gerard"],
            "Rus" => ["Helena", "Iker"]
        ],
        "Perfeccionament" => [
            "Anglès" => ["Marta", "Arnau", "Biel"],
            "Francès" => ["Xavier", "Marina"],
            "Alemany" => ["Nil", "Alba"],
            "Rus" => []
        ]
    ];
}

// Comptem el total dels alumnes
function comptarTotalAlumnes(array $academia): int {
    $total = 0;
    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            $total += count($alumnes);
        }
    }
    return $total;
}

// Comptem el total dels idiomes
function TotalPerIdioma(array $academia): array {
    $totals = [];
    foreach ($academia as $nivell => $idiomes) { /** La variable "nivell" no es fa servir dins de la funció pero si en (@see MitjanaPerIdioma() i (@see TotalPerNivell()*/
        foreach ($idiomes as $idioma => $alumnes) {
            if (!isset($totals[$idioma])) {
                $totals[$idioma] = 0;
            }
            $totals[$idioma] += count($alumnes);
        }
    }
    return $totals;
}

// Retornem els grups mes nombrosos (amb mes alumnes)
function MesNombros(array $academia): array {
    $maxim = -1;
    $grup = ['nivell' => '', 'idioma' => '', 'total' => 0];

    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            $count = count($alumnes);
            if ($count > $maxim) {
                $maxim = $count;
                $grup = ['nivell' => $nivell, 'idioma' => $idioma, 'total' => $count];
            }
        }
    }
    return $grup;
}

// Retornem els menys nombrosos (amb menys alumnes)
function MenysNombros(array $academia): array {
    $minim = PHP_INT_MAX;
    $grup = ['nivell' => '', 'idioma' => '', 'total' => 0];

    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            $count = count($alumnes);
            if ($count < $minim) {
                $minim = $count;
                $grup = ['nivell' => $nivell, 'idioma' => $idioma, 'total' => $count];
            }
        }
    }
    return $grup;
}


// Calculem el nivell mitjà per nivell
function MitjanaPerNivell(array $academia): array {
    $mitjanes = [];
    foreach ($academia as $nivell => $idiomes) {
        $totalAlumnes = 0;
        $numIdiomes = count($idiomes);
        foreach ($idiomes as $alumnes) {
            $totalAlumnes += count($alumnes);
        }
        $mitjanes[$nivell] = $numIdiomes > 0 ? round($totalAlumnes / $numIdiomes, 2) : 0;
    }
    return $mitjanes;
}

// Retornem la mitjana per l'idioma.
function MitjanaPerIdioma(array $academia): array {
    $totals = TotalPerIdioma($academia);
    $numNivells = count($academia);
    $mitjanes = [];

    foreach ($totals as $idioma => $total) {
        $mitjanes[$idioma] = $numNivells > 0 ? round($total / $numNivells, 2) : 0;
    }
    return $mitjanes;
}

// Àlies amb els noms exactes demanats a l'enunciat PDF (pàg. 8)
function comptarTotalPerIdioma(array $academia): array {
    return TotalPerIdioma($academia);
}

function buscarGrupMesNombros(array $academia): array {
    return MesNombros($academia);
}

function buscarGrupMenysNombros(array $academia): array {
    return MenysNombros($academia);
}

function calcularMitjanaPerNivell(array $academia): array {
    return MitjanaPerNivell($academia);
}

function calcularMitjanaPerIdioma(array $academia): array {
    return MitjanaPerIdioma($academia);
}

function cercarAlumne(array $academia, string $nom): array {
    $trobats = [];
    $nom = trim($nom);
    if ($nom === '') {
        return $trobats;
    }

    foreach ($academia as $nivell => $idiomes) {
        foreach ($idiomes as $idioma => $alumnes) {
            foreach ($alumnes as $alumne) {
                if (stripos($alumne, $nom) !== false) {
                    $trobats[] = [
                        'nom' => $alumne,
                        'nivell' => $nivell,
                        'idioma' => $idioma
                    ];
                }
            }
        }
    }
    return $trobats;
}