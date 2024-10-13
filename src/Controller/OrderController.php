<?php
require_once '../Model/UserProductsModel.php';
require_once '../Model/OrderModel.php';
require_once '../Model/OrderProductsModel.php';
class OrderService
{
    public function getOrderPage():void
    {
        if (!isset($_SESSION)) {
        session_start();
    }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $user_id = $_SESSION['user_id'];
            $user_products_model = new UserProductsModel();
            $result = $user_products_model->getProductsInCart($user_id);
            $total_price = $this->countCartSum($result);
            require_once '../View/order.php';
        }
    }
    public function getOrderList():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $user_id = $_SESSION['user_id'];
            $orders_model = new OrderModel();
            $orders = $orders_model->getOrders($user_id);
            foreach ($orders as $order) {

            }
            require_once '../View/my_orders.php';
        }
    }
    public function createOrder($name, $phone, $address, $comment):void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $user_id = $_SESSION['user_id'];
            $errors = $this->orderValidation($name, $phone, $address);
            $user_products_model = new UserProductsModel();
            $result = $user_products_model->getProductsInCart($user_id);
            $order_model = new OrderModel();
            $total_price = $this->countCartSum($result);
            if (empty($errors)) {
                if (!empty($result)) {
                    $order_id = $order_model->createOrder($user_id, $name, $phone, $address, $comment, $total_price);
                    $products_in_order_model = new OrderProductsModel();
                    foreach ($result as $product){
                        $products_in_order_model->addProductsToOrder($order_id, $product['id'], $product['amount']);
                    }
                }else{
                    header('Location: /catalog');
                }
            }
            require_once '../View/order.php';
        }
    }
    private function countCartSum(array $products): int
    {
        $price=0;
        foreach ($products as $product) {
            $price += $product['price']*$product['amount'];
        }
        return $price;
    }
    private function orderValidation($name, $phone, $address):array
    {
        $errors = array();
        if (empty($name)) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($name)>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Enter phone';
        }elseif(strlen($phone)!==12){
            $errors['phone'] = 'Invalid phone number';
        }
        if (empty($address)) {
            $errors['address'] = 'Enter address';
        }elseif(strlen($address)>1000){
            $errors['address'] = 'Address must contain less than 1000 symbols';
        }
        return $errors;
    }
}