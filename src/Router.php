<?php

namespace Organic\Router;

class Router
{
    private RouteCollection $routes;

    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    public function get(string $path, callable $handler): Route
    {
        $route = new Route('GET', $path, $handler);
        $this->routes->add($route);

        return $route;
    }

    public function post(string $path, callable $handler): Route
    {
        $route = new Route('POST', $path, $handler);
        $this->routes->add($route);

        return $route;
    }

    public function getRoutes(): RouteCollection
    {
        return $this->routes;
    }
}