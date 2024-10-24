<?php
namespace Controller;
use Model\Product;
use Model\UserProduct;
use Model\User;
use Request\AddProductRequest;
use Request\DeleteProductRequest;
use Service\AuthService;
use Service\CartService;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    private User $userModel;
    private CartService  $productService;
    private AuthService $authService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->productService = new CartService();
        $this->authService = new AuthService();
    }
    public function getProductsInCatalog():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        } else {
            $products = $this->productModel->getProducts();
            $user= $this->authService->getCurrentUser();
            require_once '../View/catalog.php';
        }
    }

    public function getProductsInCart():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productsInCart = $this->userProductModel->getProductsInCart($userId);
            $user= $this->userModel->getUserById($userId);
            require_once '../View/cart.php';
        }
    }

    public function addProductToCart(AddProductRequest $request):void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
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
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            if (empty(intval($request->getProductId()))) {
                http_response_code(400);
                exit;
            }
            $this->userProductModel->deleteProductFromCart($userId, intval($request->getProductId()));
            header('Location: /cart');
        }
    }
}