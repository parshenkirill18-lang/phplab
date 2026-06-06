<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($article['title'], ENT_QUOTES) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; color: #1a1a2e; min-height: 100vh; }
        .topbar { background: #1a1a2e; color: #fff; padding: 14px 32px; display: flex; align-items: center; gap: 12px; }
        .topbar a { color: #a8b4ff; text-decoration: none; font-size: 14px; }
        .topbar a:hover { text-decoration: underline; }
        .container { max-width: 760px; margin: 48px auto; padding: 0 20px; }
        .card { background: #fff; border-radius: 12px; padding: 40px 44px; box-shadow: 0 4px 24px rgba(0,0,0,.07); }
        .article-meta { display: flex; align-items: center; gap: 16px; margin-bottom: 24px; }
        .badge { background: #eef0ff; color: #4a5cdb; border-radius: 20px; padding: 4px 14px; font-size: 13px; font-weight: 600; }
        .author { color: #6b7280; font-size: 14px; }
        h1 { font-size: 28px; font-weight: 700; line-height: 1.3; margin-bottom: 20px; }
        .content { font-size: 16px; line-height: 1.8; color: #374151; border-top: 1px solid #e5e7eb; padding-top: 20px; margin-bottom: 32px; }
        .actions { display: flex; gap: 12px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
        .btn-primary { background: #4a5cdb; color: #fff; }
        .btn-primary:hover { background: #3a4bbf; }
        .btn-ghost { background: #f3f4f6; color: #374151; }
        .btn-ghost:hover { background: #e5e7eb; }
    </style>
</head>
<body>
<div class="topbar">
    <a href="<?= url('article') ?>">← Все статьи</a>
</div>
<div class="container">
    <div class="card">
        <div class="article-meta">
            <span class="badge">Статья #<?= (int) $article['id'] ?></span>
            <span class="author">Автор: <?= htmlspecialchars($article['author'], ENT_QUOTES) ?></span>
        </div>
        <h1><?= htmlspecialchars($article['title'], ENT_QUOTES) ?></h1>
        <div class="content">
            <?= nl2br(htmlspecialchars($article['content'], ENT_QUOTES)) ?>
        </div>
        <div class="actions">
            <a href="<?= url('article/' . $article['id'] . '/edit') ?>" class="btn btn-primary">Редактировать</a>
            <a href="<?= url('article') ?>" class="btn btn-ghost">Назад к списку</a>
        </div>
    </div>
</div>
</body>
</html>
