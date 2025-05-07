# **MovieSeat (Backend)**

FilmSeat est le backend de l’application de réservation de billets de cinéma MovieSeat. Développé avec Laravel 11, il expose une API REST sécurisée pour gérer utilisateurs, cinémas, salles, films, séances et réservations.

---

## Table des matières

* [Fonctionnalités](#fonctionnalités)
* [Architecture du projet](#architecture-du-projet)
* [Prérequis](#prérequis)
* [Installation](#installation)
* [Configuration de l'environnement](#configuration-de-lenvironnement)
* [Base de données & Migrations](#base-de-données--migrations)
* [Endpoints API](#endpoints-api)
* [Authentification](#authentification)
* [Tests](#tests)
* [Licence](#licence)

---

## Fonctionnalités

* API REST pour :

  * Gestion des utilisateurs (Inscription, connexion, rôles)
  * Gestion des cinémas et salles
  * Gestion des films et genres
  * Création et consultation des séances
  * Réservations de places
* Authentification JWT avec rafraîchissement sécurisé
* Diffusion d’événements en temps réel via Socket.IO et Redis
* Seeders pour données de démonstration

---

## Architecture du projet

```
backend/
├─ app/
│  ├─ Http/Controllers/
│  ├─ Models/
│  └─ Services/
├─ routes/api.php
│  ├─ api.php
│  ├─ auth.php
│  ├─ super_admin.php
│  ├─ cinema_admin.php
│  ├─ other.php
│  └─ user.php
├─ config/
├─ database/
│  ├─ migrations/
│  └─ seeders/
└─ tests/
```

---

## Prérequis

* PHP 8.2+
* Composer
* PostgreSQL
* Redis

---

## Installation

```bash
# Cloner le dépôt backend
git clone https://github.com/Tawdi/fil_rouge-backend.git
cd fil_rouge-backend

# Installer les dépendances
composer install

# Copier et configurer l'env
cp .env.example .env
php artisan key:generate

# Migrer et seed
php artisan migrate --seed

# Lancer le serveur
php artisan serve --port=8000
```

---

## Configuration de l'environnement

Dans le fichier `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movieseat
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=...

BROADCAST_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## Base de données & Migrations

* Tables principales : `users`, `cinemas`, `genres`, `movies`, `seances`, `reservations`


---

## Endpoints API

### Authentification

| Méthode | URL                       | Description                |
| ------- | ------------------------- | -------------------------- |
| POST    | `/api/auth/register`      | Inscription utilisateur    |
| POST    | `/api/auth/login`         | Authentification (JWT)     |
| POST    | `/api/auth/refresh-token` | Rafraîchir le token JWT    |
| POST    | `/api/auth/logout`        | Déconnexion                |
| GET     | `/api/auth/me`            | Infos utilisateur connecté |

### Utilisateur

| Méthode | URL                       | Description                |
| ------- | ------------------------- | -------------------------- |
| PUT     | `/api/user/profile`       | Modifier le profil         |
| POST    | `/api/user/profile-image` | Modifier l’image de profil |
| POST    | `/api/password/change`    | Modifier le mot de passe   |

### Cinéma (admin)

| Méthode | URL                           | Description         |
| ------- | ----------------------------- | ------------------- |
| GET     | `/api/admin/cinemas`          | Lister les cinémas  |
| POST    | `/api/admin/cinemas`          | Créer un cinéma     |
| GET     | `/api/admin/cinemas/{cinema}` | Voir un cinéma      |
| PUT     | `/api/admin/cinemas/{cinema}` | Modifier un cinéma  |
| DELETE  | `/api/admin/cinemas/{cinema}` | Supprimer un cinéma |

### Films & Genres (admin)

| Méthode | URL                         | Description        |
| ------- | --------------------------- | ------------------ |
| GET     | `/api/admin/movies`         | Lister les films   |
| POST    | `/api/admin/movies`         | Ajouter un film    |
| GET     | `/api/admin/movies/{movie}` | Détails d’un film  |
| PUT     | `/api/admin/movies/{movie}` | Modifier un film   |
| DELETE  | `/api/admin/movies/{movie}` | Supprimer un film  |
| GET     | `/api/admin/genres`         | Lister les genres  |
| POST    | `/api/admin/genres`         | Ajouter un genre   |
| GET     | `/api/admin/genres/{genre}` | Détails d’un genre |
| PUT     | `/api/admin/genres/{genre}` | Modifier un genre  |
| DELETE  | `/api/admin/genres/{genre}` | Supprimer un genre |

### Salles & Séances (cinema-admin)

| Méthode | URL                                  | Description          |
| ------- | ------------------------------------ | -------------------- |
| GET     | `/api/cinema-admin/rooms`            | Lister les salles    |
| POST    | `/api/cinema-admin/rooms`            | Créer une salle      |
| GET     | `/api/cinema-admin/rooms/{room}`     | Voir une salle       |
| PUT     | `/api/cinema-admin/rooms/{room}`     | Modifier une salle   |
| DELETE  | `/api/cinema-admin/rooms/{room}`     | Supprimer une salle  |
| GET     | `/api/cinema-admin/seances`          | Lister les séances   |
| POST    | `/api/cinema-admin/seances`          | Créer une séance     |
| GET     | `/api/cinema-admin/seances/{seance}` | Détails d’une séance |
| PUT     | `/api/cinema-admin/seances/{seance}` | Modifier une séance  |
| DELETE  | `/api/cinema-admin/seances/{seance}` | Supprimer une séance |

### Réservations

| Méthode | URL                             | Description               |
| ------- | ------------------------------- | ------------------------- |
| GET     | `/api/reservations`             | Lister les réservations   |
| POST    | `/api/reservations`             | Réserver des places       |
| GET     | `/api/reservations/{id}`        | Voir une réservation      |
| POST    | `/api/reservations/seance/{id}` | Voir les places réservées |

### Autres

| Méthode | URL                          | Description                     |
| ------- | ---------------------------- | ------------------------------- |
| GET     | `/api/movies`                | Voir tous les films disponibles |
| GET     | `/api/genres`                | Voir tous les genres            |
| GET     | `/api/genres/imgs`           | Genres avec affiches            |
| GET     | `/api/seances/movie/{id}`    | Séances par film                |
| POST    | `/api/create-payment-intent` | Paiement Stripe                 |
| POST    | `/api/support`               | Contacter le support            |

---

## Authentification

* JWT (Access Token + Refresh Token)
* Access Token en mémoire, Refresh Token en cookie HttpOnly
* Intercepteur Axios pour rafraîchir automatiquement


---

## Tests

* PHPUnit pour services et contrôleurs
* Exécution : `php artisan test`

---

## Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.
