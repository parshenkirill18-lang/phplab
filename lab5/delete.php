<?php

$id = $_GET['id'] ?? null;

$list = $pdo->query("SELECT id,surname,name FROM contacts")->fetchAll();

echo "<h2>Удаление</h2>";

foreach ($list as $l) {
    echo "<a href='index.php?page=delete&id={$l['id']}'>
    {$l['surname']} {$l['name']}</a><br>";
}

if ($id) {

    $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id=?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    $pdo->prepare("DELETE FROM contacts WHERE id=?")->execute([$id]);

    echo "<p class='error'>Удалена запись: {$row['surname']}</p>";
}