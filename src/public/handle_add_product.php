<?php
if(!isset($_SESSION))
{
    session_start();
}
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}else{
    $product_id = $_POST["product_id"];
    if(!empty($product_id)) {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $result = $stmt->fetchAll();
        if (!$result){
            echo "Invalid request";
            die;
        }
    }else{
        echo "Invalid request";
        die;
    }
    $user_id = $_SESSION['user_id'];
    if (empty($_POST["amount"])){
        $amount=1;
    }else{
        $amount = $_POST["amount"];
    }
    $pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $result=$stmt->fetchAll();
    if (!$result){
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
    }else{
        $stmt = $pdo->prepare("UPDATE user_products SET amount = amount+:amount WHERE user_id = :user_id AND product_id = :product_id");
    }
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);

    require_once './catalog.php';
};