<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\User;
use Model\UserProduct;

class OrderService
{
    public function create(CreateOrderDTO $orderData): void
    {
        $pdo = Model::getPdo();
        $pdo->beginTransaction();
        try {
            $orderId = Order::createOrder($orderData->getUserId(), $orderData->getName(), $orderData->getPhone(), $orderData->getAddress(), $orderData->getComment(), $orderData->getPrice());
            $productsInCart = $orderData->getProductsInCart();
            foreach ($productsInCart as $product){
                OrderProduct::addProductsToOrder($orderId, $product->getProductId(), $product->getProductAmount(), $product->getProductPrice());
            }
            UserProduct::clearCart($orderData->getUserId());
        } catch (\PDOException $exception) {
            $pdo->rollBack();
            throw $exception;
        }
        $pdo->commit();
    }
}