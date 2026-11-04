# 📚 Sistema de Gestió de Biblioteca Digital

Projecte desenvolupat per al mòdul **M0613-B2 - PHP Orientat a Objectes**. Consisteix en una aplicació web en PHP 8 que gestiona el catàleg de materials (llibres, revistes i DVDs), usuaris, préstecs, reserves, multes i auditoria d'una biblioteca digital, aplicant els principis de la Programació Orientada a Objectes (POO).

---

## 🎬 Vídeo de Demostració

> 🔗 **[Enllaç al vídeo de demostració (YouTube / Google Drive)](AFEGEIX_AQUI_EL_LINK_DEL_VIDEO)**

---

## 🚀 Instal·lació i Execució

### 1. Instal·lació de l'autoloader PSR-4
Des de l'arrel del projecte (`biblioteca/`), executa Composer per generar la carpeta `vendor/` i l'autoloader PSR-4:

```bash
composer install
```
*(O bé `composer dump-autoload` si és la primera vegada).*

### 2. Execució del servidor de desenvolupament
Inicia el servidor integrat de PHP des de la carpeta `biblioteca/`:

```bash
php -S localhost:8000
```

A continuació, obre el navegador a **[http://localhost:8000/index.php](http://localhost:8000/index.php)**.

---

## 📁 Estructura del Projecte i Namespaces (PSR-4)

El projecte utilitza l'estàndard **PSR-4** amb el namespace arrel `App\` mapejat a la carpeta `src/`:

```text
biblioteca/
├── composer.json              ← Configuració PSR-4 ("App\\": "src/")
├── .gitignore                 ← Ignora /vendor/
├── README.md                  ← Documentació del projecte
├── index.php                  ← Únic punt d'entrada (Router amb match)
├── views/                     ← Vistes de l'aplicació
│   ├── inici.php
│   ├── materials.php
│   └── ...
└── src/
    ├── Models/                ← Namespace: App\Models
    │   ├── Material.php
    │   ├── Llibre.php
    │   ├── Revista.php
    │   ├── DVD.php
    │   ├── Usuari.php
    │   ├── Prestec.php
    │   └── Biblioteca.php
    ├── Interfaces/            ← Namespace: App\Interfaces
    │   └── Reservable.php
    ├── Traits/                ← Namespace: App\Traits
    │   └── Auditoria.php
    ├── Exceptions/            ← Namespace: App\Exceptions
    │   ├── MaterialNoTrobatException.php
    │   ├── MaterialNoDisponibleException.php
    │   ├── MaterialNoPrestatException.php
    │   ├── UsuariNoTrobatException.php
    │   └── EmailInvalidException.php
    └── Data/                  ← Namespace: App\Data
        └── DataGenerator.php
```

---

## 🌐 Llista d'URLs Operatives

Totes les peticions passen per l'únic punt d'entrada (`index.php`), que actua com a *router* mitjançant una expressió `match`:

### 🏠 Pàgina Principal i Sessió
| URL | Descripció |
| :--- | :--- |
| `index.php` (o `index.php?page=inici`) | Dashboard principal amb el resum general del sistema. |
| `index.php?page=reset` | Destrueix la sessió actual (`session_destroy()`) i regenera les dades inicials del `DataGenerator`. |

### 📚 Materials
| URL | Descripció |
| :--- | :--- |
| `index.php?page=materials` | Llistat complet de tots els materials de la biblioteca en una taula. |
| `index.php?page=materials&type=llibre` | Filtra el llistat per mostrar només els **llibres**. |
| `index.php?page=materials&type=revista` | Filtra el llistat per mostrar només les **revistes**. |
| `index.php?page=materials&type=dvd` | Filtra el llistat per mostrar només els **DVDs**. |
| `index.php?page=material&id=X` | Mostra la fitxa detallada del material amb ID `X` i el seu historial d'auditoria. |

### 👥 Usuaris
| URL | Descripció |
| :--- | :--- |
| `index.php?page=usuaris` | Llistat de tots els usuaris registrats en una taula. |
| `index.php?page=usuari&id=X` | Perfil de l'usuari amb ID `X` i els seus préstecs actius. |
| `index.php?page=usuari&id=X&action=prestecs` | Historial complet de préstecs (actius i retornats) de l'usuari amb ID `X`. |

### 🔄 Préstecs
| URL | Descripció |
| :--- | :--- |
| `index.php?page=prestecs` | Llistat de tots els préstecs actius, destacant aquells que estan vençuts. |
| `index.php?page=prestec&material_id=X&usuari_id=Y` | Realitza el préstec del material `X` a l'usuari `Y`. |
| `index.php?page=retorn&material_id=X` | Registra el retorn del material `X` i calcula/mostra la multa corresponent si hi ha retard. |

### 📝 Reserves
| URL | Descripció |
| :--- | :--- |
| `index.php?page=reserves` | Llistat de totes les reserves actives actualment. |
| `index.php?page=reserva&material_id=X&usuari_id=Y` | Crea una reserva del material `X` per a l'usuari `Y` (només per a materials que implementen `Reservable`). |

### 📊 Estadístiques i Auditoria
| URL | Descripció |
| :--- | :--- |
| `index.php?page=estadistiques` | Dashboard amb les estadístiques del sistema (total, disponibles, prestats, reservats, per tipus i multes pendents). |
| `index.php?page=auditoria` | Mostra el registre d'accions (`prestat`, `retornat`, `reservat`, `reserva_cancel·lada`) de tots els materials. |

### 🔧 Demostracions Tècniques
| URL | Descripció |
| :--- | :--- |
| `index.php?page=demo_magic` | Demostració dels mètodes màgics `__toString`, `__call`, `__get` i `__set` (incloent-hi la captura d'un `__set` no permès). |
| `index.php?page=demo_serialization` | Mostra el `serialize()` d'un objecte `Usuari` i comprova que `$notificacions` s'exclou amb `__sleep()` i es reinicialitza amb `__wakeup()`. |
| `index.php?page=demo_exceptions` | Provoca de forma controlada cadascuna de les 5 excepcions personalitzades i les captura amb `try/catch`. |
| `index.php?page=demo_autoload` | Mostra les classes carregades dinàmicament per Composer (`get_declared_classes()` filtrant pel namespace `App\`). |

---

## 🛠️ Decisions de Disseny i Característiques Tècniques

1. **Arquitectura i Autoloading PSR-4:**
   - S'utilitza un únic punt d'entrada (`index.php`) que carrega l'autoloader de Composer **abans** d'iniciar la sessió (`session_start()`), garantint que PHP pugui deserialitzar tots els objectes guardats a `$_SESSION['biblioteca']`.
2. **Herència, Polimorfisme i Interfícies:**
   - `Material` es defineix com a classe abstracta amb els mètodes abstractes `calcularMulta()` i `getTipus()`, assegurant que cada subclasse (`Llibre`, `Revista`, `DVD`) apliqui la seva pròpia tarifa de retard (0.50 €/dia, 0.25 €/dia i 1.00 €/dia respectivament).
   - La interfície `Reservable` s'implementa únicament a `Llibre` i `DVD` (les revistes no es poden reservar), comprovant-ne la implementació amb `instanceof Reservable`.
3. **Reutilització de Codi amb Traits:**
   - El trait `Auditoria` s'incorpora a la classe base `Material` per registrar automàticament amb data i hora totes les operacions (`prestat`, `retornat`, `reservat`, `reserva_cancel·lada`).
4. **Mètodes Màgics i Encapsulació:**
   - Ús de `__call()` a `Biblioteca` per resoldre dinàmicament crides com `getLlibres()`, `getRevistes()`, `getDVDs()`, `getMaterials()`, `getUsuaris()` i `getNom()`, llançant `\BadMethodCallException` si el mètode no existeix.
   - Ús de `__get()` i `__set()` a `Usuari` per protegir l'accés a les propietats privades i permetre només la modificació validada de l'`email`.
   - Ús de `__sleep()` i `__wakeup()` a `Usuari` per evitar persistir les notificacions temporals quan l'objecte es desa a la sessió.
5. **Característiques de PHP 8:**
   - *Typed properties* a totes les classes, *Constructor Property Promotion* a `Material`, `Biblioteca` i `Prestec`, *Union types* (`int|string` a `cercarUsuari()`), *Nullable types* (`?string`, `?Material`, `?\DateTime`), tipus `mixed` i expressions `match` al router i als filtres.
6. **Gestió d'Errors Robusta:**
   - Implementació de 5 excepcions personalitzades sota `App\Exceptions` (destacant `MaterialNoDisponibleException` amb l'ID del material afectat i `__toString()` propi) capturades de la més específica a la més general al router principal per evitar qualsevol *Fatal Error*.
