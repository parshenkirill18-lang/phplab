<?php

namespace MyProject\Models;

class Article
{
    private static ?\PDO $pdo = null;

    private static function db(): \PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                'mysql:host=localhost;dbname=coursework;charset=utf8mb4',
                'root',
                '',
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }

    public static function all(): array
    {
        $stmt = self::db()->query(
            'SELECT id, title, author, category, created_at,
                    LEFT(content, 300) AS excerpt,
                    CHAR_LENGTH(content) AS content_length
             FROM articles
             ORDER BY created_at DESC'
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO articles (title, content, author, category, created_at)
             VALUES (?, ?, ?, ?, NOW())'
        );
        $stmt->execute([
            $data['title'],
            $data['content'],
            $data['author'],
            $data['category'],
        ]);
        return (int) self::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare(
            'UPDATE articles SET title = ?, content = ?, author = ?, category = ? WHERE id = ?'
        );
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['author'],
            $data['category'],
            $id,
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare('DELETE FROM articles WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public static function countByCategory(): array
    {
        $stmt = self::db()->query(
            'SELECT category, COUNT(*) AS cnt FROM articles GROUP BY category ORDER BY cnt DESC'
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function totalCount(): int
    {
        return (int) self::db()->query('SELECT COUNT(*) FROM articles')->fetchColumn();
    }

    /** Расчёт времени чтения (200 слов/мин) */
    public static function readingTime(string $content): int
    {
        $words = str_word_count(strip_tags($content));
        return (int) max(1, ceil($words / 200));
    }
}
