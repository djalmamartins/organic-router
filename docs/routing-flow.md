# Organic Router Routing Flow

This document describes the internal routing flow of Organic Router.

It explains how an incoming HTTP request is processed until a route handler is executed.

---

# Overview

The routing process transforms an incoming HTTP request into the execution of a matching route handler.

The routing system must perform the following steps:

1 Receive request data
2 Create a request context
3 Match a route
4 Extract parameters
5 Execute middleware
6 Execute the route handler
7 Return a response

---

# Routing Flow Diagram

Incoming HTTP Request
│
▼
Create RequestContext
│
▼
Dispatcher
│
▼
Matcher
│
├── Static Route Match
│
└── Dynamic Route Match
│
▼
ParameterParser
│
▼
MiddlewareStack
│
▼
Route Handler
│
▼
Response

---

# Step 1 — HTTP Request

A request arrives from the web server.

Example request:

GET /users/42
Host: api.example.com

The router does not directly read global variables.

Instead, request data is encapsulated inside RequestContext.

---

# Step 2 — RequestContext Creation

RequestContext collects request information.

Attributes include:

method
uri
host
query parameters
headers

Example:

method = GET
uri = /users/42
host = api.example.com

This object is passed to the dispatcher.

---

# Step 3 — Dispatcher

Dispatcher coordinates the routing process.

Responsibilities:

* Receive RequestContext
* Call Matcher
* Execute middleware stack
* Execute route handler

Dispatcher does not contain route definitions.

Routes are stored in RouteCollection.

---

# Step 4 — Matcher

Matcher searches for a matching route.

Matching order:

1 Domain
2 HTTP Method
3 Static routes
4 Dynamic routes

Example:

GET /users

Static match.

Example:

GET /users/42

Dynamic match.

---

# Step 5 — Static Route Matching

Static routes are checked first because they are faster.

Example:

/users
/about
/contact

These routes can be matched using direct hash lookups.

---

# Step 6 — Dynamic Route Matching

Dynamic routes contain parameters.

Example:

/users/{id}
/posts/{slug}

Matcher compares URI segments with route patterns.

Example:

URI:
/users/42

Pattern:
/users/{id}

Matched parameters:

id = 42

---

# Step 7 — Parameter Extraction

ParameterParser extracts parameters from the matched route.

Example:

Route:
/users/{id}

Request:
/users/42

Extracted parameters:

{
"id": 42
}

These parameters are passed to the route handler.

---

# Step 8 — Middleware Execution

If the route defines middleware, the middleware stack is executed.

Example middleware chain:

AuthMiddleware
LoggingMiddleware
RateLimitMiddleware

Execution order:

Middleware 1 → Middleware 2 → Middleware 3 → Handler

Middleware may modify request data or stop execution.

---

# Step 9 — Route Handler Execution

After middleware execution, the route handler is executed.

Example handler:

function($id){
return "User {$id}";
}

Handler receives extracted parameters.

---

# Step 10 — Response

The handler returns a response.

Example:

User 42

Future versions of Organic Router may support PSR-7 Response objects.

---

# Error Scenarios

Organic Router must handle the following errors.

Route not found:

HTTP 404

Method not allowed:

HTTP 405

Invalid parameters:

HTTP 400

---

# Performance Considerations

Organic Router prioritizes performance by:

Checking static routes first

Separating static and dynamic route storage

Avoiding expensive regex operations

Reducing object allocations during dispatch

Future improvements may include:

Compiled route tables

Route caching

Pre-compiled match trees

---

# Summary

The routing process in Organic Router follows this pipeline:

Request → Context → Dispatcher → Matcher → ParameterParser → Middleware → Handler → Response

This architecture ensures:

high performance
clean separation of responsibilities
future extensibility
