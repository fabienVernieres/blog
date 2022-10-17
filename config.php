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