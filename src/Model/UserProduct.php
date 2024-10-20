<?php
namespace Model;
class UserProduct extends Model
{
    private int $productId;
    private string $productName;
    private string $productCategoryName;
    private float $productPrice;
    private string $productPhoto;
    private int $productAmount;
    public function getProductsInCart(int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT p.id, p.name, p.category_name, p.price, p.photo, up.amount
                         FROM user_products up
                         JOIN products p ON up.product_id = p.id
                         WHERE up.user_id = :user_id; ");
        $stmt->execute(['user_id' => $userId]);
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return null;
        }
        foreach ($stmt as $product) {
            $userProductObj = new self();
            $userProductObj->setProperties($product);
            $products[]=$userProductObj;
        }
        return $products;
    }
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
    public function getUserProductInCart(int $userId, int $productId): bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        if($stmt->fetch()){
            return true;
        }
        return false;
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