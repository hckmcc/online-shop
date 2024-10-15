<?php
namespace Controller;
use Model\Product;
use Model\UserProduct;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getProductsInCatalog():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        } else {
            $products = $this->productModel->getProducts();
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
            $userId = $_SESSION['user_id'];
            $productsInCart = $this->productModel->getProductsInCart($userId);
            require_once '../View/cart.php';
        }
    }

    public function addProductToCart():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            if (!empty($_POST['product_id'])) {
                $product = $this->productModel->getOneProduct($_POST['product_id']);
                if (!$product) {
                    http_response_code(400);
                    exit;
                }
            } else {
                http_response_code(400);
                exit;
            }
            if (empty($_POST['amount'])) {
                $amount = 1;
            }
            $productInCart = $this->userProductModel->getUserProductInCart($userId, $_POST['product_id'],);
            if (!$productInCart) {
                $this->userProductModel->addProductToCart($userId, $_POST['product_id'], $_POST['amount']);
            } else {
                $this->userProductModel->updateAmountInCart($userId, $_POST['product_id'], $_POST['amount']);
            }
            header('Location: /catalog');
        }
    }
    public function deleteProductFromCart():void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            if (empty($_POST['product_id'])) {
                http_response_code(400);
                exit;
            }
            $this->userProductModel->deleteProductFromCart($userId, $_POST['product_id']);
            header('Location: /cart');
        }
    }
}