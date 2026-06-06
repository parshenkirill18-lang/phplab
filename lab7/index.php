<?php

require_once 'controllers/MainController.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = trim($url, '/');

$controller = new MainController();

/*
    Роут 1: /lab7/bye/$name
*/
if (preg_match('#^lab7/bye/([^/]+)$#', $url, $matches)) {

    $controller->sayBye($matches[1]);

/*
    Роут 2: /lab7/hello/$name
*/
} elseif (preg_match('#^lab7/hello/([^/]+)$#', $url, $matches)) {

    $controller->sayHello($matches[1]);

/*
    404 ошибка
*/
} else {

    http_response_code(404);
    echo "404 — маршрут не найден";
}