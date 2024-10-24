<?php
namespace Model;
class UserProduct extends Model
{
    private Product $product;
    private int $productAmount;
    public static function getProductsInCart(int $userId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT *
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
    public static function addProductToCart(int $userId, int $productId, int $amount): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }

    public static function updateAmountInCart(int $userId, int $productId, int $amount): void
    {
        $stmt = self::getPDO()->prepare("UPDATE user_products SET amount = amount+:amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'amount' => $amount]);
    }
    public static function getUserProductInCart(int $userId, int $productId): bool
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        if($stmt->fetch()){
            return true;
        }
        return false;
    }
    public static function clearCart(int $userId):void
    {
        $stmt = self::getPDO()->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }
    public static function deleteProductFromCart(int $userId, int $productId):void
    {
        $stmt = self::getPDO()->prepare("DELETE FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function getProductId(): int
    {
        return $this->product->getId();
    }

    public function getProductName(): string
    {
        return $this->product->getName();
    }

    public function getProductCategoryName(): string
    {
        return $this->product->getCategoryName();
    }

    public function getProductPrice(): float
    {
        return $this->product->getPrice();
    }

    public function getProductPhoto(): string
    {
        return $this->product->getPhoto();
    }

    public function getProductAmount(): int
    {
        return $this->productAmount;
    }

    private function setProperties(array $userProducts): void
    {
        $this->product = new Product();
        $this->product->setProperties($userProducts);
        $this->productAmount = $userProducts['amount'];
    }
}