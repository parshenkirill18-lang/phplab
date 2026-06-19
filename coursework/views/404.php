<?php $pageTitle = '404 — Страница не найдена'; ?>
<?php require __DIR__ . '/layout/header.php'; ?>
<main class="page-wrap" style="text-align:center; padding-top: 80px;">
    <h1 style="font-family:'Playfair Display',serif; font-size:80px; color:var(--rule);">404</h1>
    <p style="font-size:18px; margin: 16px 0 32px;">Страница не найдена</p>
    <a href="<?= url('article') ?>" class="btn btn-primary">На главную</a>
</main>
<?php require __DIR__ . '/layout/footer.php'; ?>
