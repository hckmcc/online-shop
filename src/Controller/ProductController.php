<?php
namespace Controller;
use Model\Product;
use Model\UserProduct;
use Model\User;
use Request\AddProductRequest;
use Request\DeleteProductRequest;
use Service\ProductService;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private User $userModel;
    private ProductService  $productService;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->productService = new ProductService();
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
            $products = $this->productModel->getPrducts();
            $user= $this->userModel->getUserById($_SESSION['user_id']);
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
            $productsInCart = $this->userProductModel->getProductsInCart($userId);
            $user= $this->userModel->getUserById($userId);
            require_once '../View/cart.php';
        }
    }

    public function addProductToCart(AddProductRequest $request):void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            if (!empty(intval($request->getProductId()))) {
                $product = $this->productModel->getOneProduct(intval($request->getProductId()));
                if (empty($product)) {
                    http_response_code(400);
                    exit;
                }
            } else {
                http_response_code(400);
                exit;
            }
            if (!is_int(intval($request->getProductAmount())) or intval($request->getProductAmount())===0) {
                $amount = 1;
            }else{
                $amount = $request->getProductAmount();
            }
            $this->productService->addToCart($userId, $request->getProductId(), $amount);
            header('Location: /catalog');
        }
    }
    public function deleteProductFromCart(DeleteProductRequest $request):void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            $userId = $_SESSION['user_id'];
            if (empty(intval($request->getProductId()))) {
                http_response_code(400);
                exit;
            }
            $this->userProductModel->deleteProductFromCart($userId, intval($request->getProductId()));
            header('Location: /cart');
        }
    }
}