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

    private function createPDO(): PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}