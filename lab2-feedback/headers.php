<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Headers</title>
    <style>
        body { font-family: Arial; margin: 0; }
        header, footer { background: #eee; padding: 10px; text-align: center; }
        main { padding: 20px; }
        textarea { width: 100%; height: 400px; }
    </style>
</head>

<body>

<header>
    <div> МосПолитех</div>
    <h2>Лабораторная работа №2</h2>
    <div></div>
</header>

<main>

<?php
$url = "https://example.com";
$headers = get_headers($url);

echo "<textarea>";

foreach ($headers as $h) {
    echo $h . "\n";
}

echo "</textarea>";
?>

<br>
<a href="index.php">Назад</a>

</main>

<footer>
    Паршин Кирилл Н 251-3210
</footer>

</body>
</html>