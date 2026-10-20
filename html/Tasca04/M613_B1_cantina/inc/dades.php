<?php
declare(strict_types=1);

return [
    // Llista d'usuaris permesos amb contrasenyes xifrades amb bcrypt (password_hash)
    'usuaris' => [
        [
            'email' => 'alumne@lacetania.cat',
            'nom' => 'Alumne DAW',
            'contrasenya' => '$2y$10$ZDSZRyE0A/4oxabJ3yDISu/rwGGaeEp5YecXBJzkoM4qGyoxp8ab.', // hash de la contrasenya
            'rol' => 'alumne'
        ],
        [
            'email' => 'cantina@lacetania.cat',
            'nom' => 'Administrador Cantina',
            'contrasenya' => '$2y$10$kWXpBo1vMjzSYpRKvSI5sObsPryj/660lMzClHhvKqOqJggJx44lK', // hash de la contrasenya
            'rol' => 'admin'
        ],
    ],

    // Catàleg de productes indexats pel seu identificador únic
    'productes' => [
        1 => ['nom' => 'Entrepà de pernil', 'preu' => 3.50],
        2 => ['nom' => 'Entrepà vegetal',   'preu' => 3.20],
        3 => ['nom' => 'Croissant',         'preu' => 1.40],
        4 => ['nom' => 'Suc de taronja',    'preu' => 1.80],
        5 => ['nom' => 'Cafè amb llet',     'preu' => 1.30],
        6 => ['nom' => 'Aigua mineral',     'preu' => 1.00],
    ],
];