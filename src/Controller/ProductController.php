<?php
require_once '../Model/ProductModel.php';
require_once '../Model/UserProductsModel.php';
class ProductService
{
    public function getProductsInCatalog():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $product_model = new ProductModel();
            $result = $product_model->getProducts();
            require_once '../View/catalog.php';
        }
    }

    public function getProductsInCart():void
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
            require_once '../View/cart.php';
        }
    }

    public function addProductToCart(int $product_id, int $amount):void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $user_id = $_SESSION['user_id'];
            if (!empty($product_id)) {
                $product_model = new ProductModel();
                $product = $product_model->getOneProduct($product_id);
                if (!$product) {
                    http_response_code(404);
                    exit;
                }
            } else {
                http_response_code(404);
                exit;
            }
            if (empty($amount)) {
                $amount = 1;
            }
            $user_products_model = new UserProductsModel();
            $product_in_cart = $user_products_model->getUsersProductInCart($user_id, $product_id);
            if (!$product_in_cart) {
                $user_products_model->addProductToCart($product_id, $user_id, $amount);
            } else {
                $user_products_model->updateAmountInCart($product_id, $user_id, $amount);
            }
            header('Location: /catalog');
        }
    }
}