
# Organic Router

![Packagist Version](https://img.shields.io/packagist/v/organic/router)
![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue)
![License](https://img.shields.io/packagist/l/organic/router)
![Downloads](https://img.shields.io/packagist/dt/organic/router)

Organic Router is a lightweight and expressive HTTP router for PHP.

It focuses on simplicity, performance and developer experience while remaining dependency‑free and easy to integrate into any PHP project.

---

# Installation

Install via composer:

```bash
composer require organic/router
```

---

# Quick Start

```php
use Organic\Router\Application;

require __DIR__.'/vendor/autoload.php';

$app = new Application();

$app->get('/', function () {
    echo "Hello Organic!";
});

$app->get('/users', function () {
    echo "Users list";
});

$app->get('/users/{id}', function ($id) {
    echo "User {$id}";
});

$app->run();
```

Example routes:

```
GET /
GET /users
GET /users/{id}
```

---

# Route Parameters

Dynamic parameters are supported using curly braces.

```php
$app->get('/users/{id}', function ($id) {
    echo "User {$id}";
});
```

Example request:

```
/users/10
```

Output:

```
User 10
```

---

# Middleware

Organic Router includes a middleware pipeline.

```php
$app->get('/dashboard', function () {
    echo "Dashboard";
})->middleware(AuthMiddleware::class);
```

Example middleware:

```php
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
```

---

# Project Structure

Typical project structure:

```
project/

src/
public/
vendor/

public/index.php
composer.json
```

Example `public/index.php`:

```php
require __DIR__.'/../vendor/autoload.php';

use Organic\Router\Application;

$app = new Application();

$app->get('/', function () {
    echo "Home";
});

$app->run();
```

---

# Architecture

Organic Router follows a simple and clean internal architecture.

```
Request
   ↓
RequestContext
   ↓
Matcher
   ↓
Dispatcher
   ↓
MiddlewareStack
   ↓
Handler
```

Core components:

| Component | Responsibility |
|--------|--------|
| Application | Entry point and router configuration |
| Router | Registers routes |
| RouteCollection | Stores static and dynamic routes |
| Matcher | Matches request URI |
| Dispatcher | Executes route handlers |
| MiddlewareStack | Executes middleware pipeline |

---

# Features

- Simple and expressive API
- Dynamic route parameters
- Middleware support
- Lightweight architecture
- Zero external dependencies
- PSR‑4 autoloading
- Easy integration with any PHP project

---

# Why Organic Router?

Organic Router was created to provide a simple routing solution without the complexity of full frameworks.

Goals:

- simplicity
- performance
- flexibility
- minimal footprint

It can be used in:

- micro frameworks
- APIs
- custom MVC architectures
- lightweight applications

---

# Example API

```php
$app->get('/api/users', function () {
    return json_encode([
        "users" => []
    ]);
});
```

---

# Development

Clone the repository:

```bash
git clone https://github.com/djalmamartins/organic-router.git
```

Install dependencies:

```bash
composer install
```

---

# Roadmap

Upcoming improvements planned for future versions.

## v1.1

- Route Groups
- Base Path configuration
- Improved middleware pipeline

Example:

```php
$app->group('/api', function ($app) {

    $app->get('/users', ...);

});
```

---

## v1.2

- Subdomain routing
- Route caching
- Performance improvements

---

## v2.0

- Compiled routes
- PSR‑7 request support
- PSR‑15 middleware compatibility
- High performance routing engine

---

# License

MIT License

---

# Author

Djalma Martins  
https://github.com/djalmamartins
