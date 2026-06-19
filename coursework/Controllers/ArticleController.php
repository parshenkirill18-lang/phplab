<?php

namespace MyProject\Controllers;

use MyProject\Models\Article;

class ArticleController
{
    private array $categories = ['Технологии', 'Наука', 'Культура', 'Спорт', 'Разное'];

    public function index(?string $id = null): void
    {
        $articles   = Article::all();
        $stats      = Article::countByCategory();
        $totalCount = Article::totalCount();
        require __DIR__ . '/../views/article/index.php';
    }

    public function view(?string $id = null): void
    {
        $article = Article::findById((int) $id);
        if ($article === null) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }
        $readingTime = Article::readingTime($article['content']);
        require __DIR__ . '/../views/article/view.php';
    }

    public function create(?string $id = null): void
    {
        $errors     = [];
        $success    = false;
        $categories = $this->categories;
        $article    = ['title' => '', 'content' => '', 'author' => '', 'category' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ['title' => $title, 'content' => $content, 'author' => $author, 'category' => $category]
                = $this->extractFields();

            $errors = $this->validate($title, $content, $author);

            if (empty($errors)) {
                $newId = Article::create(compact('title', 'content', 'author', 'category'));
                header('Location: ' . url('article/' . $newId));
                exit;
            }

            $article = compact('title', 'content', 'author', 'category');
        }

        require __DIR__ . '/../views/article/create.php';
    }

    public function edit(?string $id = null): void
    {
        $article = Article::findById((int) $id);
        if ($article === null) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $errors     = [];
        $success    = false;
        $categories = $this->categories;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ['title' => $title, 'content' => $content, 'author' => $author, 'category' => $category]
                = $this->extractFields();

            $errors = $this->validate($title, $content, $author);

            if (empty($errors)) {
                Article::update((int) $id, compact('title', 'content', 'author', 'category'));
                $article = Article::findById((int) $id);
                $success = true;
            } else {
                $article = array_merge($article, compact('title', 'content', 'author', 'category'));
            }
        }

        require __DIR__ . '/../views/article/edit.php';
    }

    public function delete(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Article::delete((int) $id);
        }
        header('Location: ' . url('article'));
        exit;
    }

    // ── helpers ────────────────────────────────────────────────
    private function extractFields(): array
    {
        return [
            'title'    => trim($_POST['title']    ?? ''),
            'content'  => trim($_POST['content']  ?? ''),
            'author'   => trim($_POST['author']   ?? ''),
            'category' => trim($_POST['category'] ?? ''),
        ];
    }

    private function validate(string $title, string $content, string $author): array
    {
        $errors = [];
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
        return $errors;
    }
}
