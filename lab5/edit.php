<?php

$id = $_GET['id'] ?? null;

// список
$list = $pdo->query("SELECT id,surname,name FROM contacts ORDER BY surname")->fetchAll();

echo "<h2>Редактирование</h2>";

foreach ($list as $l) {
    echo "<a href='index.php?page=edit&id={$l['id']}'>
    {$l['surname']} {$l['name']}</a><br>";
}

if ($id) {

    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $stmt = $pdo->prepare("
            UPDATE contacts SET 
            surname=?,name=?,patronymic=?,gender=?,birthdate=?,phone=?,address=?,email=?,comment=?
            WHERE id=?
        ");

        $stmt->execute([
            $_POST['surname'],
            $_POST['name'],
            $_POST['patronymic'],
            $_POST['gender'],
            $_POST['birthdate'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['email'],
            $_POST['comment'],
            $id
        ]);

        echo "<p class='success'>Обновлено</p>";
    }

?>

<form method="POST">

<input name="surname" value="<?= $row['surname'] ?>"><br>
<input name="name" value="<?= $row['name'] ?>"><br>
<input name="patronymic" value="<?= $row['patronymic'] ?>"><br>

<input name="phone" value="<?= $row['phone'] ?>"><br>
<input name="email" value="<?= $row['email'] ?>"><br>

<textarea name="comment"><?= $row['comment'] ?></textarea><br>

<button>Сохранить</button>

</form>

<?php } ?>