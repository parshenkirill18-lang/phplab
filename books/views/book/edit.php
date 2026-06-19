<?php $pageTitle = 'Редактировать книгу'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="bc">
    <a href="<?= url('book') ?>">Каталог</a> <span>›</span>
    <a href="<?= url('book/' . $book['id']) ?>"><?= htmlspecialchars(mb_substr($book['title'],0,40)) ?>...</a>
    <span>›</span> Редактировать
</div>
<div class="page-title">Редактировать книгу <span style="font-size:14px;font-weight:normal;color:#777">ID: <?= $book['id'] ?></span></div>

<?php if ($success): ?>
    <div class="alert alert-success">Сохранено! <a href="<?= url('book/'.$book['id']) ?>">Посмотреть</a></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert alert-error">Исправьте ошибки ниже.</div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="<?= url('book/' . $book['id'] . '/edit') ?>">

        <div class="form-row-3">
            <div class="form-group">
                <label>Автор <span class="req">*</span></label>
                <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>">
                <?php if (isset($errors['author'])): ?><div class="field-error"><?= htmlspecialchars($errors['author']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Год издания</label>
                <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>" max="2099">
                <?php if (isset($errors['year'])): ?><div class="field-error"><?= htmlspecialchars($errors['year']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Жанр</label>
                <select name="genre">
                    <option value="">— выберите —</option>
                    <?php foreach ($genres as $g): ?>
                        <option value="<?= $g ?>" <?= $book['genre']===$g?'selected':'' ?>><?= $g ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Название книги <span class="req">*</span></label>
                <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>"
                       maxlength="200" oninput="cnt(this,200,'c1')">
                <div class="char-counter" id="c1"><?= mb_strlen($book['title']) ?> / 200</div>
                <?php if (isset($errors['title'])): ?><div class="field-error"><?= htmlspecialchars($errors['title']) ?></div><?php endif; ?>
            </div>
            <div class="form-group">
                <label>Цена, ₽</label>
                <input type="number" name="price" value="<?= htmlspecialchars($book['price']) ?>" min="0" step="1">
                <?php if (isset($errors['price'])): ?><div class="field-error"><?= htmlspecialchars($errors['price']) ?></div><?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label>Описание / аннотация</label>
            <textarea name="description"><?= htmlspecialchars($book['description']) ?></textarea>
        </div>

        <div class="hr"></div>
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="<?= url('book/'.$book['id']) ?>" class="btn">Отмена</a>
            <form method="POST" action="<?= url('book/'.$book['id'].'/delete') ?>"
                  style="margin-left:auto;" onsubmit="return confirm('Удалить эту книгу?')">
                <button class="btn btn-danger">Удалить книгу</button>
            </form>
        </div>
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
