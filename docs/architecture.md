# Organic Router Architecture

Organic Router is designed with a clean and modular architecture.

Core components:

* Router
* Route
* Dispatcher
* RequestContext

Responsibilities:

Router
Responsible for registering routes.

Route
Represents a route definition.

Dispatcher
Responsible for matching incoming requests to routes.

RequestContext
Encapsulates request information such as method, URI and host.
