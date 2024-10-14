<?php
require_once '../Model/projectPDO.php';
class OrderProduct
{
    private PDO $pdo;
    public function __construct(){
        $pdo= new projectPDO();
        $this->pdo = $pdo->returnPDO();
    }
    public function addProductsToOrder(int $orderId, int $productId, int $amount, float $price):void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }
}