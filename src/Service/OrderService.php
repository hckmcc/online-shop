<?php

namespace Service;
use DTO\CreateOrderDTO;
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

    public function create(CreateOrderDTO $data): void
    {
        $orderId = $this->orderModel->createOrder($data->getUserId(), $data->getName(), $data->getPhone(), $data->getAddress(), $data->getComment(), $data->getPrice());
        $productsInCart = $data->getProductsInCart();
        foreach ($productsInCart as $product){
            $this->orderProductModel->addProductsToOrder($orderId, $product->getProductId(), $product->getProductAmount(), $product->getProductPrice());
        }
        $this->userProductModel->clearCart($data->getUserId());
    }
}