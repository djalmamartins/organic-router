<?php

namespace Organic\Router;

class Route
{
    private string $method;
    private string $path;
    private $handler;
    private array $parameters = [];
    private array $middleware = [];

    public function __construct(string $method, string $path, callable $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;

        preg_match_all('/\{(\w+)\}/', $path, $matches);
        $this->parameters = $matches[1] ?? [];
    }

    public function middleware(string $middleware): self
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): callable
    {
        return $this->handler;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
