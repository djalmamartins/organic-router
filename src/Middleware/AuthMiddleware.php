<?php

namespace Organic\Router\Middleware;

use Organic\Router\Contracts\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, callable $next)
    {
        if (!isset($_GET['token'])) {
            echo "Unauthorized";
            return;
        }

        return $next($request);
    }
}
