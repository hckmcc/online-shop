<?php

namespace Service;
use DTO\CreateOrderDTO;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
    }

    public function create(CreateOrderDTO $orderData): void
    {
        $pdo = Model::getPdo();
        $pdo->beginTransaction();
        try {
            $orderId = $this->orderModel->createOrder($orderData->getUserId(), $orderData->getName(), $orderData->getPhone(), $orderData->getAddress(), $orderData->getComment(), $orderData->getPrice());
            $productsInCart = $orderData->getProductsInCart();
            foreach ($productsInCart as $product){
                $this->orderProductModel->addProductsToOrder($orderId, $product->getProductId(), $product->getProductAmount(), $product->getProductPrice());
            }
            $this->userProductModel->clearCart($orderData->getUserId());
        } catch (\PDOException $exception) {
            $pdo->rollBack();
            throw $exception;
        }
        $pdo->commit();
    }
}