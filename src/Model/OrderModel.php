<?php
class OrderModel
{
    public function getOrders(int $user_id): array|false
    {
        $pdo= $this->createPDO();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt;
    }
    public function createOrder(int $user_id, string $name, string $phone, string $address, string $comment, int $total_price): int
    {
        $pdo= $this->createPDO();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, name, phone, address, comment, price) VALUES (:user_id, :name, :phone, :address, :comment, :price) RETURNING id");
        $stmt->execute(['user_id' => $user_id, 'name' => $name, 'phone' => $phone, 'address' => $address, 'comment' => $comment, 'price' => $total_price]);
        $order_id = $stmt->fetch();
        return $order_id['id'];
    }

    private function createPDO(): PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}