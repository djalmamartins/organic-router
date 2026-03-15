<?php

namespace Organic\Router;

class RouteCollection
{
    private array $staticRoutes = [];
    private array $dynamicRoutes = [];

    public function add(Route $route): void
    {
        $method = $route->getMethod();
        $path = $route->getPath();

        if (str_contains($path, '{')) {
            if (!isset($this->dynamicRoutes[$method])) {
                $this->dynamicRoutes[$method] = [];
            }
            $this->dynamicRoutes[$method][] = $route;
            return;
        }

        $this->staticRoutes[$method][$path] = $route;
    }

    public function getStatic(string $method, string $uri): ?Route
    {
        return $this->staticRoutes[$method][$uri] ?? null;
    }

    public function getDynamic(string $method): array
    {
        return $this->dynamicRoutes[$method] ?? [];
    }
}
