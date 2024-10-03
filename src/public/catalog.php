<?php
session_start();
if (!isset($_SESSION['user_id'])){
    header('Location: /login');
}else{
    $pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');

    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    $result = $stmt->fetchAll();
};
?>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach($result as $product): ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">Hit!</div>
                <img class="card-img-top" src="<?= $product['photo']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?= $product['category_name'];?></p>
                    <a href="#"><h5 class="card-title"><?= $product['name'];?></h5></a>
                    <div class="card-footer"><?= $product['price'];?>$</div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<style>
    body {
        font-style: ;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }
    .card-img-top{
        width: 100%;
        max-font-size: 100%;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>