<?php

namespace Organic\Router;

class RequestContext
{
    private string $method;
    private string $uri;
    private string $host;

    public function __construct(string $method, string $uri, string $host)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->host = $host;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public static function fromGlobals(): self
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = dirname($_SERVER['SCRIPT_NAME']);

        if ($base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        if ($uri === '') {
            $uri = '/';
        }

        return new self($_SERVER['REQUEST_METHOD'], $uri, $_SERVER['HTTP_HOST']);
    }
}
