<?php
namespace Controller;
use DTO\CreateOrderDTO;
use Model\Order;
use Model\Product;
use Model\UserProduct;
use Model\OrderProduct;
use Model\User;
use Request\OrderRequest;
use Service\OrderService;

class OrderController
{
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;
    private User $userModel;
    private OrderService $orderService;
    public function __construct()
    {
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->orderService = new OrderService();
    }
    public function getOrderPage():void
    {
        if (!isset($_SESSION)) {
        session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            $productsInCart= $this->userProductModel->getProductsInCart($userId);
            if(is_null($productsInCart)){
                header('Location: /catalog');
            }
            $totalPrice = $this->countCartSum($productsInCart);
            $user= $this->userModel->getUserById($userId);
            require_once '../View/order.php';
        }
    }
    public function getUserOrderList():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            $orders = $this->orderModel->getUserOrders($userId);
            if(!is_null($orders)){
                foreach ($orders as &$order) {
                    $order->setProducts($this->orderProductModel->getProductsInOrder($order->getId()));
                }
                unset($order);
            }
            $user= $this->userModel->getUserById($userId);
            require_once '../View/my_orders.php';
        }
    }
    public function createOrder(OrderRequest $request):void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $userId = $_SESSION['user_id'];
            $errors = $request->validation();
            $productsInCart = $this->userProductModel->getProductsInCart($userId);
            $totalPrice = $this->countCartSum($productsInCart);
            if (empty($errors)) {
                if (!empty($productsInCart)) {
                    $orderData = new CreateOrderDTO($userId, $request->getName(), $request->getPhone(), $request->getAddress(), $request->getComment(), $totalPrice, $productsInCart, $this->userProductModel->getPDO());
                    $this->orderService->create($orderData);
                    header('Location: /my_orders');
                }else{
                    header('Location: /catalog');
                }
            }
            $user= $this->userModel->getUserById($userId);
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