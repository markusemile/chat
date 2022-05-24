<?php

namespace App\Router;



class Router
{
    protected $path;
    protected $routes = [];

    public function __construct($path)
    {
        $this->path = trim($path, '/');
    }

    function get($url, $action)
    {
        $this->routes["GET"][] = new Route($url, $action);
    }
    function post($url, $action)
    {
        $this->routes["POST"][] = new Route($url, $action);
    }
    function api($url, $action)
    {
        $this->routes["API"][] = new Route($url, $action);
    }

    function run()
    {

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {


            if ($route->matches($this->path)) {
                $route->execute();
            }
            // else {
            //     header('Location: /error404.php');
            // }
        }
    }
}
