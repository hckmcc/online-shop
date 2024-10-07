<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}else{
    $user_id = $_SESSION['user_id'];
    $pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');

    $stmt = $pdo->prepare("SELECT p.name, p.category_name, p.price, p.photo, up.amount
     FROM user_products up
     JOIN products p ON up.product_id = p.id
     WHERE up.user_id = :user_id; ");
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetchAll();
};
?>

<?php require_once './static/html/header.html' ?>

<div class="container">
    <h3>Cart</h3>
    <div class="card-deck">
        <?php foreach($result as $product): ?>
            <div class="card text-center">
                <a href="#">
                    <img class="card-img-top" src="<?= $product['photo']; ?>" alt="">
                    <div class="card-body">
                        <p class="card-text text-muted"><?= $product['category_name'];?></p>
                        <h5 class="card-title"><?= $product['name'];?></h5>
                        <div class="card-footer">
                            <div><?= $product['price'];?>$</div>
                            <div><?= $product['amount'];?>pcs</div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    .container{
        margin-top: 20px;
    }
    .card-deck{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    .card, .card a {
        text-decoration: none;
        color:black;
        margin-bottom: 10px;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }
    .card-img-top{
        width: 100%;
        height: 200px;
        max-font-size: 100%;
    }

    .text-muted {
        font-size: 15px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
        max-height: 20%;
        text-decoration: none;
        display: flex;
        justify-content: space-between;
    }
</style>