<?php

namespace MyProject\Models;

class Article
{
    private static ?\PDO $pdo = null;

    private static function db(): \PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                'mysql:host=localhost;dbname=lab10;charset=utf8mb4',
                'root',   
                '',       
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$pdo;
    }

    public static function all(): array
    {
        $stmt = self::db()->query('SELECT * FROM articles ORDER BY id');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM articles WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare(
            'UPDATE articles SET title = ?, content = ?, author = ? WHERE id = ?'
        );
        return $stmt->execute([
            $data['title'],
            $data['content'],
            $data['author'],
            $id,
        ]);
    }
}
