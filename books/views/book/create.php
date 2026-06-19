<?php $pageTitle = 'Добавить книгу'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="bc"><a href="<?= url('book') ?>">Каталог</a> <span>›</span> Добавить книгу</div>
<div class="page-title">Добавить книгу</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">Исправьте ошибки ниже.</div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?= url('book/create') ?>">

        <div class="form-row-3">
            <div class="form-group">
                <label>Автор <span class="req">*</span></label>
                <input type="text" name="author" value="<?= htmlspecialchars($data['author']) ?>" placeholder="Фамилия И.О.">
                <?php if (isset($errors['author'])): ?><div class="field-error"><?= htmlspecialchars($errors['author']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Год издания</label>
                <input type="number" name="year" value="<?= htmlspecialchars($data['year']) ?>" placeholder="2024" max="2099">
                <?php if (isset($errors['year'])): ?><div class="field-error"><?= htmlspecialchars($errors['year']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Жанр</label>
                <select name="genre">
                    <option value="">— выберите —</option>
                    <?php foreach ($genres as $g): ?>
                        <option value="<?= $g ?>" <?= $data['genre']===$g?'selected':'' ?>><?= $g ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Название книги <span class="req">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>"
                       placeholder="Введите название" maxlength="200"
                       oninput="cnt(this,200,'c1')">
                <div class="char-counter" id="c1">0 / 200</div>
                <?php if (isset($errors['title'])): ?><div class="field-error"><?= htmlspecialchars($errors['title']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Цена, ₽</label>
                <input type="number" name="price" value="<?= htmlspecialchars($data['price']) ?>" placeholder="490" min="0" step="1">
                <?php if (isset($errors['price'])): ?><div class="field-error"><?= htmlspecialchars($errors['price']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label>Описание / аннотация</label>
            <textarea name="description" placeholder="Краткое описание книги..."><?= htmlspecialchars($data['description']) ?></textarea>
        </div>

        <div class="hr"></div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="<?= url('book') ?>" class="btn" style="margin-left:8px;">Отмена</a>
    </form>
</div>

<script>
function cnt(el, max, id) {
    var n = el.value.length, c = document.getElementById(id);
    c.textContent = n + ' / ' + max;
    c.className = 'char-counter' + (n >= max ? ' over' : n > max*.85 ? ' warn' : '');
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
