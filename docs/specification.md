# Organic Router Specification

This document defines the functional specification of the Organic Router.

The purpose of this specification is to define the expected behavior of the router before implementation.

---

# Core Concepts

Organic Router is built around four core components:

* Router
* Route
* Dispatcher
* RequestContext

Router is responsible for registering routes.

Route represents a route definition.

Dispatcher is responsible for matching requests to routes.

RequestContext encapsulates HTTP request data.

---

# Route Registration

Routes are registered using HTTP method helpers.

Example:

$router->get('/users', handler);
$router->post('/users', handler);
$router->put('/users/{id}', handler);
$router->delete('/users/{id}', handler);

Supported methods:

GET
POST
PUT
PATCH
DELETE
OPTIONS

---

# Route Parameters

Routes may contain parameters.

Example:

/users/{id}

/posts/{slug}

Parameters are extracted and passed to the route handler.

Example:

$router->get('/users/{id}', function($id){
return "User {$id}";
});

---

# Route Matching

The router must match routes using:

1. HTTP method
2. Path
3. Domain (optional)

Matching order:

1. Domain
2. HTTP method
3. Path pattern

---

# Subdomain Routing

Routes may be grouped by domain.

Example:

$router->domain('api.example.com', function($router){

```
$router->get('/users', handler);
```

});

---

# Middleware

Routes may define middleware.

Example:

$router->middleware(AuthMiddleware::class)
->get('/dashboard', handler);

Middleware must follow PSR-15 if PSR support is enabled.

---

# Dispatcher

Dispatcher resolves incoming requests.

Example:

$router->dispatch($method, $uri, $host);

Expected behavior:

1. Find matching route
2. Extract parameters
3. Execute middleware stack
4. Execute route handler

---

# Error Handling

If no route is found:

HTTP status code must be 404.

If method is not allowed:

HTTP status code must be 405.

---

# Performance Goals

Organic Router aims to achieve:

* minimal memory footprint
* O(1) lookup for static routes
* optimized parameter matching

Future optimization includes route compilation and route caching.

---

# Versioning

Organic Router follows Semantic Versioning.

0.x.x represents development phase.

1.0.0 represents the first stable release.
