<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Журнал', ENT_QUOTES) ?> — Журнал</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink:     #0f0f0f;
            --ink-mid: #4a4a4a;
            --ink-dim: #8a8a8a;
            --paper:   #faf9f6;
            --card:    #ffffff;
            --rule:    #e2e0d9;
            --accent:  #c0392b;
            --accent2: #2980b9;
            --radius:  6px;
            --shadow:  0 2px 16px rgba(0,0,0,.07);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--paper); color: var(--ink); min-height: 100vh; }

        /* ── Header ── */
        .site-header {
            border-bottom: 3px double var(--ink);
            padding: 0 40px;
            background: var(--paper);
        }
        .header-top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 0 14px;
        }
        .site-logo {
            font-family: 'Playfair Display', serif;
            font-size: 32px; font-weight: 900;
            color: var(--ink); text-decoration: none;
            letter-spacing: -1px;
        }
        .site-logo span { color: var(--accent); }
        .header-meta { font-size: 12px; color: var(--ink-dim); text-align: right; line-height: 1.6; }
        .site-nav {
            display: flex; gap: 28px; padding: 10px 0;
            border-top: 1px solid var(--rule);
        }
        .site-nav a {
            font-size: 13px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .08em; color: var(--ink-mid);
            text-decoration: none; padding-bottom: 2px;
            border-bottom: 2px solid transparent;
            transition: color .2s, border-color .2s;
        }
        .site-nav a:hover, .site-nav a.active { color: var(--accent); border-bottom-color: var(--accent); }
        .nav-cta {
            margin-left: auto;
            background: var(--ink) !important; color: var(--paper) !important;
            padding: 6px 16px !important; border-radius: var(--radius);
            border-bottom: none !important;
        }
        .nav-cta:hover { background: var(--accent) !important; }

        /* ── Layout ── */
        .page-wrap { max-width: 1120px; margin: 0 auto; padding: 48px 40px; }
        .two-col { display: grid; grid-template-columns: 1fr 300px; gap: 48px; align-items: start; }

        /* ── Cards ── */
        .article-card {
            background: var(--card); border: 1px solid var(--rule);
            border-radius: var(--radius); padding: 24px 28px;
            margin-bottom: 16px; transition: box-shadow .2s, transform .15s;
        }
        .article-card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
        .card-eyebrow {
            display: flex; align-items: center; gap: 10px;
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: .1em; color: var(--ink-dim); margin-bottom: 10px;
        }
        .cat-tag {
            background: var(--ink); color: var(--paper);
            padding: 2px 8px; border-radius: 3px; font-size: 10px;
            font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
        }
        .cat-tag.tech   { background: #1a3a5c; }
        .cat-tag.sci    { background: #1a4a2a; }
        .cat-tag.cult   { background: #4a1a3a; }
        .cat-tag.sport  { background: #4a2a0a; }
        .cat-tag.misc   { background: #3a3a3a; }
        .article-card h2 { font-family: 'Playfair Display', serif; font-size: 20px; line-height: 1.3; margin-bottom: 8px; }
        .article-card h2 a { color: var(--ink); text-decoration: none; }
        .article-card h2 a:hover { color: var(--accent); }
        .card-excerpt { font-size: 14px; color: var(--ink-mid); line-height: 1.7; margin-bottom: 16px; }
        .card-footer { display: flex; align-items: center; justify-content: space-between; }
        .card-meta { font-size: 12px; color: var(--ink-dim); }
        .card-actions { display: flex; gap: 8px; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 16px; border-radius: var(--radius);
            font-size: 13px; font-weight: 600; text-decoration: none;
            border: 1px solid transparent; cursor: pointer;
            transition: all .2s; font-family: inherit;
        }
        .btn-primary   { background: var(--ink); color: var(--paper); border-color: var(--ink); }
        .btn-primary:hover { background: var(--accent); border-color: var(--accent); }
        .btn-outline   { background: transparent; color: var(--ink); border-color: var(--rule); }
        .btn-outline:hover { border-color: var(--ink); }
        .btn-danger    { background: transparent; color: var(--accent); border-color: #f5c6c3; }
        .btn-danger:hover { background: var(--accent); color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── Sidebar ── */
        .sidebar-widget {
            background: var(--card); border: 1px solid var(--rule);
            border-radius: var(--radius); padding: 20px 22px; margin-bottom: 20px;
        }
        .widget-title {
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .12em; color: var(--ink-dim);
            margin-bottom: 14px; padding-bottom: 10px;
            border-bottom: 1px solid var(--rule);
        }
        .stat-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 14px; border-bottom: 1px solid var(--rule); }
        .stat-row:last-child { border-bottom: none; }
        .stat-num { font-weight: 700; font-size: 18px; color: var(--ink); }
        .cat-bar { margin-bottom: 10px; }
        .cat-bar-label { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px; }
        .cat-bar-track { background: var(--rule); border-radius: 2px; height: 6px; overflow: hidden; }
        .cat-bar-fill { background: var(--ink); height: 100%; border-radius: 2px; transition: width .6s ease; }

        /* ── Forms ── */
        .form-card {
            background: var(--card); border: 1px solid var(--rule);
            border-radius: var(--radius); padding: 36px 40px;
        }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        .form-label .req { color: var(--accent); margin-left: 2px; }
        .form-control {
            width: 100%; padding: 10px 14px;
            border: 1px solid var(--rule); border-radius: var(--radius);
            font-family: inherit; font-size: 15px; color: var(--ink);
            background: #fefefe;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus { outline: none; border-color: var(--ink); box-shadow: 0 0 0 3px rgba(0,0,0,.06); }
        .form-control.is-invalid { border-color: var(--accent); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        textarea.form-control { min-height: 200px; resize: vertical; }
        .field-error { font-size: 12px; color: var(--accent); margin-top: 5px; }
        .char-counter { font-size: 11px; color: var(--ink-dim); text-align: right; margin-top: 4px; }
        .char-counter.warn { color: #e67e22; }
        .char-counter.over { color: var(--accent); }
        .reading-preview {
            background: #f0f8f0; border: 1px solid #c3e6cb;
            border-radius: var(--radius); padding: 10px 14px;
            font-size: 13px; color: #155724; margin-top: 8px;
        }

        /* ── Alerts ── */
        .alert { padding: 12px 16px; border-radius: var(--radius); margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* ── Article view ── */
        .article-hero { border-bottom: 2px solid var(--ink); padding-bottom: 28px; margin-bottom: 32px; }
        .article-title { font-family: 'Playfair Display', serif; font-size: 42px; line-height: 1.2; margin: 16px 0; }
        .article-byline { display: flex; gap: 20px; font-size: 13px; color: var(--ink-dim); flex-wrap: wrap; }
        .article-byline span { display: flex; align-items: center; gap: 5px; }
        .article-body { font-size: 17px; line-height: 1.85; color: #2a2a2a; }
        .article-body p { margin-bottom: 1.2em; }

        /* ── Page header ── */
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: 32px; }
        .page-header p { color: var(--ink-dim); font-size: 14px; margin-top: 6px; }
        .section-rule { border: none; border-top: 1px solid var(--rule); margin: 24px 0; }

        /* ── Footer ── */
        .site-footer {
            border-top: 3px double var(--ink); margin-top: 64px;
            padding: 28px 40px; text-align: center;
            font-size: 12px; color: var(--ink-dim); background: var(--paper);
        }

        @media (max-width: 768px) {
            .site-header, .page-wrap, .site-footer { padding-left: 20px; padding-right: 20px; }
            .two-col { grid-template-columns: 1fr; }
            .article-title { font-size: 28px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="header-top">
        <a href="<?= url('') ?>" class="site-logo">Журнал<span>.</span></a>
        <div class="header-meta">
            Курсовой проект<br>
            PHP MVC · MySQL
        </div>
    </div>
    <nav class="site-nav">
        <a href="<?= url('article') ?>" class="<?= ($currentPage ?? '') === 'index' ? 'active' : '' ?>">Все статьи</a>
        <a href="<?= url('article/create') ?>" class="nav-cta">+ Новая статья</a>
    </nav>
</header>
