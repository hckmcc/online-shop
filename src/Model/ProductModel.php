<?php
class ProductModel
{
    public function getProducts(): array|false
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOneProduct($product_id): array|false
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        return $stmt->fetch();
    }

    public function getProductsInCart($user_id): array|false
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("SELECT p.name, p.category_name, p.price, p.photo, up.amount
                         FROM user_products up
                         JOIN products p ON up.product_id = p.id
                         WHERE up.user_id = :user_id; ");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function addProductToCart($product_id, $user_id, $amount): void
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function updateAmountInCart($product_id, $user_id, $amount): void
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("UPDATE user_products SET amount = amount+:amount WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }
    public function getUsersProductInCart($user_id, $product_id): array|false
    {
        $pdo = $this->createPDO();
        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        return $stmt->fetch();
    }
    private function createPDO(): PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}