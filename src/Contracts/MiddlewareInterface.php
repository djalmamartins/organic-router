<?php

namespace Organic\Router\Contracts;

interface MiddlewareInterface
{
    public function handle($request, callable $next);
}
