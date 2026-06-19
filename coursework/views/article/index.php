<?php
$pageTitle  = 'Все статьи';
$currentPage = 'index';

function catClass(string $cat): string {
    return match($cat) {
        'Технологии' => 'tech',
        'Наука'      => 'sci',
        'Культура'   => 'cult',
        'Спорт'      => 'sport',
        default      => 'misc',
    };
}
?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="page-wrap">
    <div class="two-col">

        <!-- ── Лента статей ── -->
        <section>
            <div class="page-header">
                <h1>Все статьи</h1>
                <p><?= $totalCount ?> материал<?= $totalCount === 1 ? '' : ($totalCount < 5 ? 'а' : 'ов') ?> в базе</p>
            </div>

            <?php if (empty($articles)): ?>
                <div class="alert alert-error">
                    Статей пока нет. <a href="<?= url('article/create') ?>">Добавьте первую!</a>
                </div>
            <?php else: ?>
                <?php foreach ($articles as $a):
                    $words   = str_word_count(strip_tags($a['excerpt']));
                    $excerpt = mb_substr($a['excerpt'], 0, 220);
                    if (mb_strlen($a['excerpt']) > 220) $excerpt .= '…';
                ?>
                <article class="article-card">
                    <div class="card-eyebrow">
                        <span class="cat-tag <?= catClass($a['category'] ?? '') ?>">
                            <?= htmlspecialchars($a['category'] ?: 'Разное', ENT_QUOTES) ?>
                        </span>
                        <span><?= date('d.m.Y', strtotime($a['created_at'])) ?></span>
                    </div>
                    <h2><a href="<?= url('article/' . $a['id']) ?>"><?= htmlspecialchars($a['title'], ENT_QUOTES) ?></a></h2>
                    <p class="card-excerpt"><?= htmlspecialchars($excerpt, ENT_QUOTES) ?></p>
                    <div class="card-footer">
                        <span class="card-meta">
                            <strong><?= htmlspecialchars($a['author'], ENT_QUOTES) ?></strong>
                            &nbsp;·&nbsp; <?= number_format($a['content_length']) ?> симв.
                        </span>
                        <div class="card-actions">
                            <a href="<?= url('article/' . $a['id']) ?>" class="btn btn-outline btn-sm">Читать</a>
                            <a href="<?= url('article/' . $a['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Изменить</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- ── Сайдбар ── -->
        <aside>
            <div class="sidebar-widget">
                <div class="widget-title">Статистика</div>
                <div class="stat-row">
                    <span>Всего статей</span>
                    <span class="stat-num"><?= $totalCount ?></span>
                </div>
                <div class="stat-row">
                    <span>Категорий</span>
                    <span class="stat-num"><?= count($stats) ?></span>
                </div>
            </div>

            <?php if (!empty($stats)): ?>
            <div class="sidebar-widget">
                <div class="widget-title">По категориям</div>
                <?php foreach ($stats as $s): ?>
                <div class="cat-bar">
                    <div class="cat-bar-label">
                        <span><?= htmlspecialchars($s['category'] ?: 'Разное', ENT_QUOTES) ?></span>
                        <span><?= $s['cnt'] ?></span>
                    </div>
                    <div class="cat-bar-track">
                        <div class="cat-bar-fill" style="width: <?= min(100, round($s['cnt'] / max(1, $totalCount) * 100)) ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="sidebar-widget">
                <div class="widget-title">Действия</div>
                <a href="<?= url('article/create') ?>" class="btn btn-primary" style="width:100%;justify-content:center;">
                    + Написать статью
                </a>
            </div>
        </aside>

    </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
