<?php
namespace Model;
class Product extends Model
{
    private int $id;
    private string $name;
    private string $categoryName;
    private int $price;
    private string $photo;
    public function getProducts(): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return null;
        }
        foreach ($stmt as $product) {
            $productObj = new self();
            $productObj->setProperties($product);
            $products[]=$productObj;
        }
        return $products;
    }

    public function getOneProduct(int $productId): ?Product
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        $stmt = $stmt->fetch();
        if(empty($stmt)){
            return null;
        }
        $productObj = new self();
        $productObj->setProperties($stmt);
        return $productObj;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    private function setProperties(array $stmt): void
    {
        $this->id = $stmt['id'];
        $this->name = $stmt['name'];
        $this->categoryName = $stmt['category_name'];
        $this->price = $stmt['price'];
        $this->photo = $stmt['photo'];
    }
}