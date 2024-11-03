<?php
namespace Model;
class OrderProduct extends Model
{
    private int $productId;
    private string $productName;
    private string $productCategoryName;
    private float $productPrice;
    private string $productPhoto;
    private int $productAmount;
    public static function getProductsInOrder(int $orderId):?array
    {
        $stmt = self::getPDO()->prepare("SELECT p.id, p.name, p.category_name, p.photo, op.price, op.amount FROM products p JOIN order_products op ON op.product_id=p.id WHERE op.order_id = :order_id;");
        $stmt->execute(['order_id' => $orderId]);
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return null;
        }
        foreach ($stmt as $product) {
            $orderProductObj = new self();
            $orderProductObj->setProperties($product);
            $products[]=$orderProductObj;
        }
        return $products;
    }
    public static function checkProductInOrder(int $userId, int $productId):bool
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM order_products op JOIN orders o ON op.order_id=o.id WHERE user_id = :user_id AND product_id = :product_id;");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return false;
        }
        return true;
    }
    public static function addProductsToOrder(int $orderId, int $productId, int $amount, float $price):void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO order_products (order_id, product_id, amount, price) VALUES (:order_id, :product_id, :amount, :price)");
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount, 'price' => $price]);
    }
    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductCategoryName(): string
    {
        return $this->productCategoryName;
    }

    public function getProductPrice(): float
    {
        return $this->productPrice;
    }

    public function getProductPhoto(): string
    {
        return $this->productPhoto;
    }

    public function getProductAmount(): int
    {
        return $this->productAmount;
    }

    private function setProperties(array $stmt): void
    {
        $this->productId = $stmt['id'];
        $this->productName = $stmt['name'];
        $this->productCategoryName = $stmt['category_name'];
        $this->productPhoto = $stmt['photo'];
        $this->productPrice = $stmt['price'];
        $this->productAmount = $stmt['amount'];
    }
}