<?php

class ArticlesController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Список всех статей
    public function index(): void
    {
        $stmt = $this->pdo->query("SELECT * FROM articles ORDER BY id DESC");
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require 'views/index.php';
    }

    // Просмотр одной статьи с автором
    public function show(int $id): void
    {
        // 1. Запрос — получаем статью по ID
        $stmt = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$article) {
            echo "<p class='error'>Статья не найдена</p>";
            return;
        }

        // 2. Запрос — получаем автора из таблицы users
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$article['user_id']]);
        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Передаём в шаблон
        require 'views/show.php';
    }
}