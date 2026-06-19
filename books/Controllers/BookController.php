<?php

namespace MyProject\Controllers;

use MyProject\Models\Book;
use MyProject\Models\Cart;

class BookController
{
    private array $genres = [
        'Роман', 'Фантастика', 'Детектив', 'Приключения',
        'Биография', 'История', 'Наука', 'Поэзия', 'Разное'
    ];

    public function index(?string $id = null): void
    {
        $books = Book::all();

        $filterGenre  = $_GET['genre']  ?? '';
        $filterTitle  = trim($_GET['title']  ?? '');
        $filterAuthor = trim($_GET['author'] ?? '');
        $sortBy  = in_array($_GET['sort'] ?? '', ['title','author','year','price','added_at']) ? $_GET['sort'] : 'added_at';
        $sortDir = ($_GET['dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

        if ($filterGenre)  $books = array_filter($books, fn($b) => $b['genre'] === $filterGenre);
        if ($filterTitle)  $books = array_filter($books, fn($b) => mb_stripos($b['title'],  $filterTitle)  !== false);
        if ($filterAuthor) $books = array_filter($books, fn($b) => mb_stripos($b['author'], $filterAuthor) !== false);

        usort($books, function ($a, $b) use ($sortBy, $sortDir) {
            $va = $sortBy === 'price' ? (float)$a[$sortBy] : (string)$a[$sortBy];
            $vb = $sortBy === 'price' ? (float)$b[$sortBy] : (string)$b[$sortBy];
            $cmp = $va <=> $vb;
            return $sortDir === 'asc' ? $cmp : -$cmp;
        });

        $allBooks   = Book::all();
        $genres     = array_unique(array_column($allBooks, 'genre'));
        sort($genres);
        $totalCount = Book::countAll();
        $cartCount  = Cart::totalCount();

        require __DIR__ . '/../views/book/index.php';
    }

    public function view(?string $id = null): void
    {
        $book = Book::findById((int) $id);
        if ($book === null) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }
        $cartCount = Cart::totalCount();
        require __DIR__ . '/../views/book/view.php';
    }

    public function create(?string $id = null): void
    {
        $errors = [];
        $genres = $this->genres;
        $data   = ['title' => '', 'author' => '', 'genre' => '', 'year' => '', 'price' => '', 'description' => ''];
        $cartCount = Cart::totalCount();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data   = $this->extractPost();
            $errors = $this->validate($data);
            if (empty($errors)) {
                $newId = Book::create($data);
                header('Location: ' . url('book/' . $newId));
                exit;
            }
        }

        require __DIR__ . '/../views/book/create.php';
    }

    public function edit(?string $id = null): void
    {
        $book = Book::findById((int) $id);
        if ($book === null) {
            http_response_code(404);
            require __DIR__ . '/../views/404.php';
            return;
        }

        $errors  = [];
        $success = false;
        $genres  = $this->genres;
        $cartCount = Cart::totalCount();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data   = $this->extractPost();
            $errors = $this->validate($data);
            if (empty($errors)) {
                Book::update((int) $id, $data);
                $book    = Book::findById((int) $id);
                $success = true;
            } else {
                $book = array_merge($book, $data);
            }
        }

        require __DIR__ . '/../views/book/edit.php';
    }

    public function delete(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Book::delete((int) $id);
        }
        header('Location: ' . url('book'));
        exit;
    }

    // ── Корзина ──────────────────────────────────────────────

    public function cartAdd(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Cart::add((int) $id);
        }
        $back = $_POST['back'] ?? url('book');
        header('Location: ' . $back);
        exit;
    }

    public function cartView(?string $id = null): void
    {
        $items     = Cart::all();
        $total     = Cart::totalPrice();
        $cartCount = Cart::totalCount();
        require __DIR__ . '/../views/cart/index.php';
    }

    public function cartUpdate(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $qty = (int) ($_POST['qty'] ?? 1);
            Cart::updateQty((int) $id, $qty);
        }
        header('Location: ' . url('cart'));
        exit;
    }

    public function cartRemove(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Cart::remove((int) $id);
        }
        header('Location: ' . url('cart'));
        exit;
    }

    public function cartClear(?string $id = null): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Cart::clear();
        }
        header('Location: ' . url('cart'));
        exit;
    }

    // ── Вспомогательные методы ──────────────────────────────

    private function extractPost(): array
    {
        return [
            'title'       => trim($_POST['title']       ?? ''),
            'author'      => trim($_POST['author']      ?? ''),
            'genre'       => trim($_POST['genre']       ?? ''),
            'year'        => trim($_POST['year']        ?? ''),
            'price'       => trim($_POST['price']       ?? ''),
            'description' => trim($_POST['description'] ?? ''),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['title'] === '')  $errors['title']  = 'Введите название книги.';
        if ($data['author'] === '') $errors['author'] = 'Введите автора.';
        if ($data['year'] !== '' && (!is_numeric($data['year']) || $data['year'] > 2099))
            $errors['year'] = 'Введите корректный год.';
        if ($data['price'] !== '' && (!is_numeric($data['price']) || $data['price'] < 0))
            $errors['price'] = 'Введите корректную цену.';
        return $errors;
    }
}
