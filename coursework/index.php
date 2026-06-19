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
    '~^article/(\d+)/edit$~'   => [\MyProject\Controllers\ArticleController::class, 'edit'],
    '~^article/(\d+)/delete$~' => [\MyProject\Controllers\ArticleController::class, 'delete'],
    '~^article/(\d+)$~'        => [\MyProject\Controllers\ArticleController::class, 'view'],
    '~^article/create$~'       => [\MyProject\Controllers\ArticleController::class, 'create'],
    '~^article/?$~'            => [\MyProject\Controllers\ArticleController::class, 'index'],
    '~^$~'                     => [\MyProject\Controllers\ArticleController::class, 'index'],
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
