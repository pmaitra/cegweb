<?php

// Get ALL routes
// --------------
$allRoutes = [];
$routes = $app->getContainer()->router->getRoutes();

foreach ($routes as $route) {
  array_push($allRoutes, $route->getPattern());
}

$container['allRoutes'] = $allRoutes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/[check]', function ($request, $response, $args) {
    $name =array('status'=>200);
if($name) {
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($name));

} else { throw new PDOException('No records found');}
    
});
include_once 'api_v1.php';
include_once 'helpers.php';





