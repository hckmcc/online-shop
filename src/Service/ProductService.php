<?php

namespace Service;

use Model\UserProduct;

class ProductService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }
    public function addToCart(int $userId, int $productId, int $amount): void
    {
        $isProductInCart = $this->userProductModel->getUserProductInCart($userId, $productId);
        if (!$isProductInCart) {
            $this->userProductModel->addProductToCart($userId, $productId, $amount);
        } else {
            $this->userProductModel->updateAmountInCart($userId, $productId, $amount);
        }
    }
}