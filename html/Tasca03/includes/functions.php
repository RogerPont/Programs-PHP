<?php
include __DIR__ . "/../ex1.php";
include __DIR__ . "/../ex2.php";

function mostrarArray($ceu)
{
    if (empty($ceu)) {
        echo "No hi ha contingut per aquesta cerca";
    } else {
        echo "<ul>";
        foreach ($ceu as $pais => $capital) {
            $capital = htmlspecialchars($capital);
            $pais = htmlspecialchars($pais);
            echo "<li>$pais : $capital</li>";
        }
        echo "</ul>";
    }

}

function ordenarCapitals($ceu, $ordre)
{
    if ($ordre == 'asc' || $ordre == 'all') {
        asort($ceu);
    } else if ($ordre == 'desc') {
        krsort($ceu);
    }
    return $ceu;
}

function cercarTerm($array_capitals, $term)
{
    if (empty($term)) {
        return $array_capitals;
    }

    $array_filtrat = [];

    foreach ($array_capitals as $pais => $capitals) {
        if (stripos($pais, $term) !== false || stripos($capitals, $term) !== false) {
            $array_filtrat[$pais] = $capitals;
        }
    }
    return $array_filtrat;
}



function Form($parm_get, $array_capitals)
{
    $ordreTriat = isset($parm_get["filtrador"]) ? $parm_get["filtrador"] : "all";
    $term = isset($parm_get["cerca"]) ? $parm_get["cerca"] : "";

    $array_capitals = cercarTerm($array_capitals, $term);

    $array_capitals = ordenarCapitals($array_capitals, $ordreTriat);

    mostrarArray($array_capitals);
}


$conversorTemp = fn($temperatura, $operacio):float => 
    match($operacio) {
    "FtoC"=> ($temperatura - 32) * 5 / 9,
    "CtoF"=> ($temperatura * 9 / 5) + 32,
    default => $temperatura,
};

$mitjana = fn($temperatures) => array_sum($temperatures) / count($temperatures);

function temperaturesAltes($temperatures, $alta)
{
    rsort($temperatures);
    
    $temperaturaAlta = array_slice($temperatures, 0, $alta);
    
    return $temperaturaAlta;
}



?>