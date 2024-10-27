<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    public function addToCart(int $userId, int $productId, int $amount): void
    {
        $isProductInCart = UserProduct::getUserProductInCart($userId, $productId);
        if (!$isProductInCart) {
            UserProduct::addProductToCart($userId, $productId, $amount);
        } else {
            UserProduct::updateAmountInCart($userId, $productId, $amount);
        }
    }
}