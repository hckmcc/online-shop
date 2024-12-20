<?php
namespace Controller;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\Review;
use Model\User;
use Model\UserProduct;
use Request\AddProductRequest;
use Request\AddReviewRequest;
use Request\DeleteProductRequest;
use Request\GetProductRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;

class ProductController
{
    private CartService  $cartService;
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService, CartService  $cartService)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
    }
    public function getProductsInCatalog():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        } else {
            $products = Product::getProducts();
            $user= $this->authService->getCurrentUser();
            require_once '../View/catalog.php';
        }
    }
    public function getProductPage(GetProductRequest $request):void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        } else {
            $product = Product::getOneProduct($request->getProductId());
            if (empty($product)) {
                http_response_code(400);
                exit;
            }
            $user= $this->authService->getCurrentUser();
            $userId= $user->getId();
            $productOrdered = OrderProduct::checkProductInOrder($userId, $request->getProductId());
            $reviews = Review::getReviews($request->getProductId());
            $meanRating = Review::getProductAverageRating($request->getProductId());
            if($reviews) {
                $reviewsCount = count($reviews);
            }else{
                $reviewsCount = 0;
            }
            $user= $this->authService->getCurrentUser();
            require_once '../View/product.php';
        }
    }

    public function getProductsInCart():void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productsInCart = UserProduct::getProductsInCart($userId);
            $user= User::getUserById($userId);
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
                $product = Product::getOneProduct(intval($request->getProductId()));
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
            $this->cartService->addToCart($userId, $request->getProductId(), $amount);
            header('Location: /cart');
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
            UserProduct::deleteProductFromCart($userId, intval($request->getProductId()));
            header('Location: /cart');
        }
    }
    public function addReview(AddReviewRequest $request):void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $errors = $request->validation();
            $productId = $request->getProductId();
            $productOrdered = OrderProduct::checkProductInOrder($userId, $request->getProductId());

            if(empty($errors) and $productOrdered) {
                $product = Product::getOneProduct($productId);
                if (empty($product)) {
                    http_response_code(400);
                    exit;
                }
                Review::addReview($userId, $productId, $request->getRating(), $request->getReviewText());
            }else{
                http_response_code(400);
            }
            header("Location: /product?id=$productId");
        }
    }
}