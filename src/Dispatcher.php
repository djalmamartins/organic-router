<?php

namespace Organic\Router;

class Dispatcher
{
    private Matcher $matcher;

    public function __construct(RouteCollection $routes)
    {
        $this->matcher = new Matcher($routes);
    }

    public function dispatch(RequestContext $context)
    {
        $result = $this->matcher->match($context);

        if (!$result) {
            http_response_code(404);
            echo "404 - Route not found";
            return;
        }

        $route = $result['route'];
        $params = $result['params'];

        $middlewareStack = new MiddlewareStack($route->getMiddleware());

        return $middlewareStack->handle(
            $context,
            function () use ($route, $params) {
                return call_user_func_array($route->getHandler(), $params);
            }
        );
    }
}
