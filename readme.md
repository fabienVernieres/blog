# Projet Blog en PHP

---

Projet de formation : développer un blog en PHP

## Table of Contents

1. [Informations générales](#informations-generales)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Prise en main](#prise-en-main)

# Informations générales

La démonstration du projet est disponible à cette adresse :
[blog.fabienvernieres.com](https://blog.fabienvernieres.com)

Auteur du projet : fabien Vernières
[fabienvernieres.com](https://fabienvernieres.com)
Date : septembre 2022

# Technologies

Cette application est optimisée pour un serveur PHP 8.0.0

Une base données MYSQL est requise.

Cette application utilise le modèle de conception MVC.
Le dossier `/src` comporte les trois modules : controller, view et model.

Ce dossier comporte également le routeur de l'application.

Le frontend est réalisé avec le framework Boostrap.

# Installation

Téléchargez le dossier ZIP du code ou cloner le dépôt sur votre périphérique.

```text
#Le contenu sera directement téléchargé dans le répertoire projet

git clone https://github.com/fabienVernieres/blog.git projet

#Le contenu sera téléchargé dans le dossier où vous vous situez

git clone https://github.com/fabienVernieres/blog.git .
```

Modifiez le fichier `config.php` à la racine du projet et importez le fichier `db.sql` dans votre base de données pour créer les tables SQL.

```php
<?php
// Configuration PHPMailer
define("EMAIL_ADMIN",       'exemple@domaine.com');
define("PASSMAIL_ADMIN",    '');

// // Constante ROOT terminée par slash
define("ROOT", 'https://exemple.domaine.com/');

// Titre du blog
define("BLOG_TITLE",              'Nom du Blog');

// Nombre d'articles affichés sur la page d'accueil
define("NUMBER_ITEMS_INDEX_PAGE", 6);

// Nombre d'articles affichés par page actualités
define("NUMBER_ITEMS_LIST_PAGE",  9);

// Poids maximum autorisé en octet des images (ex: pour 1 Mo = 1000000)
define("IMAGE_MAX_WEIGHT",  1000000);

// Constantes pour formulaire pour contrôler la taille des chaines de caractères
define("MIN_INPUT",    8);
define("SHORT_INPUT",  30);
define("MEDIUM_INPUT", 300);
define("LONG_INPUT",   1000);

// Identifiant base de données
define("DB_HOST",     '');
define("DB_NAME",     '');
define("DB_USER",     '');
define("DB_PASSWORD", '');
```

Téléversez l'ensemble des fichiers du dépôt à la racine de votre serveur.

Il est également nécessaire d'installer `composer` sur le serveur. Un fichier `composer.json` comportant les dépendances nécessaires est disponible à la racine du projet.

Tapez ensuite la commande suivante sur le terminal de votre serveur:

```text
composer update
```

# Prise en main

Une fois le projet installé sur votre serveur, la base de données alimentée, vous pouvez vous connecter à l'espace d'administration en utilisant le mail suivant `exemple@domaine.com` et mot de passe `12345678` en suivant le lien `Connexion` dans le menu en haut à droite.
