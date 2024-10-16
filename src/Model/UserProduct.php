<?php
namespace Model;
class UserProduct extends Model
{
    public function addProductToCart(int $userId, int $productId, int $amount): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public function updateAmountInCart(int $userId, int $productId, int $amount): void
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = amount+:amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }
    public function getUserProductInCart(int $userId, int $productId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        return $stmt->fetch();
    }
    public function clearCart(int $userId):void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
    public function deleteProductFromCart(int $userId, int $productId):void
    {
        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }
}