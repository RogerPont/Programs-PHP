<?php
include __DIR__ . '/includes/header.php';
?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <div class="container-fluid py-2">
        <h1 class="display-5 fw-bold text-dark">TASCA-03: Arrays, Funcions i Formularis</h1>
        <p class="col-md-9 fs-5 text-muted">
            Pràctica de desenvolupament web en entorn servidor (PHP). Resolució dels 4 exercicis requerits complint amb tots els requisits tècnics: Bootstrap 5, funcions modulars, mètodes GET/POST, persistència amb camps ocults i escapament de dades.
        </p>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
    <div class="col">
        <div class="card h-100 shadow-sm border-top border-primary border-3">
            <div class="card-body">
                <h5 class="card-title fw-bold text-primary">Exercici 1: Capitals Europees</h5>
                <p class="card-text text-muted">
                    Gestió i ordenació d'un array associatiu de països i capitals. Inclou cerca parcial insensible a majúscules i filtrat per lletra inicial mitjançant formulari GET.
                </p>
                <a href="ex1.php" class="btn btn-outline-primary stretched-link">Accedir a l'exercici &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm border-top border-danger border-3">
            <div class="card-body">
                <h5 class="card-title fw-bold text-danger">Exercici 2: Anàlisi de Temperatures</h5>
                <p class="card-text text-muted">
                    Càlcul de mitjana, mediana, valors extrems i Top 5 de temperatures. Formulari per afegir noves temperatures, conversió entre Celsius i Fahrenheit i taula completa.
                </p>
                <a href="ex2.php" class="btn btn-outline-danger stretched-link">Accedir a l'exercici &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm border-top border-success border-3">
            <div class="card-body">
                <h5 class="card-title fw-bold text-success">Exercici 3: Arrays Associatius</h5>
                <p class="card-text text-muted">
                    Combinació d'arrays mitjançant bucles manuals i amb <code>array_combine()</code>. Formulari complet per afegir, editar i eliminar parelles clau-valor amb estat mantingut.
                </p>
                <a href="ex3.php" class="btn btn-outline-success stretched-link">Accedir a l'exercici &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm border-top border-warning border-3">
            <div class="card-body">
                <h5 class="card-title fw-bold text-dark">Exercici 4: Gestió d'Acadèmia d'Idiomes</h5>
                <p class="card-text text-muted">
                    Matriu bidimensional (Nivells &times; Idiomes). Càlcul de totals, mitjanes, grups extrems, cerca d'alumnes per nom i trasllat d'alumnes entre grups.
                </p>
                <a href="ex4.php" class="btn btn-outline-warning stretched-link">Accedir a l'exercici &rarr;</a>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>
