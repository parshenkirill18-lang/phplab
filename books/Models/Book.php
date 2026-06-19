<?php

namespace MyProject\Models;

class Book
{
    private static ?\PDO $pdo = null;

    public static function db(): \PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                'mysql:host=localhost;dbname=bookstore;charset=utf8',
                'root',
                '',
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }

    public static function all(): array
    {
        $stmt = self::db()->query('SELECT * FROM books ORDER BY added_at DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM books WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO books (title, author, genre, year, price, description, added_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())'
        );
        $stmt->execute([
            $data['title'],
            $data['author'],
            $data['genre'],
            $data['year'] ?: null,
            $data['price'] ?: 0,
            $data['description'],
        ]);
        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $stmt = self::db()->prepare(
            'UPDATE books SET title=?, author=?, genre=?, year=?, price=?, description=? WHERE id=?'
        );
        $stmt->execute([
            $data['title'],
            $data['author'],
            $data['genre'],
            $data['year'] ?: null,
            $data['price'] ?: 0,
            $data['description'],
            $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = self::db()->prepare('DELETE FROM books WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function countAll(): int
    {
        return (int) self::db()->query('SELECT COUNT(*) FROM books')->fetchColumn();
    }
}
