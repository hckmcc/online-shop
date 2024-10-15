<?php
namespace Model;
use Model\projectPDO;
use PDO;

class Order
{
    private PDO $pdo;
    public function __construct(){
        $pdo= new projectPDO();
        $this->pdo = $pdo->returnPDO();
    }
    public function getUserOrders(int $userId): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
    public function createOrder(int $userId, string $name, string $phone, string $address, string $comment, float $totalPrice): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, name, phone, address, comment, price) VALUES (:user_id, :name, :phone, :address, :comment, :price) RETURNING id");
        $stmt->execute(['user_id' => $userId, 'name' => $name, 'phone' => $phone, 'address' => $address, 'comment' => $comment, 'price' => $totalPrice]);
        $orderId = $stmt->fetch();
        return $orderId['id'];
    }
}