<?php

require_once "connect.php";
require_once "menu.php";

$page = $_GET['page'] ?? 'view';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Lab 5</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?= menu($page); ?>
</header>

<main>

<?php

switch ($page) {

    case 'add':
        require "add.php";
        break;

    case 'edit':
        require "edit.php";
        break;

    case 'delete':
        require "delete.php";
        break;

    default:
        require "viewer.php";
        break;
}

?>

</main>

</body>
</html>