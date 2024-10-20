<?php
namespace Model;
class Order extends Model
{
    private int $id;
    private int $userId;
    private string $name;
    private string $phone;
    private string $address;
    private string $comment;
    private float $price;
    private array $products;
    public function getUserOrders(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $userId]);
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return null;
        }
        foreach ($stmt as $product) {
            $orderObj = new self();
            $orderObj->setProperties($product);
            $orders[]=$orderObj;
        }
        return $orders;
    }
    public function createOrder(int $userId, string $name, string $phone, string $address, string $comment, float $totalPrice): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, name, phone, address, comment, price) VALUES (:user_id, :name, :phone, :address, :comment, :price) RETURNING id");
        $stmt->execute(['user_id' => $userId, 'name' => $name, 'phone' => $phone, 'address' => $address, 'comment' => $comment, 'price' => $totalPrice]);
        $orderId = $stmt->fetch();
        return $orderId['id'];
    }
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
    private function setProperties(array $stmt): void
    {
        $this->id = $stmt['id'];
        $this->userId = $stmt['user_id'];
        $this->name = $stmt['name'];
        $this->phone = $stmt['phone'];
        $this->address = $stmt['address'];
        $this->comment = $stmt['comment'];
        $this->price = $stmt['price'];
    }
}