<?php

namespace Organic\Router;

class Matcher
{
    private RouteCollection $routes;

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function match(RequestContext $context): ?array
    {
        $method = $context->getMethod();
        $uri = $context->getUri();

        $route = $this->routes->getStatic($method, $uri);

        if ($route) {
            return ['route' => $route, 'params' => []];
        }

        foreach ($this->routes->getDynamic($method) as $route) {
            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $route->getPath());
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = [];
                foreach ($route->getParameters() as $i => $name) {
                    $params[$name] = $matches[$i + 1];
                }
                return ['route' => $route, 'params' => $params];
            }
        }

        return null;
    }
}
