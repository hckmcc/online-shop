<?php
namespace Controller;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\OrderProduct;
use Model\User;
use Model\UserProduct;
use Request\OrderRequest;
use Service\Auth\AuthServiceInterface;
use Service\OrderService;

class OrderController
{
    private OrderService $orderService;
    private AuthServiceInterface  $authService;
    public function __construct(array $properties)
    {
        $this->orderService = $properties['OrderService'];
        $this->authService = $properties['AuthService'];
    }
    public function getOrderPage():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productsInCart= UserProduct::getProductsInCart($userId);
            if(is_null($productsInCart)){
                header('Location: /catalog');
            }
            $totalPrice = $this->countCartSum($productsInCart);
            $user= User::getUserById($userId);
            require_once '../View/order.php';
        }
    }
    public function getUserOrderList():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $orders = Order::getUserOrders($userId);
            if(!is_null($orders)){
                foreach ($orders as &$order) {
                    $order->setProducts(OrderProduct::getProductsInOrder($order->getId()));
                }
                unset($order);
            }
            $user= User::getUserById($userId);
            require_once '../View/my_orders.php';
        }
    }
    public function createOrder(OrderRequest $request):void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $errors = $request->validation();
            $productsInCart = UserProduct::getProductsInCart($userId);
            $totalPrice = $this->countCartSum($productsInCart);
            if (empty($errors)) {
                if (!empty($productsInCart)) {
                    $orderData = new CreateOrderDTO($userId, $request->getName(), $request->getPhone(), $request->getAddress(), $request->getComment(), $totalPrice, $productsInCart);
                    $this->orderService->create($orderData);
                    header('Location: /my_orders');
                }else{
                    header('Location: /catalog');
                }
            }
            $user= User::getUserById($userId);
            require_once '../View/order.php';
        }
    }
    private function countCartSum(array $products): float
    {
        $price=0;
        foreach ($products as $product) {
            $price += $product->getProductPrice()*$product->getProductAmount();
        }
        return $price;
    }
}