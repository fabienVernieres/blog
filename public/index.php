<?php
require '../config.php';

use app\Router;

require '../vendor/autoload.php';

$router
    = new Router();

$router->addRoute('accueil',        '',         'Index#index#:param');
$router->addRoute('actualités',     'list',     'Post#list#:param');
$router->addRoute('administration', 'admin',    'Admin#:method#:param');
$router->addRoute('compte',         'account',  'Account#:method#:param');
$router->addRoute('connexion',      'login',    'Login#:method#:param');
$router->addRoute('contact',        'contact',  'Contact#:method#:param');
$router->addRoute('formulaire',     'form',     'Form#:method#:param');
$router->addRoute('inscription',    'register', 'Register#:method#:param');
$router->addRoute('post',           'post',     'Post#:method#:param');
$router->addRoute('utilisateur',    'user',     'User#:method#:param');

$router->run();