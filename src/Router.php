<?php

/**
 * Router File Doc Comment
 * 
 * Routeur permettant de sélectionner le contrôleur correspondant 
 * à l'url courante
 * 
 * php version 8.0.0
 * 
 * @category Service
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */

namespace app;

/**
 * Router
 * 
 * @category Class
 * @package  Blog
 * @author   Vernières fabien <contact@fabienvernieres.com>
 * @license  "https://blog.fabienvernieres.com/ GNU/GPLv3"
 * @link     https://blog.fabienvernieres.com
 */
class Router
{
    /**
     * Contrôleur
     * 
     * @var string
     * */
    private $_controller;

    /**
     * Données de l'url courante
     * 
     * @var array
     */
    private $_dataUrl = [];

    /**
     * Méthode 
     * 
     * @var string
     */
    private $_method;

    /**
     * Paramètre
     * 
     * @var string
     */
    private $_param;

    /**
     * Tableau des routes
     * 
     * @var array
     */
    private $_routes = [];

    /**
     * Route courante
     * 
     * @var string
     */
    private $_route;

    /**
     * Url courante 
     * 
     * @var string
     */
    private $_url;


    /**
     * Enregistre l'url courante $this->_url et explose cette dernière
     * par les slashs dans $this->_dataUrl 
     *
     * @return void
     */
    public function __construct()
    {
        $this->_url     = trim($_SERVER['REQUEST_URI'], '/');
        $this->_dataUrl = explode('/', $this->_url);
    }

    /**
     * Enregistre une route donnée
     *
     * @param string $name       nom de la route
     * @param string $url        url de la route
     * @param string $controller contrôleur de la route
     * 
     * @return array
     */
    public function addRoute(string $name, string $url, string $controller): array
    {
        return $this->_routes[] = [
            'name'       => $name,
            'url'        => $url,
            'controller' => $controller
        ];
    }

    /**
     * Recherche une correspondance dans le tableau des routes avec 
     * l'url courante
     *
     * @param array  $routes tableau des routes
     * @param string $url    url courante
     * 
     * @return void
     */
    public function match(array $routes, string $url): void
    {
        foreach ($routes as $path) {
            if ($path['url'] === $url) {
                $this->_route = $path['controller'];
            }
        }
    }

    /**
     * Extrait le controller, la méthode et les paramètres
     *
     * @param string $route route à traiter
     * 
     * @return void
     */
    public function getController(?string $route): void
    {

        // Explode la route par les #, si aucune route trouvée, 
        // la page est un article
        $this->_route
            = (!empty($this->_route))
            ? explode('#', $this->_route) : explode('#', 'Post#read#' . $this->_url);

        // Le contrôleur prend la valeur de la clé 0 du tableau 
        // $this->_route
        $this->_controller = $this->_route[0];

        // Remplace :method et :param dans le tableau $this->_route 
        // par les valeurs des clés 1 et 2 de $this->_dataUrl
        $this->_method
            = (isset($this->_dataUrl[1]))
            ? $this->_dataUrl[1] : '';

        $this->_param
            = (isset($this->_dataUrl[2]))
            ? $this->_dataUrl[2] : '';

        $this->_route
            = str_replace(
                [
                    ':method', ':param'
                ],
                [
                    $this->_method, $this->_param
                ],
                $this->_route
            );

        // Si aucune méthode ou aucun paramètre
        $this->_method
            = (isset($this->_route[1]))
            ? $this->_route[1] : '';

        $this->_param
            = (isset($this->_route[2]))
            ? $this->_route[2] : '';
    }

    /**
     * Appelle le contrôleur
     *  
     * @return void
     */
    public function run(): void
    {
        $this->match($this->_routes, $this->_dataUrl[0]);

        $this->getController($this->_route);

        $this->_controller = 'app\controller\\' . $this->_controller . 'Controller';

        $method = $this->_method;
        $app    = new $this->_controller();

        $app = (method_exists($app, $this->_method))
            ? $app->$method($this->_param) : $app->index($this->_param);
    }
}