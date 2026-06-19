<?php $pageTitle = 'Редактировать: ' . $article['title']; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="page-wrap" style="max-width: 780px;">

    <nav style="font-size:13px; color: var(--ink-dim); margin-bottom: 20px; display:flex; gap:8px; align-items:center;">
        <a href="<?= url('article') ?>" style="color:var(--ink-dim);text-decoration:none;">Статьи</a>
        <span>›</span>
        <a href="<?= url('article/' . $article['id']) ?>" style="color:var(--ink-dim);text-decoration:none;">
            <?= htmlspecialchars(mb_substr($article['title'], 0, 40), ENT_QUOTES) ?>…
        </a>
        <span>›</span>
        <span>Редактировать</span>
    </nav>

    <div class="page-header">
        <h1>Редактировать статью</h1>
        <p>ID: <?= (int)$article['id'] ?></p>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Статья успешно сохранена. <a href="<?= url('article/' . $article['id']) ?>">Посмотреть</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">Пожалуйста, исправьте ошибки ниже.</div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?= url('article/' . (int)$article['id'] . '/edit') ?>" novalidate>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="author">Автор <span class="req">*</span></label>
                    <input type="text" id="author" name="author"
                           class="form-control <?= isset($errors['author']) ? 'is-invalid' : '' ?>"
                           value="<?= htmlspecialchars($article['author'], ENT_QUOTES) ?>"
                           placeholder="Имя автора">
                    <?php if (isset($errors['author'])): ?>
                        <div class="field-error"><?= htmlspecialchars($errors['author'], ENT_QUOTES) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label class="form-label" for="category">Категория</label>
                    <select id="category" name="category" class="form-control">
                        <option value="">— выберите —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat, ENT_QUOTES) ?>"
                                <?= $article['category'] === $cat ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat, ENT_QUOTES) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="title">Заголовок <span class="req">*</span></label>
                <input type="text" id="title" name="title" maxlength="200"
                       class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                       value="<?= htmlspecialchars($article['title'], ENT_QUOTES) ?>"
                       oninput="updateCounter('title', 200)">
                <div class="char-counter" id="title-counter">0 / 200</div>
                <?php if (isset($errors['title'])): ?>
                    <div class="field-error"><?= htmlspecialchars($errors['title'], ENT_QUOTES) ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="content">Текст статьи <span class="req">*</span></label>
                <textarea id="content" name="content"
                          class="form-control <?= isset($errors['content']) ? 'is-invalid' : '' ?>"
                          oninput="updateReadingTime(this.value)"><?= htmlspecialchars($article['content'], ENT_QUOTES) ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="field-error"><?= htmlspecialchars($errors['content'], ENT_QUOTES) ?></div>
                <?php endif; ?>
                <div class="reading-preview" id="reading-preview">
                    ⏱ Примерное время чтения: <strong id="reading-time">1</strong> мин &nbsp;·&nbsp;
                    <span id="word-count">0</span> слов
                </div>
            </div>

            <hr class="section-rule">
            <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary" id="submit-btn">Сохранить изменения</button>
                <a href="<?= url('article/' . $article['id']) ?>" class="btn btn-outline">Отмена</a>
                <form method="POST" action="<?= url('article/' . $article['id'] . '/delete') ?>"
                      style="margin-left:auto;"
                      onsubmit="return confirm('Удалить статью? Это действие нельзя отменить.')">
                    <button type="submit" class="btn btn-danger btn-sm">Удалить статью</button>
                </form>
            </div>
        </form>
    </div>
</main>

<script>
function updateCounter(fieldId, maxLen) {
    const input   = document.getElementById(fieldId);
    const counter = document.getElementById(fieldId + '-counter');
    const len     = input.value.length;
    counter.textContent = len + ' / ' + maxLen;
    counter.className   = 'char-counter' + (len >= maxLen ? ' over' : len > maxLen * .85 ? ' warn' : '');
}
function updateReadingTime(text) {
    const words = text.trim().split(/\s+/).filter(Boolean).length;
    const mins  = Math.max(1, Math.ceil(words / 200));
    document.getElementById('reading-time').textContent = mins;
    document.getElementById('word-count').textContent   = words;
}
document.addEventListener('DOMContentLoaded', () => {
    updateCounter('title', 200);
    updateReadingTime(document.getElementById('content').value);
});
document.querySelector('form').addEventListener('submit', () => {
    const btn = document.getElementById('submit-btn');
    btn.disabled    = true;
    btn.textContent = 'Сохранение…';
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
