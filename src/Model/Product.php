<?php
namespace Model;
class Product extends Model
{
    public function getProducts(): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOneProduct(int $productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetch();
    }
    public function getProductsInCart(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT p.id, p.name, p.category_name, p.price, p.photo, up.amount
                         FROM user_products up
                         JOIN products p ON up.product_id = p.id
                         WHERE up.user_id = :user_id; ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
    public function getProductsInOrder(int $orderId):array|false
    {
        $stmt = $this->pdo->prepare("SELECT p.id, p.name, p.category_name, p.photo, op.price, op.amount FROM products p JOIN order_products op ON op.product_id=p.id WHERE op.order_id = :order_id;");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }
}