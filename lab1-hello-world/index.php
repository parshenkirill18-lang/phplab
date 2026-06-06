<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Lab 1</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 30px;
            background: #000c8b;
            color: white;
        }

        header img {
            height: 50px;
        }

        main {
            text-align: center;
            padding: 80px 20px;
            font-size: 24px;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: #222;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .time {
            margin-top: 10px;
            font-size: 18px;
            color: #100a0a;
        }
    </style>
</head>
<body>

<header>
    <img src="logo.png" alt="logo">
    <h2>Лабораторная работа номер один выполнил Паршин Кирилл Николаевич 251-3210</h2>
</header>

<main>
    <h1>Hello, World!</h1>

    <div class="time">
        <?php
            echo "Текущее время: " . date("H:i:s");
        ?>
    </div>
</main>

<footer>
    задание для самостоятельной работы
</footer>

</body>
</html>