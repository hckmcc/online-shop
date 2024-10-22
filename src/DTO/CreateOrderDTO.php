<?php

namespace DTO;

use PDO;

class CreateOrderDTO
{
    public function __construct(private int $userId,
                                private string $name,
                                private string $phone,
                                private string $address,
                                private string $comment,
                                private float $price,
                                private array $productsInCart,
                                private PDO $pdo
    ){

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
    public function getProductsInCart(): array
    {
        return $this->productsInCart;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}