<?php require_once './static/html/header.html';
if(is_null($productsInCart)){
    $cartEmpty='d-block';
    $cartFilled='d-none';
}else{
    $cartEmpty='d-none';
    $cartFilled='d-block';
}
$total_price=0;
?>
<div class="main">
    <div class="container">
        <h3 class="<?php echo $cartFilled ?>">Cart</h3>
        <div class="container space-2 space-lg-3 <?php echo $cartEmpty ?>">
            <div class="w-md-80 w-lg-50 text-center mx-md-auto">
                <figure id="iconEmptyCart" class="svg-preloader ie-height-111 max-width-15 mx-auto mb-3">
                    <img class="js-svg-injector" src="https://htmlstream.com/preview/front-v2.9.0/assets/svg/icons/icon-66.svg" alt="SVG"
                         data-parent="#iconEmptyCart">
                </figure>
                <div class="mb-5">
                    <h1 class="h3 font-weight-medium">Your cart is currently empty</h1>
                    <p>Before proceed to checkout you must add some products to your shopping cart. You will find a lot of interesting products on our "Catalog" page.</p>
                </div>
                <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="./catalog">Start Shopping</a>
            </div>
        </div>
        <div class="card-deck">
            <?php if(!is_null($productsInCart)): ?>
            <?php foreach($productsInCart as $product): ?>
                <div class="card text-center">
                    <a href="#">
                        <img class="card-img-top" src="<?= $product->getProductPhoto(); ?>" alt="">
                        <div class="card-body">
                            <p class="card-text text-muted"><?= $product->getProductCategoryName();?></p>
                            <h5 class="card-title"><?= $product->getProductName();?></h5>
                            <div class="card-footer">
                                <div><?= $product->getProductPrice();?>$</div>
                                <div><?= $product->getProductAmount();?>pcs</div>
                            </div>
                        </div>
                    </a>
                    <form action="/delete_product" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product->getProductId();?>">
                        <input class="btn btn-danger btn-pill transition-3d-hover mx-5" type="Submit" value="Remove">
                    </form>
                </div>
                <span hidden><?= $total_price+=$product->getProductAmount()*$product->getProductPrice();?></span>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="checkoutForm <?php echo $cartFilled ?>">
        <div class="orderInfo">
            <p>Total price:</p>
            <p><?php print_r($total_price) ?>$</p>
        </div>
        <a class="btn btn-primary" href="./order" role="button">Go to checkout</a>
    </div>
</div>
<style>
    .main{
        display: flex;
        flex-direction: row;
        margin-left: 8%;
        margin-right: 8%;
    }
    .container{
        margin-top: 20px;
    }
    .svg-preloader{
        max-width: 7rem;
    }
    .card-deck{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
        width: 80%;
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
        display: flex;
        justify-content: space-between;
    }
    .checkoutForm{
        margin-top: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        position: relative;
        max-width: 250px;
        width: 100%;
        max-height: fit-content;
        background: #ffffff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .orderInfo{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-weight: bold;
        font-size: 18px;
    }
</style>