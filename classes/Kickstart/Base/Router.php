<?php

namespace Kickstart\Base;

class Router
{
    private $routes = [];

    public function addRoute($routeName, callable $callable)
    {
        $this->routes[$routeName] = $callable;
    }

    public function execute()
    {
        $routes = $this->routes;

        call_user_func(
            $routes[$_GET['p'] ?? '/'] ?? $routes['404']
        );
    }
}
