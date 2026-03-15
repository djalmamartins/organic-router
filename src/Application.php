<?php

namespace Organic\Router;

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function get(string $path, callable $handler)
    {
        return $this->router->get($path, $handler);
    }

    public function post(string $path, callable $handler)
    {
        return $this->router->post($path, $handler);
    }

    public function run(): void
    {
        $context = RequestContext::fromGlobals();

        $dispatcher = new Dispatcher(
            $this->router->getRoutes()
        );

        $dispatcher->dispatch($context);
    }
}