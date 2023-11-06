<?php
// Router.php

class Router {
    private $routes = [];

    public function __construct() {
        $this->routes['GET'] = [];
        $this->routes['POST'] = [];
    }

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function resolve($requestUri, $requestMethod) {
        $method = strtoupper($requestMethod);
        $parsedUri = parse_url($requestUri);
        $path = $parsedUri['path'] ?? '/';

        if (isset($this->routes[$method][$path])) {
            $controllerAction = explode('@', $this->routes[$method][$path]);
            if (count($controllerAction) === 2) {
                list($controllerName, $actionName) = $controllerAction;
                $this->callAction($controllerName, $actionName);
            }
        } else {
            // Ici vous pouvez personnaliser la page d'erreur 404
            header("HTTP/1.0 404 Not Found");
            require __DIR__ . '/views/404.php';
        }
    }

    private function callAction($controllerName, $actionName) {
        $controllerName = "App\\Controllers\\$controllerName";
        $controller = new $controllerName();
        if (!method_exists($controller, $actionName)) {
            throw new Exception("La méthode $actionName n'existe pas dans le contrôleur $controllerName.");
        }
        $controller->$actionName();
    }
}
