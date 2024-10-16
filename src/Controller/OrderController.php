<?php
namespace Controller;
use Model\Order;
use Model\Product;
use Model\UserProduct;
use Model\OrderProduct;
use Model\User;
class OrderController
{
    private Product $productModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private UserProduct $userProductModel;
    private User $userModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
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
            $productsInCart= $this->productModel->getProductsInCart($userId);
            if(empty($productsInCart)){
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
            foreach ($orders as &$order) {
                $order['products'] = $this->productModel->getProductsInOrder($order['id']);
            }
            unset($order);
            $user= $this->userModel->getUserById($userId);
            require_once '../View/my_orders.php';
        }
    }
    public function createOrder():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $userId = $_SESSION['user_id'];
            $errors = $this->orderValidation($_POST);
            $productsInCart = $this->productModel->getProductsInCart($userId);
            $totalPrice = $this->countCartSum($productsInCart);
            if (empty($errors)) {
                if (!empty($productsInCart)) {
                    $orderId = $this->orderModel->createOrder($userId, $_POST['name'], $_POST['phone'], $_POST['address'], $_POST['comment'], $totalPrice);
                    foreach ($productsInCart as $product){
                        $this->orderProductModel->addProductsToOrder($orderId, $product['id'], $product['amount'], $product['price']);
                    }
                    $this->userProductModel->clearCart($userId);
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
            $price += $product['price']*$product['amount'];
        }
        return $price;
    }
    private function orderValidation(array $postData):array
    {
        $errors = array();
        if (empty($postData['name'])) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($postData['name'])>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        if (empty($postData['phone'])) {
            $errors['phone'] = 'Enter phone';
        }elseif(strlen($postData['phone'])!==12){
            $errors['phone'] = 'Invalid phone number';
        }
        if (empty($postData['address'])) {
            $errors['address'] = 'Enter address';
        }elseif(strlen($postData['address'])>1000){
            $errors['address'] = 'Address must contain less than 1000 symbols';
        }
        return $errors;
    }
}