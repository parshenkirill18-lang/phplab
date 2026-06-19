<?php $pageTitle = 'Корзина'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="bc"><a href="<?= url('book') ?>">Каталог</a> <span>›</span> Корзина</div>
<div class="page-title">Корзина</div>

<?php if (empty($items)): ?>
    <div class="empty-cart">
        <p>Корзина пуста.</p>
        <p style="margin-top:10px;"><a href="<?= url('book') ?>" class="btn btn-primary">Перейти в каталог</a></p>
    </div>
<?php else: ?>

<table class="cart-table">
    <thead>
        <tr>
            <th>Книга</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Сумма</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
            <td>
                <a href="<?= url('book/' . $item['id']) ?>" style="color:#111;text-decoration:none;font-weight:bold;">
                    <?= htmlspecialchars($item['title']) ?>
                </a>
                <div style="font-size:12px;color:#888;"><?= htmlspecialchars($item['author']) ?></div>
            </td>
            <td><?= number_format((float)$item['price'], 0, '.', ' ') ?> ₽</td>
            <td>
                <form method="POST" action="<?= url('cart/' . $item['cart_id'] . '/update') ?>" style="display:flex;gap:6px;align-items:center;">
                    <input type="number" name="qty" value="<?= (int)$item['qty'] ?>" min="1" class="qty-input"
                           onchange="this.form.submit()">
                </form>
            </td>
            <td style="font-weight:bold;"><?= number_format((float)$item['price'] * (int)$item['qty'], 0, '.', ' ') ?> ₽</td>
            <td>
                <form method="POST" action="<?= url('cart/' . $item['cart_id'] . '/remove') ?>"
                      onsubmit="return confirm('Удалить книгу из корзины?')">
                    <button type="submit" class="btn btn-danger" style="padding:4px 10px;">Убрать</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="cart-total">
    <div>Итого к оплате:</div>
    <div class="sum"><?= number_format($total, 0, '.', ' ') ?> ₽</div>
</div>

<div style="margin-top:14px; display:flex; gap:8px;">
    <a href="<?= url('book') ?>" class="btn">← Продолжить покупки</a>
    <form method="POST" action="<?= url('cart/clear') ?>" onsubmit="return confirm('Очистить корзину полностью?')">
        <button type="submit" class="btn btn-danger">Очистить корзину</button>
    </form>
</div>

<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
