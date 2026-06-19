<?php

namespace MyProject\Models;

class Cart
{
    // Получить все товары в корзине вместе с данными о книге
    public static function all(): array
    {
        $stmt = Book::db()->query(
            'SELECT cart.id as cart_id, cart.qty, books.*
             FROM cart
             JOIN books ON books.id = cart.book_id
             ORDER BY cart.added_at DESC'
        );
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function add(int $bookId): void
    {
        $db = Book::db();
        // если книга уже в корзине — увеличиваем количество
        $stmt = $db->prepare('SELECT id, qty FROM cart WHERE book_id = ?');
        $stmt->execute([$bookId]);
        $existing = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existing) {
            $upd = $db->prepare('UPDATE cart SET qty = qty + 1 WHERE id = ?');
            $upd->execute([$existing['id']]);
        } else {
            $ins = $db->prepare('INSERT INTO cart (book_id, qty, added_at) VALUES (?, 1, NOW())');
            $ins->execute([$bookId]);
        }
    }

    public static function updateQty(int $cartId, int $qty): void
    {
        if ($qty < 1) {
            self::remove($cartId);
            return;
        }
        $stmt = Book::db()->prepare('UPDATE cart SET qty = ? WHERE id = ?');
        $stmt->execute([$qty, $cartId]);
    }

    public static function remove(int $cartId): void
    {
        $stmt = Book::db()->prepare('DELETE FROM cart WHERE id = ?');
        $stmt->execute([$cartId]);
    }

    public static function clear(): void
    {
        Book::db()->exec('DELETE FROM cart');
    }

    public static function totalCount(): int
    {
        $stmt = Book::db()->query('SELECT COALESCE(SUM(qty), 0) FROM cart');
        return (int) $stmt->fetchColumn();
    }

    public static function totalPrice(): float
    {
        $stmt = Book::db()->query(
            'SELECT COALESCE(SUM(cart.qty * books.price), 0)
             FROM cart JOIN books ON books.id = cart.book_id'
        );
        return (float) $stmt->fetchColumn();
    }
}
