<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$router = app('router');
$routes = $router->getRoutes();

echo "Routes registered:\n";
foreach ($routes as $route) {
    echo $route->domain() . " " . $route->uri() . " -> " . $route->getName() . "\n";
}
