<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лаба 2 - Feedback form</title>
    <style>
        body { font-family: Arial; margin: 0; }
        header, footer { background: #eee; padding: 10px; text-align: center; }
        header { display: flex; justify-content: space-between; align-items: center; }
        main { padding: 20px; }
        form { display: flex; flex-direction: column; gap: 10px; width: 300px; }
    </style>
</head>

<body>

<header>
    <div>МосПолитех</div>
    <h2>Лабораторная работа №2</h2>
    <div></div>
</header>

<main>

<form action="https://httpbin.org/post" method="POST">

    <input type="text" name="name" placeholder="Имя пользователя" required>

    <input type="email" name="email" placeholder="E-mail" required>

    <select name="type">
        <option value="complaint">Жалоба</option>
        <option value="suggestion">Предложение</option>
        <option value="thanks">Благодарность</option>
    </select>

    <textarea name="message" placeholder="Текст обращения"></textarea>

    <label>
        <input type="checkbox" name="reply_sms"> SMS
    </label>

    <label>
        <input type="checkbox" name="reply_email"> E-mail
    </label>

    <button type="submit">Отправить</button>

</form>

<br>

<a href="headers.php">Перейти на 2 страницу</a>

</main>

<footer>
    Паршин Кирилл Николаевич 251-3210
</footer>

</body>
</html>