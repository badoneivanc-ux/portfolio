# Portfolio MVC 

## Description du projet

Application web développée en PHP selon le pattern **MVC (Modèle - Vue - Contrôleur)** (pas de framework).  
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

## Structure du projet

```
├── Autoloader.php          # Autochargement des classes par namespace
├── Controllers/
│   ├── Controller.php       # Contrôleur abstrait (render, redirect, sécurisation POST)
│   ├── HomeController.php   # Page d'accueil
│   ├── CreationController.php # CRUD des créations
│   └── ContactController.php  # ✅ NOUVEAU - Page de contact
├── Core/
│   ├── Router.php           # Routeur (dispatching via $_GET controller/action)
│   ├── DbConnect.php        # Connexion PDO à la base de données
│   ├── Form.php             # Générateur de formulaires
│   └── Validator.php        # Validation des données
├── Entities/
│   └── Creation.php         # Entité Création
├── Models/
│   └── CreationModel.php    # Accès aux données (requêtes SQL)
├── Views/
│   ├── base.php             # Template HTML principal (navbar, header, footer)
│   ├── home/
│   │   └── index.php        # Vue page d'accueil
│   ├── creation/            # Vues CRUD créations
│   └── contact/
│       └── index.php        # ✅ NOUVEAU - Vue formulaire de contact
└── public/
    ├── index.php            # Point d'entrée unique de l'application
    └── style.css            # Feuille de styles personnalisée
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


