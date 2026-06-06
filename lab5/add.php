<?php

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO contacts 
        (surname,name,patronymic,gender,birthdate,phone,address,email,comment)
        VALUES (?,?,?,?,?,?,?,?,?)
    ");

    $ok = $stmt->execute([
        $_POST['surname'],
        $_POST['name'],
        $_POST['patronymic'],
        $_POST['gender'],
        $_POST['birthdate'],
        $_POST['phone'],
        $_POST['address'],
        $_POST['email'],
        $_POST['comment']
    ]);

    $message = $ok ? "<p class='success'>Запись добавлена</p>"
                   : "<p class='error'>Ошибка добавления</p>";
}

echo $message;
?>

<form method="POST">

<input name="surname" placeholder="Фамилия"><br>
<input name="name" placeholder="Имя"><br>
<input name="patronymic" placeholder="Отчество"><br>

<select name="gender">
    <option value="мужской">мужской</option>
    <option value="женский">женский</option>
</select><br>

<input type="date" name="birthdate"><br>
<input name="phone" placeholder="Телефон"><br>
<input name="address" placeholder="Адрес"><br>
<input name="email" placeholder="Email"><br>

<textarea name="comment" placeholder="Комментарий"></textarea><br>

<button type="submit">Добавить</button>

</form>