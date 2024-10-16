<?php
namespace Model;
class OrderProduct extends Model
{
    public function addProductsToOrder(int $orderId, int $productId, int $amount, float $price):void
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }
}