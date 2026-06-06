<h2>Список статей</h2>
 
<table>
    <tr>
        <th>ID</th>
        <th>Заголовок</th>
        <th></th>
    </tr>
    <?php foreach ($articles as $a): ?>
    <tr>
        <td><?= $a['id'] ?></td>
        <td><?= htmlspecialchars($a['title']) ?></td>
        <td><a href="index.php?page=show&id=<?= $a['id'] ?>">Читать</a></td>
    </tr>
    <?php endforeach; ?>
</table>
 