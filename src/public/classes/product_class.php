<?php
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
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

            $stmt = $pdo->prepare("SELECT * FROM products");
            $stmt->execute();
            return $stmt->fetchAll();
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
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

            $stmt = $pdo->prepare("SELECT p.name, p.category_name, p.price, p.photo, up.amount
                         FROM user_products up
                         JOIN products p ON up.product_id = p.id
                         WHERE up.user_id = :user_id; ");
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetchAll();
        }
    }

    public function addProductToCart(PDO $pdo, int $product_id, int $amount)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        } else {
            if (!empty($product_id)) {
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
                $stmt->execute(['product_id' => $product_id]);
                $result = $stmt->fetchAll();
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
            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
            $result = $stmt->fetchAll();
            if (!$result) {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
            } else {
                $stmt = $pdo->prepare("UPDATE user_products SET amount = amount+:amount WHERE user_id = :user_id AND product_id = :product_id");
            }
            $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

            return true;
        }
    }
}