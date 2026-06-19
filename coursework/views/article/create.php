<?php $pageTitle = 'Новая статья'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="page-wrap" style="max-width: 780px;">

    <div class="page-header">
        <h1>Новая статья</h1>
        <p>Заполните все обязательные поля и опубликуйте материал</p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">Пожалуйста, исправьте ошибки ниже.</div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?= url('article/create') ?>" novalidate>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="author">Автор <span class="req">*</span></label>
                    <input type="text" id="author" name="author" class="form-control <?= isset($errors['author']) ? 'is-invalid' : '' ?>"
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
                                <?= ($article['category'] ?? '') === $cat ? 'selected' : '' ?>>
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
                       placeholder="Введите заголовок статьи"
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
                          placeholder="Напишите текст статьи…"
                          oninput="updateReadingTime(this.value)"><?= htmlspecialchars($article['content'], ENT_QUOTES) ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="field-error"><?= htmlspecialchars($errors['content'], ENT_QUOTES) ?></div>
                <?php endif; ?>
                <div class="reading-preview" id="reading-preview" style="display:none">
                    ⏱ Примерное время чтения: <strong id="reading-time">1</strong> мин &nbsp;·&nbsp;
                    <span id="word-count">0</span> слов
                </div>
            </div>

            <hr class="section-rule">
            <div style="display:flex; gap:12px; align-items:center;">
                <button type="submit" class="btn btn-primary" id="submit-btn">Опубликовать</button>
                <a href="<?= url('article') ?>" class="btn btn-outline">Отмена</a>
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
    const preview = document.getElementById('reading-preview');
    preview.style.display = words > 0 ? 'block' : 'none';
    document.getElementById('reading-time').textContent = mins;
    document.getElementById('word-count').textContent   = words;
}

document.addEventListener('DOMContentLoaded', () => {
    updateCounter('title', 200);
    const ta = document.getElementById('content');
    if (ta.value) updateReadingTime(ta.value);
});

document.querySelector('form').addEventListener('submit', () => {
    const btn = document.getElementById('submit-btn');
    btn.disabled     = true;
    btn.textContent  = 'Публикация…';
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
