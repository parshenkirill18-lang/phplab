<?php $pageTitle = 'Каталог книг'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-title">
    <?= $filterGenre ? htmlspecialchars($filterGenre) : 'Каталог книг' ?>
</div>

<!-- жанры -->
<div class="genre-tabs">
    <a href="<?= url('book') ?>" class="genre-tab <?= !$filterGenre ? 'active' : '' ?>">Все жанры</a>
    <?php foreach ($genres as $g): ?>
        <a href="<?= url('book') ?>?genre=<?= urlencode($g) ?>"
           class="genre-tab <?= $filterGenre === $g ? 'active' : '' ?>">
            <?= htmlspecialchars($g) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- фильтр -->
<div class="filter-box">
    <form method="GET" action="<?= url('book') ?>">
        <?php if ($filterGenre): ?>
            <input type="hidden" name="genre" value="<?= htmlspecialchars($filterGenre) ?>">
        <?php endif; ?>
        <div class="filter-row">
            <div class="fg">
                <label>Название</label>
                <input type="text" name="title" value="<?= htmlspecialchars($filterTitle) ?>" placeholder="Поиск по названию...">
            </div>
            <div class="fg">
                <label>Автор</label>
                <input type="text" name="author" value="<?= htmlspecialchars($filterAuthor) ?>" placeholder="Поиск по автору...">
            </div>
            <div class="sort-group">
                <label>Сортировка</label>
                <div class="sort-btns">
                    <button type="submit" name="sort" value="added_at" class="sort-btn <?= $sortBy==='added_at'?'active':'' ?>">По дате</button>
                    <button type="submit" name="sort" value="title"    class="sort-btn <?= $sortBy==='title'   ?'active':'' ?>">По названию</button>
                    <button type="submit" name="sort" value="author"   class="sort-btn <?= $sortBy==='author'  ?'active':'' ?>">По автору</button>
                    <button type="submit" name="sort" value="year"     class="sort-btn <?= $sortBy==='year'    ?'active':'' ?>">По году</button>
                    <button type="submit" name="sort" value="price"    class="sort-btn <?= $sortBy==='price'   ?'active':'' ?>">По цене</button>
                    <input type="hidden" name="dir" value="<?= $sortDir==='asc'?'desc':'asc' ?>">
                    <button type="submit" class="sort-btn"><?= $sortDir==='asc'?'↑':'↓' ?></button>
                </div>
            </div>
            <div style="display:flex;gap:6px;align-items:flex-end">
                <button type="submit" class="btn btn-primary">Найти</button>
                <a href="<?= url('book') ?>" class="btn">Сбросить</a>
            </div>
        </div>
    </form>
</div>

<div class="count-label">Найдено: <?= count($books) ?> из <?= $totalCount ?></div>

<?php if (empty($books)): ?>
    <p style="color:#888; font-size:13px;">Ничего не найдено.</p>
<?php else: ?>
    <?php foreach ($books as $b): ?>
    <div class="book-card">
        <div class="book-info">
            <div class="book-title">
                <span class="genre-badge"><?= htmlspecialchars($b['genre'] ?: 'Разное') ?></span>
                <a href="<?= url('book/' . $b['id']) ?>"><?= htmlspecialchars($b['title']) ?></a>
            </div>
            <div class="book-meta">
                <span><?= htmlspecialchars($b['author']) ?></span>
                <?php if ($b['year']): ?><span><?= (int)$b['year'] ?> г.</span><?php endif; ?>
                <span class="book-price"><?= number_format((float)$b['price'], 0, '.', ' ') ?> ₽</span>
            </div>
        </div>
        <div class="book-actions">
            <a href="<?= url('book/' . $b['id']) ?>"           class="btn">Подробнее</a>
            <form method="POST" action="<?= url('book/' . $b['id'] . '/cart') ?>">
                <input type="hidden" name="back" value="<?= url('book') . (isset($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING']) : '') ?>">
                <button type="submit" class="btn btn-primary">В корзину</button>
            </form>
            <a href="<?= url('book/' . $b['id'] . '/edit') ?>" class="btn">Изменить</a>
            <form method="POST" action="<?= url('book/' . $b['id'] . '/delete') ?>"
                  onsubmit="return confirm('Удалить книгу «<?= htmlspecialchars(addslashes($b['title'])) ?>»?')">
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
