<?php $pageTitle = $book['title']; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="bc">
    <a href="<?= url('book') ?>">Каталог</a>
    <span>›</span>
    <?= htmlspecialchars(mb_substr($book['title'], 0, 50)) ?>
</div>

<div class="book-page">
    <div class="book-page-header">
        <div class="book-page-genre"><?= htmlspecialchars($book['genre'] ?: 'Разное') ?></div>
        <div class="book-page-title"><?= htmlspecialchars($book['title']) ?></div>
        <div class="book-page-meta">
            <span>Автор: <?= htmlspecialchars($book['author']) ?></span>
            <?php if ($book['year']): ?><span>Год: <?= (int)$book['year'] ?></span><?php endif; ?>
        </div>
    </div>
    <div class="book-page-body">
        <div class="book-price-tag"><?= number_format((float)$book['price'], 0, '.', ' ') ?> ₽</div>
        <?php if ($book['description']): ?>
            <div class="book-desc">
                <?php foreach (explode("\n", htmlspecialchars($book['description'])) as $p):
                    $p = trim($p); if ($p): ?><p><?= $p ?></p><?php endif;
                endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color:#888; font-size:13px;">Описание не добавлено.</p>
        <?php endif; ?>
    </div>
</div>

<div style="margin-top:16px; display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
    <form method="POST" action="<?= url('book/' . $book['id'] . '/cart') ?>">
        <input type="hidden" name="back" value="<?= url('book/' . $book['id']) ?>">
        <button type="submit" class="btn btn-primary">Добавить в корзину</button>
    </form>
    <a href="<?= url('book/' . $book['id'] . '/edit') ?>" class="btn">Редактировать</a>
    <form method="POST" action="<?= url('book/' . $book['id'] . '/delete') ?>"
          onsubmit="return confirm('Удалить эту книгу?')">
        <button class="btn btn-danger">Удалить</button>
    </form>
    <a href="<?= url('book') ?>" class="btn" style="margin-left:6px;">← В каталог</a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
