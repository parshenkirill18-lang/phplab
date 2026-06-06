<?php

namespace MyProject\Controllers;

use MyProject\Models\Article;

class ArticleController
{
    public function index(?string $id = null): void
    {
        $articles = Article::all();
        require __DIR__ . '/../views/article/index.php';
    }

    public function view(?string $id = null): void
    {
        $article = Article::findById((int) $id);

        if ($article === null) {
            http_response_code(404);
            echo '<h1>Статья не найдена</h1>';
            return;
        }

        require __DIR__ . '/../views/article/view.php';
    }

    public function edit(?string $id = null): void
    {
        $article = Article::findById((int) $id);

        if ($article === null) {
            http_response_code(404);
            echo '<h1>Статья не найдена</h1>';
            return;
        }

        $errors  = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title   = trim($_POST['title']   ?? '');
            $content = trim($_POST['content'] ?? '');
            $author  = trim($_POST['author']  ?? '');

            if ($title === '') {
                $errors['title'] = 'Заголовок не может быть пустым.';
            } elseif (mb_strlen($title) > 200) {
                $errors['title'] = 'Заголовок не должен превышать 200 символов.';
            }

            if ($content === '') {
                $errors['content'] = 'Содержимое не может быть пустым.';
            }

            if ($author === '') {
                $errors['author'] = 'Укажите автора.';
            }

            if (empty($errors)) {
                Article::update((int) $id, compact('title', 'content', 'author'));
                $article = Article::findById((int) $id);
                $success = true;
            } else {
                $article['title']   = $title;
                $article['content'] = $content;
                $article['author']  = $author;
            }
        }

        require __DIR__ . '/../views/article/edit.php';
    }
}
