# Sistema de Gestió de Biblioteca

Projecte de gestió d'una biblioteca desenvolupat en PHP orientat a objectes (POO) seguint l'estàndard PSR-4.

## Estructura del projecte

```text
biblioteca/
├── composer.json
├── .gitignore
├── README.md
├── index.php                  ← únic punt d'entrada (router)
├── views/                     ← una vista per pàgina
│   ├── inici.php
│   └── materials.php
└── src/
    ├── Models/
    ├── Interfaces/
    ├── Traits/
    ├── Exceptions/
    └── Data/
```

## Instal·lació

Executa Composer per generar l'autoloader PSR-4:

```bash
composer dump-autoload
```

