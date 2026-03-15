# Organic Router Code Structure

This document defines the internal code structure of the Organic Router.

The goal is to maintain a clear and scalable architecture that separates responsibilities across different components.

---

# Source Directory Structure

The source code is located in the src directory.

Structure:

src/

Router.php
Route.php
RouteCollection.php
Dispatcher.php
Matcher.php
ParameterParser.php
RequestContext.php
MiddlewareStack.php

Exceptions/
Contracts/
Support/

---

# Namespace

All classes use the following namespace:

Organic\Router

Example:

namespace Organic\Router;

Subdirectories use nested namespaces.

Example:

namespace Organic\Router\Exceptions;

---

# Router

File:

src/Router.php

Responsibilities:

* Register routes
* Define route groups
* Attach middleware
* Define domain routing
* Send route definitions to RouteCollection

Router is the main entry point of the library.

Example usage:

$router = new Router();

$router->get('/users', handler);

Router does NOT perform route matching.

---

# Route

File:

src/Route.php

Route represents a route definition.

Attributes stored inside Route:

method
path
handler
parameters
middleware
domain

Example route:

GET /users/{id}

Route objects are immutable once created.

---

# RouteCollection

File:

src/RouteCollection.php

RouteCollection stores all routes registered by Router.

Responsibilities:

* Store routes grouped by HTTP method
* Separate static and dynamic routes
* Provide efficient structures for dispatching

Example structure:

routes = {

GET: {

static: {},
dynamic: []

}

}

Static routes are stored in associative arrays for fast lookup.

Dynamic routes are stored in ordered lists.

---

# Dispatcher

File:

src/Dispatcher.php

Dispatcher is responsible for resolving incoming requests.

Responsibilities:

* Receive RequestContext
* Use Matcher to locate routes
* Execute middleware
* Execute route handler

Dispatcher coordinates the routing pipeline.

---

# Matcher

File:

src/Matcher.php

Matcher is responsible for finding a matching route.

Matching order:

1 Domain
2 HTTP Method
3 Static path
4 Dynamic path

Static routes are checked first because they are faster.

If no static route matches, dynamic routes are evaluated.

---

# ParameterParser

File:

src/ParameterParser.php

ParameterParser extracts parameters from dynamic routes.

Example:

Route:

/users/{id}

Request:

/users/42

Extracted parameters:

id = 42

Parameters are returned as an associative array.

---

# RequestContext

File:

src/RequestContext.php

RequestContext encapsulates request information.

Attributes:

method
uri
host
query parameters
headers

Example:

method = GET
uri = /users/42
host = api.example.com

Dispatcher receives RequestContext instead of raw globals.

---

# MiddlewareStack

File:

src/MiddlewareStack.php

MiddlewareStack manages middleware execution.

Responsibilities:

* Execute middleware sequentially
* Pass control to the next middleware
* Execute route handler

Example flow:

Middleware → Middleware → Handler

Future versions may support PSR-15 middleware.

---

# Exceptions

Directory:

src/Exceptions/

Custom exceptions used internally.

Examples:

RouteNotFoundException
MethodNotAllowedException
InvalidRouteException

These exceptions help keep error handling consistent.

---

# Contracts

Directory:

src/Contracts/

Contains interfaces used by the router.

Examples:

MiddlewareInterface
HandlerInterface

Using contracts allows developers to extend the router easily.

---

# Support

Directory:

src/Support/

Contains helper utilities used internally.

Examples:

PathNormalizer
UriParser
ParameterBag

These classes are not part of the public API.

---

# Public API

The public API of Organic Router should remain minimal.

Primary public class:

Router

Internal classes should not be used directly by end users.

---

# Future Extensions

Future architecture improvements may include:

Route caching

Compiled route matcher

Attribute-based routing

PSR-7 request integration

PSR-15 middleware pipeline

---

# Summary

The Organic Router architecture follows a modular structure designed for:

clarity
maintainability
performance
extensibility

The separation of components ensures that the router can evolve without breaking the public API.
