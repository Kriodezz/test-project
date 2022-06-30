<?php

require_once __DIR__ . '/../vendor/autoload.php';

$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/../src/routes.php';

$isRouteFound = false;

foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    $view = new \Tara\TestProject\View\View(__DIR__ . '/templates/errors');
    $view->renderHtml('404.html', [], 404);
}

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

unset($matches[0]);

$controller = new $controllerName();
$controller->$actionName(...$matches);
