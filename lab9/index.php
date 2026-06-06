<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'connect.php';
require_once 'ArticlesController.php';

$controller = new ArticlesController($pdo);

$page = $_GET['page'] ?? 'list';
$id   = isset($_GET['id']) ? (int) $_GET['id'] : 0;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статьи</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <a href="index.php">Все статьи</a>
</header>

<main>
<?php
    if ($page === 'show' && $id) {
        $controller->show($id);
    } else {
        $controller->index();
    }
?>
</main>

</body>
</html>