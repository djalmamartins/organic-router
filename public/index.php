
<?php

require __DIR__ . '/../vendor/autoload.php';

use Organic\Router\Application;
use Organic\Router\Middleware\AuthMiddleware;

$app = new Application();

$app->get('/', function () {
    echo "Home";
});

$app->get('/users', function () {
    echo "Users";
});

$app->get('/users/{id}', function ($id) {
    echo "User {$id}";
});

$app->get('/dashboard', function () {
    echo "Dashboard";
})->middleware(AuthMiddleware::class);

$app->run();
