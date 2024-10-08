<?php require_once './static/html/header.html' ?>

<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach($result as $product): ?>
        <div class="card text-center">
            <a href="#">
                <img class="card-img-top" src="<?= $product['photo']; ?>" alt="">
                <div class="card-body">
                    <p class="card-text text-muted"><?= $product['category_name'];?></p>
                    <h5 class="card-title"><?= $product['name'];?></h5>
                    <div class="card-footer"><?= $product['price'];?>$</div>
                </div>
            </a>
            <form action="/add_product" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'];?>">
                <label>
                    <input type="number" name="amount" value="1" min="1" max="10" >
                </label>
                <input type="Submit" value="Add to cart">
            </form>
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
    }
</style>