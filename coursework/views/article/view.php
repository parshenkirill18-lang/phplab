<?php $pageTitle = $article['title']; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="page-wrap" style="max-width: 820px;">

    <nav style="font-size:13px; color: var(--ink-dim); margin-bottom: 28px;">
        <a href="<?= url('article') ?>" style="color:var(--ink-dim); text-decoration:none;">← Все статьи</a>
    </nav>

    <article>
        <header class="article-hero">
            <div class="card-eyebrow">
                <span class="cat-tag">
                    <?= htmlspecialchars($article['category'] ?: 'Разное', ENT_QUOTES) ?>
                </span>
                <span><?= date('d F Y', strtotime($article['created_at'])) ?></span>
            </div>
            <h1 class="article-title"><?= htmlspecialchars($article['title'], ENT_QUOTES) ?></h1>
            <div class="article-byline">
                <span>✍ <?= htmlspecialchars($article['author'], ENT_QUOTES) ?></span>
                <span>⏱ <?= $readingTime ?> мин чтения</span>
                <span>📝 <?= number_format(str_word_count($article['content'])) ?> слов</span>
                <span>🔢 ID <?= (int)$article['id'] ?></span>
            </div>
        </header>

        <div class="article-body">
            <?php foreach (explode("\n", htmlspecialchars($article['content'], ENT_QUOTES)) as $para):
                $para = trim($para);
                if ($para !== ''): ?>
                <p><?= nl2br($para) ?></p>
            <?php endif; endforeach; ?>
        </div>
    </article>

    <hr class="section-rule" style="margin-top: 40px;">

    <div style="display:flex; gap:12px; justify-content:space-between; align-items:center; flex-wrap:wrap;">
        <a href="<?= url('article') ?>" class="btn btn-outline">← К списку</a>
        <div style="display:flex; gap:10px;">
            <a href="<?= url('article/' . $article['id'] . '/edit') ?>" class="btn btn-primary">Редактировать</a>
            <form method="POST" action="<?= url('article/' . $article['id'] . '/delete') ?>"
                  onsubmit="return confirm('Удалить статью? Это действие нельзя отменить.')">
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
        </div>
    </div>

</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
