<?php
class OrderProductsModel
{
    public function addProductsToOrder(int $order_id, int $product_id, int $amount):void
    {
        $pdo= $this->createPDO();
        $stmt = $pdo->prepare("INSERT INTO products_in_order (order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)");
        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'amount' => $amount]);
    }
    private function createPDO(): PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}