<?php
$title = $title ?? 'Мой блог';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($title) ?></h1>
        <nav><a href="/lab8/">Главная</a></nav>
    </header>
    <main>
        <?= $content ?>
    </main>
</body>
</html>