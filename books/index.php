<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/autoload.php';

define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

function url(string $path): string {
    return BASE_PATH . '/' . ltrim($path, '/');
}

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim(substr($requestPath, strlen(BASE_PATH)), '/');

$routes = [
    '~^book/(\d+)/edit$~'   => [\MyProject\Controllers\BookController::class, 'edit'],
    '~^book/(\d+)/delete$~' => [\MyProject\Controllers\BookController::class, 'delete'],
    '~^book/(\d+)/cart$~'   => [\MyProject\Controllers\BookController::class, 'cartAdd'],
    '~^book/(\d+)$~'        => [\MyProject\Controllers\BookController::class, 'view'],
    '~^book/create$~'       => [\MyProject\Controllers\BookController::class, 'create'],
    '~^book/?$~'            => [\MyProject\Controllers\BookController::class, 'index'],
    '~^cart/(\d+)/update$~' => [\MyProject\Controllers\BookController::class, 'cartUpdate'],
    '~^cart/(\d+)/remove$~' => [\MyProject\Controllers\BookController::class, 'cartRemove'],
    '~^cart/clear$~'        => [\MyProject\Controllers\BookController::class, 'cartClear'],
    '~^cart$~'               => [\MyProject\Controllers\BookController::class, 'cartView'],
    '~^$~'                   => [\MyProject\Controllers\BookController::class, 'index'],
];

$matched = false;

foreach ($routes as $pattern => $handler) {
    if (preg_match($pattern, $uri, $matches)) {
        [$controllerClass, $method] = $handler;
        $controller = new $controllerClass();
        $id = $matches[1] ?? null;
        $controller->$method($id);
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}
