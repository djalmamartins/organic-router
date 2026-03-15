<?php

namespace Organic\Router;

class MiddlewareStack
{
    private array $middlewares;

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function handle($request, callable $handler)
    {
        $next = $handler;

        foreach (array_reverse($this->middlewares) as $middleware) {
            $next = function ($request) use ($middleware, $next) {
                $instance = new $middleware();
                return $instance->handle($request, $next);
            };
        }

        return $next($request);
    }
}
