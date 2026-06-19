<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Каталог книг') ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background: #fff; color: #111; font-size: 14px; min-height: 100vh; }

        
        .header { background: #000; border-bottom: 1px solid #000; }
        .header-inner { max-width: 980px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; justify-content: space-between; height: 54px; }
        .logo { font-size: 17px; font-weight: bold; color: #fff; text-decoration: none; letter-spacing: .3px; }
        .nav { display: flex; gap: 4px; align-items: center; }
        .nav a { color: #bbb; text-decoration: none; font-size: 13px; padding: 7px 13px; }
        .nav a:hover { color: #fff; }
        .nav .btn-add { border: 1px solid #fff; color: #fff; margin-left: 6px; }
        .nav .btn-add:hover { background: #fff; color: #000; }
        .nav .cart-link { position: relative; }
        .cart-badge { background: #fff; color: #000; font-size: 10px; font-weight: bold; border-radius: 50%; width: 16px; height: 16px; display: inline-flex; align-items: center; justify-content: center; margin-left: 4px; }

        
        .wrap { max-width: 980px; margin: 28px auto; padding: 0 20px; }

        
        .genre-tabs { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
        .genre-tab { font-size: 12px; padding: 4px 12px; border: 1px solid #ccc; background: #fff; color: #333; text-decoration: none; }
        .genre-tab:hover { border-color: #000; }
        .genre-tab.active { background: #000; color: #fff; border-color: #000; }

        
        .filter-box { background: #fafafa; border: 1px solid #ddd; padding: 14px 16px; margin-bottom: 16px; }
        .filter-row { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
        .fg { display: flex; flex-direction: column; gap: 4px; }
        .fg label { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: .04em; }
        .fg input { font-size: 13px; padding: 6px 9px; border: 1px solid #ccc; background: #fff; color: #111; width: 170px; }
        .fg input:focus { outline: 1px solid #000; }
        .sort-group { display: flex; flex-direction: column; gap: 4px; }
        .sort-group label { font-size: 11px; color: #666; text-transform: uppercase; letter-spacing: .04em; }
        .sort-btns { display: flex; gap: 4px; flex-wrap: wrap; }
        .sort-btn { font-size: 12px; padding: 5px 10px; border: 1px solid #ccc; background: #fff; color: #333; cursor: pointer; }
        .sort-btn:hover { border-color: #000; }
        .sort-btn.active { background: #000; color: #fff; border-color: #000; }

        
        .book-card { background: #fff; border: 1px solid #ddd; padding: 14px 18px; margin-bottom: 8px; display: flex; align-items: center; gap: 14px; }
        .book-card:hover { border-color: #000; }
        .book-info { flex: 1; }
        .book-title { font-size: 15px; font-weight: bold; margin-bottom: 4px; }
        .book-title a { color: #111; text-decoration: none; }
        .book-title a:hover { text-decoration: underline; }
        .book-meta { font-size: 12px; color: #777; display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
        .genre-badge { border: 1px solid #ccc; font-size: 11px; padding: 1px 8px; }
        .book-price { font-weight: bold; color: #000; }
        .book-actions { display: flex; gap: 6px; flex-shrink: 0; flex-wrap: wrap; }

        
        .btn { display: inline-block; font-size: 12px; padding: 5px 12px; border: 1px solid #ccc; background: #fff; color: #222; text-decoration: none; cursor: pointer; font-family: inherit; }
        .btn:hover { border-color: #000; }
        .btn-primary { background: #000; color: #fff; border-color: #000; }
        .btn-primary:hover { background: #333; }
        .btn-danger { color: #900; border-color: #d8b0b0; }
        .btn-danger:hover { background: #900; color: #fff; border-color: #900; }

        
        .book-page { background: #fff; border: 1px solid #ddd; }
        .book-page-header { background: #000; padding: 22px 26px; }
        .book-page-genre { font-size: 11px; color: #aaa; text-transform: uppercase; letter-spacing: .1em; margin-bottom: 8px; }
        .book-page-title { font-size: 24px; color: #fff; line-height: 1.3; margin-bottom: 10px; }
        .book-page-meta { font-size: 13px; color: #ccc; display: flex; gap: 18px; flex-wrap: wrap; }
        .book-page-body { padding: 22px 26px; }
        .book-desc { font-size: 15px; line-height: 1.75; color: #222; }
        .book-desc p { margin-bottom: .9em; }
        .book-price-tag { font-size: 22px; font-weight: bold; margin: 14px 0; }

        
        .form-card { background: #fff; border: 1px solid #ddd; padding: 24px 28px; max-width: 660px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 12px; color: #555; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 5px; }
        .req { color: #900; }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%; padding: 8px 10px; border: 1px solid #ccc; font-family: inherit; font-size: 14px; color: #111; background: #fff;
        }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: 1px solid #000; }
        .form-group textarea { height: 150px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-row-3 { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 14px; }
        .field-error { font-size: 12px; color: #900; margin-top: 3px; }
        .char-counter { font-size: 11px; color: #999; text-align: right; margin-top: 2px; }
        .char-counter.warn { color: #c07020; }
        .char-counter.over  { color: #900; }

        
        .alert { padding: 10px 14px; margin-bottom: 14px; font-size: 13px; border: 1px solid; }
        .alert-success { background: #f0f8f0; color: #1a5a1a; border-color: #b0d0b0; }
        .alert-error   { background: #fbeaea; color: #7a1a1a; border-color: #e0b0b0; }

        
        .bc { font-size: 12px; color: #777; margin-bottom: 16px; }
        .bc a { color: #000; text-decoration: none; }
        .bc a:hover { text-decoration: underline; }
        .bc span { margin: 0 6px; }

        .page-title { font-size: 21px; margin-bottom: 16px; }
        .hr { border: none; border-top: 1px solid #e0e0e0; margin: 16px 0; }
        .count-label { font-size: 13px; color: #777; margin-bottom: 14px; }

        
        .cart-table { width: 100%; border-collapse: collapse; background: #fff; }
        .cart-table th { background: #000; color: #fff; font-size: 13px; padding: 9px 14px; text-align: left; }
        .cart-table td { border-bottom: 1px solid #e5e5e5; padding: 10px 14px; font-size: 14px; }
        .cart-table tr:last-child td { border-bottom: none; }
        .qty-input { width: 60px; padding: 5px 7px; border: 1px solid #ccc; text-align: center; }
        .cart-total { background: #fafafa; border: 1px solid #ddd; padding: 16px 20px; margin-top: 14px; display: flex; justify-content: space-between; align-items: center; }
        .cart-total .sum { font-size: 22px; font-weight: bold; }
        .empty-cart { text-align: center; padding: 50px 20px; color: #888; }

        
        .footer { background: #000; color: #888; text-align: center; padding: 14px; font-size: 12px; margin-top: 40px; }

        @media(max-width:680px) { .form-row, .form-row-3 { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<header class="header">
    <div class="header-inner">
        <a href="<?= url('') ?>" class="logo">Паршин К 251-3210</a>
        <nav class="nav">
            <a href="<?= url('book') ?>">Каталог</a>
            <a href="<?= url('calculator.php') ?>">Калькулятор</a>
            <a href="<?= url('cart') ?>" class="cart-link">Корзина<?php if (!empty($cartCount)): ?><span class="cart-badge"><?= $cartCount ?></span><?php endif; ?></a>
            <a href="<?= url('book/create') ?>" class="btn-add">+ Добавить книгу</a>
        </nav>
    </div>
</header>

<div class="wrap">
