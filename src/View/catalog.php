<?php require_once './static/html/header.html' ?>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php if(!is_null($products)): ?>
        <?php foreach($products as $product): ?>
        <div class="card text-center">
            <a href="#">
                <img class="card-img-top" src="<?= $product->getPhoto(); ?>" alt="">
                <div class="card-body">
                    <p class="card-text text-muted"><?= $product->getCategoryName();?></p>
                    <h5 class="card-title"><?= $product->getName();?></h5>
                    <div class="card-footer"><?= $product->getPrice();?>$</div>
                </div>
            </a>
            <form action="/add_product" method="POST">
                <input type="hidden" name="product_id" value="<?= $product->getId();?>">
                <label>
                    <input type="number" name="amount" value="1" min="1" max="10" >
                </label>
                <input type="Submit" value="Add to cart">
            </form>
        </div>
        <?php endforeach; ?>
        <?php endif;?>
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
        object-fit: contain;
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
    }
</style>