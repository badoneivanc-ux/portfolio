# Portfolio MVC 

## Description du projet

Application web développée en PHP selon le pattern MVC.  
Elle permet d'afficher un portfolio avec une liste de créations et une page de contact.

---

## Installation

1. Cloner le dépôt dans le dossier `htdocs` de MAMP :
   ```bash
   git clone https://github.com/olivierCEFII/portfolio.git
   ```
2. Démarrer MAMP et accéder à l'application via :
   ```
   http://localhost:8888/ECF4/MVC_blog(autreMethode)-ssForm
   ```

---


## Fonctionnement du routeur

Le routeur lit les paramètres `$_GET['controller']` et `$_GET['action']` pour instancier dynamiquement le bon contrôleur et appeler la bonne méthode.


---

## Création Branche `page-contact`

### 1. Ajout de la page Contact


#### Fichiers créés

`Controllers/ContactController.php`  Contrôleur gérant l'affichage et la validation du formulaire 
`Views/contact/index.php`  Vue Bootstrap du formulaire de contact 

#### Fichiers modifiés


`Views/base.php`  Ajout du lien "Contact" dans la barre de navigation 

#### Fonctionnalités de la page Contact

- **Formulaire avec 4 champs** : Nom, Adresse e-mail, Sujet, Message
- **Validation serveur** :
  - Tous les champs sont obligatoires
  - L'email est vérifié via `filter_var(..., FILTER_VALIDATE_EMAIL)`
  - Le message doit contenir au moins 10 caractères
- **Affichage des erreurs** en ligne sous chaque champ (classes Bootstrap `is-invalid`)
- **Conservation des valeurs** saisies en cas d'erreur (UX)
- **Message de confirmation** après envoi réussi
- **Informations de contact** complémentaires (email, téléphone, localisation)
- **Sécurité** : toutes les données POST passent par `htmlspecialchars()` via `Controller::protected_values()`

---

## Sécurité

- Les données `$_POST` sont nettoyées (`trim`, `stripslashes`, `htmlspecialchars`) dans `Controller::protected_values()`
- La validation de l'email utilise `FILTER_VALIDATE_EMAIL` (PHP natif)
- Les valeurs réaffichées dans la vue utilisent `htmlspecialchars()` pour prévenir les failles XSS

---






## Dockerisation

### Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) 
- Git installé

---

### Architecture des conteneurs


| `portfolio_app` | `php:8.2-apache` (custom) | `8083` | `80` |
| `portfolio_db` | `mysql:8.0` | `3308` | `3306` |

---

### Fichiers Docker

| `Dockerfile` | Construit l'image PHP 8.2 + Apache avec `pdo_mysql`, `mod_rewrite` et VirtualHost |
| `docker-compose.yml` | Orchestre les deux services (`app` + `db`), réseau, volumes, healthcheck |
| `docker/init.sql` | Crée la table `creation` et insère des données au premier démarrage MySQL |
| `.dockerignore` | Exclut `.git`, logs, `.DS_Store` du contexte de build |

---






### Étapes de déploiement

#### Méthode 1 — Depuis le code source (GitHub)

```bash
# 1. Cloner le dépôt
git clone https://github.com/badoneivanc-ux/portfolio.git
cd portfolio
git checkout page-contact
cd "MVC_blog(autreMethode)-ssForm - githubECF4"

# 2. Construire l'image et démarrer les conteneurs
docker compose up -d --build

# 3. Vérifier que les conteneurs sont actifs
docker ps

# 4. Accéder à l'application
# → http://localhost:8083
```


---

#### Méthode 2 — Depuis l'image Docker Hub (sans code source)

L'image est disponible publiquement : **https://hub.docker.com/r/ivan1576/portfolio-app**

```bash
# 1. Récupérer les images
docker pull ivan1576/portfolio-app:latest
docker pull mysql:8.0

# 2. Créer le réseau
docker network create portfolio_network

# 3. Démarrer MySQL
docker run -d \
  --name portfolio_db \
  --network portfolio_network \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=Portfolio \
  -p 3308:3306 \
  mysql:8.0

# 4. Démarrer l'app
docker run -d \
  --name portfolio_app \
  --network portfolio_network \
  -e DB_HOST=portfolio_db \
  -e DB_PORT=3306 \
  -e DB_NAME=Portfolio \
  -e DB_USER=root \
  -e DB_PASSWORD=root \
  -p 8083:80 \
  ivan1576/portfolio-app:latest

# 5. Accéder à l'application
# → http://localhost:8083
```


### Réinitialiser la base de données

```bash
docker compose down -v     # supprime le volume (BDD effacée)
docker compose up -d       # recrée tout (init.sql rejoue automatiquement)
```

---

### Liens du projet

| **Dépôt GitHub** (branche `page-contact`) | https://github.com/badoneivanc-ux/portfolio/tree/page-contact |
| **Image Docker Hub** | https://hub.docker.com/r/ivan1576/portfolio-app |

---
