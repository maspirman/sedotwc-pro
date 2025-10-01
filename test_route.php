<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Test route resolution
try {
    $router = app('router');
    $routes = $router->getRoutes();
    $testimonialRoutes = [];

    foreach ($routes as $route) {
        $name = $route->getName();
        if (str_contains($name, 'testimonial')) {
            $testimonialRoutes[] = $name;
        }
    }

    echo "Found testimonial routes: " . count($testimonialRoutes) . "\n";
    foreach ($testimonialRoutes as $routeName) {
        echo "- $routeName\n";
    }

    $route = $routes->getByName('admin.testimonials.index');

    if ($route) {
        echo "✅ Route 'admin.testimonials.index' found\n";
        echo "URI: " . $route->uri() . "\n";
        echo "Methods: " . implode(', ', $route->methods()) . "\n";
        echo "Controller: " . $route->getAction('controller') . "\n";
        echo "Middleware: " . implode(', ', $route->middleware()) . "\n";
    } else {
        echo "❌ Route 'admin.testimonials.index' not found\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
