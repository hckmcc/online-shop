<?php
require_once '../Model/ProductModel.php';
class ProductService
{
    public function getProductsInCatalog()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $model = new ProductModel();
            return $model->getProducts();
        }
    }

    public function getProductsInCart()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $user_id = $_SESSION['user_id'];
            $model = new ProductModel();
            return $model->getProductsInCart($user_id);

        }
    }

    public function addProductToCart(int $product_id, int $amount)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            if (!empty($product_id)) {
                $model = new ProductModel();
                $result = $model->getOneProduct($product_id);
                if (!$result) {
                    return false;
                }
            } else {
                return false;
            }
            $user_id = $_SESSION['user_id'];
            if (empty($amount)) {
                $amount = 1;
            }
            $result = $model->getUsersProductInCart($user_id, $product_id);
            if (!$result) {
                $model->addProductToCart($product_id, $user_id, $amount);
            } else {
                $model->updateAmountInCart($product_id, $user_id, $amount);
            }
            return true;
        }
    }
}