<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать: <?= htmlspecialchars($article['title'], ENT_QUOTES) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f2f5; color: #1a1a2e; min-height: 100vh; }
        .topbar { background: #1a1a2e; color: #fff; padding: 14px 32px; display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .topbar a { color: #a8b4ff; text-decoration: none; }
        .topbar a:hover { text-decoration: underline; }
        .topbar .sep { color: #555a7a; }
        .container { max-width: 720px; margin: 48px auto; padding: 0 20px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; }
        .page-header h1 { font-size: 24px; font-weight: 700; }
        .article-id { background: #eef0ff; color: #4a5cdb; border-radius: 20px; padding: 4px 14px; font-size: 13px; font-weight: 600; }
        .card { background: #fff; border-radius: 12px; padding: 36px 40px; box-shadow: 0 4px 24px rgba(0,0,0,.07); }
        .alert { border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
        .form-group { margin-bottom: 22px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        label .required { color: #e11d48; margin-left: 2px; }
        input[type="text"], textarea {
            width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 15px; font-family: inherit; color: #1a1a2e; background: #fafafa;
            transition: border-color .2s, box-shadow .2s; resize: vertical;
        }
        input[type="text"]:focus, textarea:focus {
            outline: none; border-color: #4a5cdb; box-shadow: 0 0 0 3px rgba(74,92,219,.15); background: #fff;
        }
        input.is-invalid, textarea.is-invalid { border-color: #e11d48; box-shadow: 0 0 0 3px rgba(225,29,72,.1); }
        .field-error { color: #e11d48; font-size: 12px; margin-top: 5px; }
        .char-counter { font-size: 12px; color: #9ca3af; text-align: right; margin-top: 4px; }
        .char-counter.warn { color: #f59e0b; }
        .char-counter.over { color: #e11d48; }
        textarea { min-height: 180px; }
        .form-actions { display: flex; align-items: center; gap: 12px; padding-top: 8px; border-top: 1px solid #f3f4f6; margin-top: 8px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: background .2s; }
        .btn-primary { background: #4a5cdb; color: #fff; }
        .btn-primary:hover { background: #3a4bbf; }
        .btn-primary:disabled { background: #a5b4fc; cursor: not-allowed; }
        .btn-ghost { background: #f3f4f6; color: #374151; }
        .btn-ghost:hover { background: #e5e7eb; }
        .view-link { margin-left: auto; font-size: 13px; color: #6b7280; text-decoration: none; }
        .view-link:hover { color: #4a5cdb; text-decoration: underline; }
    </style>
</head>
<body>

<div class="topbar">
    <a href="<?= url('article') ?>">Статьи</a>
    <span class="sep">›</span>
    <a href="<?= url('article/' . $article['id']) ?>"><?= htmlspecialchars($article['title'], ENT_QUOTES) ?></a>
    <span class="sep">›</span>
    <span>Редактировать</span>
</div>

<div class="container">
    <div class="page-header">
        <h1>Редактировать статью</h1>
        <span class="article-id">ID: <?= (int) $article['id'] ?></span>
    </div>

    <div class="card">

        <?php if ($success): ?>
            <div class="alert alert-success">
                 <span>Статья успешно обновлена. <a href="<?= url('article/' . $article['id']) ?>">Посмотреть</a>.</span>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                 <span>Исправьте ошибки ниже перед сохранением.</span>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= url('article/' . (int)$article['id'] . '/edit') ?>" novalidate>

            <div class="form-group">
                <label for="title">Заголовок <span class="required">*</span></label>
                <input
                    type="text" id="title" name="title" maxlength="200"
                    value="<?= htmlspecialchars($article['title'], ENT_QUOTES) ?>"
                    class="<?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                    placeholder="Введите заголовок статьи"
                    oninput="updateCounter('title', 200)"
                >
                <div class="char-counter" id="title-counter"></div>
                <?php if (isset($errors['title'])): ?>
                    <div class="field-error">⚠ <?= htmlspecialchars($errors['title'], ENT_QUOTES) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="author">Автор <span class="required">*</span></label>
                <input
                    type="text" id="author" name="author"
                    value="<?= htmlspecialchars($article['author'], ENT_QUOTES) ?>"
                    class="<?= isset($errors['author']) ? 'is-invalid' : '' ?>"
                    placeholder="Имя автора"
                >
                <?php if (isset($errors['author'])): ?>
                    <div class="field-error">⚠ <?= htmlspecialchars($errors['author'], ENT_QUOTES) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="content">Содержимое <span class="required">*</span></label>
                <textarea
                    id="content" name="content"
                    class="<?= isset($errors['content']) ? 'is-invalid' : '' ?>"
                    placeholder="Текст статьи…"
                ><?= htmlspecialchars($article['content'], ENT_QUOTES) ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="field-error">⚠ <?= htmlspecialchars($errors['content'], ENT_QUOTES) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submit-btn">Сохранить изменения</button>
                <a href="<?= url('article/' . $article['id']) ?>" class="btn btn-ghost">Отмена</a>
                <a href="<?= url('article/' . $article['id']) ?>" class="view-link">Просмотр статьи</a>
            </div>

        </form>
    </div>
</div>

<script>
    function updateCounter(fieldId, maxLen) {
        const input = document.getElementById(fieldId);
        const counter = document.getElementById(fieldId + '-counter');
        const len = input.value.length;
        counter.textContent = len + ' / ' + maxLen;
        counter.className = 'char-counter' + (len > maxLen * 0.9 ? (len >= maxLen ? ' over' : ' warn') : '');
    }
    document.addEventListener('DOMContentLoaded', () => updateCounter('title', 200));
    document.querySelector('form').addEventListener('submit', () => {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.textContent = 'Сохранение…';
    });
</script>

</body>
</html>
