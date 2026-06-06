<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статьи</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; color: #1a1a2e; min-height: 100vh; }
        .topbar { background: #1a1a2e; color: #fff; padding: 14px 32px; font-size: 18px; font-weight: 700; }
        .container { max-width: 760px; margin: 48px auto; padding: 0 20px; }
        h1 { font-size: 26px; margin-bottom: 24px; }
        .article-card {
            background: #fff; border-radius: 10px; padding: 20px 24px; margin-bottom: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06); display: flex; align-items: center; justify-content: space-between;
        }
        .article-card h2 { font-size: 17px; font-weight: 600; }
        .article-card .meta { font-size: 13px; color: #6b7280; margin-top: 4px; }
        .actions { display: flex; gap: 8px; }
        .btn { padding: 7px 16px; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; }
        .btn-view { background: #eef0ff; color: #4a5cdb; }
        .btn-edit { background: #4a5cdb; color: #fff; }
        .btn-view:hover { background: #dde0ff; }
        .btn-edit:hover { background: #3a4bbf; }
    </style>
</head>
<body>
<div class="topbar">Паршинлаб10</div>
<div class="container">
    <h1>Все статьи</h1>
    <?php foreach ($articles as $a): ?>
        <div class="article-card">
            <div>
                <h2><?= htmlspecialchars($a['title'], ENT_QUOTES) ?></h2>
                <div class="meta">Автор: <?= htmlspecialchars($a['author'], ENT_QUOTES) ?> · ID: <?= $a['id'] ?></div>
            </div>
            <div class="actions">
                <a href="<?= url('article/' . $a['id']) ?>" class="btn btn-view">Читать</a>
                <a href="<?= url('article/' . $a['id'] . '/edit') ?>" class="btn btn-edit">Изменить</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
