<?php $pageTitle = '404'; $cartCount = 0; ?>
<?php require __DIR__ . '/layout/header.php'; ?>
<div style="text-align:center;padding:60px 0;">
    <div style="font-size:64px;font-weight:bold;color:#d8c8a8;">404</div>
    <p style="font-family:Arial,sans-serif;color:#8b6840;margin:14px 0 24px;">Страница не найдена</p>
    <a href="<?= url('book') ?>" class="btn btn-primary">← В каталог</a>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
