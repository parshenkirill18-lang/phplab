<a href="index.php">← Назад к списку</a>

<h2><?= htmlspecialchars($article['title']) ?></h2>

<p class="author">
    Автор: <strong><?= $author ? htmlspecialchars($author['nickname']) : 'Неизвестен' ?></strong>
</p>

<p><?= nl2br(htmlspecialchars($article['content'])) ?></p>