# Organic Router Internal Architecture

This document describes the internal architecture of the Organic Router.

The goal of this document is to define how the router works internally and how its components interact.

---

# Design Principles

Organic Router follows these core principles:

* Simplicity
* High performance
* Low memory usage
* Clear separation of responsibilities
* PSR compatibility
* Extensibility

The architecture is designed to allow the router to scale from small applications to large systems.

---

# Core Components

Organic Router is composed of the following internal components:

Router
Route
RouteCollection
Dispatcher
Matcher
ParameterParser
MiddlewareStack
RequestContext

Each component has a single responsibility.

---

# Router

The Router is responsible for registering routes.

Responsibilities:

* Register routes
* Define route groups
* Define domain-based routes
* Attach middleware
* Pass route definitions to RouteCollection

The Router does NOT resolve routes.

Route resolution is delegated to the Dispatcher.

Example:

$router->get('/users', handler);

---

# Route

The Route object represents a route definition.

Responsibilities:

* Store HTTP method
* Store route path
* Store route handler
* Store middleware
* Store domain restrictions

Example:

GET /users/{id}

Attributes stored in Route:

method
path
handler
parameters
middleware
domain

Routes are immutable once created.

---

# RouteCollection

RouteCollection stores all registered routes.

Responsibilities:

* Store routes grouped by HTTP method
* Separate static routes and parameterized routes
* Provide fast lookup structures for dispatching

Example structure:

routes = {
GET: {
static: [],
dynamic: []
}
}

This separation improves performance during dispatch.

---

# Dispatcher

Dispatcher is responsible for resolving incoming requests.

Responsibilities:

* Receive request context
* Ask Matcher to locate a route
* Execute middleware stack
* Execute route handler

Flow:

Request → Dispatcher → Matcher → Middleware → Handler

---

# Matcher

Matcher is responsible for matching the request with a registered route.

Matching order:

1 Domain
2 HTTP Method
3 Static Path
4 Parameterized Path

The matcher first checks static routes because they are faster to resolve.

If no static route matches, the matcher checks parameterized routes.

---

# ParameterParser

ParameterParser extracts parameters from dynamic routes.

Example:

Route:

/users/{id}

Request:

/users/42

Extracted parameters:

id = 42

These parameters are passed to the route handler.

---

# MiddlewareStack

MiddlewareStack manages middleware execution.

Responsibilities:

* Execute middleware in order
* Pass control to next middleware
* Execute route handler at the end

Flow:

Middleware 1
Middleware 2
Middleware 3
Handler

Middleware may follow PSR-15.

---

# RequestContext

RequestContext contains request information.

Attributes:

method
uri
host
headers
query parameters

Example:

method: GET
uri: /users/10
host: api.example.com

Dispatcher uses RequestContext to resolve routes.

---

# Routing Flow

Complete routing flow:

1 Request arrives
2 RequestContext is created
3 Dispatcher receives the context
4 Dispatcher calls Matcher
5 Matcher finds the matching route
6 ParameterParser extracts parameters
7 MiddlewareStack executes middleware
8 Route handler is executed
9 Response is returned

---

# Performance Strategy

Organic Router uses the following strategies to achieve high performance:

Static route lookup first

Separate storage for static and dynamic routes

Avoid expensive regex operations

Pre-compiled route patterns

Future optimizations:

Route caching
Compiled route tables

---

# Subdomain Routing

Routes may be grouped by domain.

Example:

api.example.com
admin.example.com

RouteCollection stores routes separated by domain to improve lookup speed.

Example:

routes = {
api.example.com: {...},
admin.example.com: {...}
}

---

# Error Handling

If no route is found:

404 Not Found

If method is not allowed:

405 Method Not Allowed

Exceptions may be used internally but should not break router execution.

---

# Future Architecture Extensions

Planned future features:

Route caching

Compiled route tables

Attribute based routing

PSR-7 request support

PSR-15 middleware pipeline
