<?php

$sort = $_GET['sort'] ?? 'id';

if ($sort == 'surname') {
    $order = "surname ASC";
} elseif ($sort == 'birthdate') {
    $order = "birthdate ASC";
} else {
    $order = "id DESC";
}

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY $order");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Просмотр записей</h2>";

echo "<p>
<a href='index.php?page=view&sort=id'>По добавлению</a> |
<a href='index.php?page=view&sort=surname'>По фамилии</a> |
<a href='index.php?page=view&sort=birthdate'>По дате рождения</a>
</p>";

echo "<table border='1' cellpadding='5'>";

foreach ($rows as $r) {
    echo "<tr>
        <td>{$r['surname']}</td>
        <td>{$r['name']}</td>
        <td>{$r['phone']}</td>
        <td>{$r['email']}</td>
    </tr>";
}

echo "</table>";