<?php require_once './static/html/header.html';
if(is_null($orders)){
    $ordersEmpty='d-block';
    $ordersFilled='d-none';
}else{
    $ordersEmpty='d-none';
    $ordersFilled='d-block';
}
?>
<div class="main">
    <div class="container">
        <h3 class="<?php echo $ordersFilled ?>">My orders</h3>
        <div class="container space-2 space-lg-3 <?php echo $ordersEmpty ?>">
            <div class="w-md-80 w-lg-50 text-center mx-md-auto">
                <figure id="iconEmptyCart" class="svg-preloader ie-height-111 max-width-15 mx-auto mb-3">
                    <img class="js-svg-injector" src="https://htmlstream.com/preview/front-v2.9.0/assets/svg/icons/icon-66.svg" alt="SVG"
                         data-parent="#iconEmptyCart">
                </figure>
                <div class="mb-5">
                    <h1 class="h3 font-weight-medium">You don't have any orders yet</h1>
                </div>
                <a class="btn btn-primary btn-pill transition-3d-hover px-5" href="./catalog">Start Shopping</a>
            </div>
        </div>
        <div class="<?php echo $ordersFilled ?>"><?php foreach($orders as $order): ?>
                <div class="orderHeader">Order ID: <?= $order->getId(); ?></div>
                <div class="order border border-2 rounded">
                    <div class="orderInfo">
                        <div><label>Phone:</label>
                            <div><?= $order->getPhone(); ?></div>
                        </div>
                        <div><label>Address:</label>
                            <div><?= $order->getAddress(); ?></div>
                        </div>
                        <div><label>Price:</label>
                            <div><?= $order->getPrice(); ?>$</div>
                        </div>
                        <div><label>Comment:</label>
                            <div><?= $order->getComment(); ?></div>
                        </div>
                    </div>
                    <div class="card-deck">
                        <?php foreach($order->getProducts() as $product): ?>
                            <hr style="height: 2px"/>
                            <div class="card text-center">
                                <img class="card-img-top" src="<?= $product->getProductPhoto(); ?>" alt="">
                                <div class="card-body">
                                    <p class="card-text text-muted"><?= $product->getProductCategoryName();?></p>
                                    <h5 class="card-title"><?= $product->getProductName();?></h5>
                                </div>
                                <div class="card_footer">
                                    <div><?= $product->getProductPrice();?>$ x <?= $product->getProductAmount();?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style>
    .main{
        display: flex;
        flex-direction: row;
        margin-left: 3%;
        margin-right: 3%;
    }
    .container{
        margin-top: 20px;
    }
    .svg-preloader{
        max-width: 7rem;
    }
    .order{
        margin-bottom: 80px;
        padding: 10px;
    }
    .orderHeader{
        font-size: 18px;
        font-weight: bold;
    }
    .orderInfo{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
        font-weight: normal;
        font-size: 16px;
    }
    .card-deck{
        display: grid;
        grid-template-rows: repeat(auto-fill, minmax(5px, 1fr));
        gap: 10px;
    }
    .card, .card a {
        display: flex;
        flex-direction: row;
        text-decoration: none;
        color:black;
        margin-bottom: 10px;
        height: 100px;
        border: none;
    }

    .card-img-top{
        max-height: 100%;
        max-width: 150px;
        object-fit: contain;
        max-font-size: 100%;
    }

    .text-muted {
        font-size: 15px;
    }

    .card_footer{
        font-weight: normal;
        background-color: white;
        max-height: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 10px;
        text-decoration: none;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-content: center;
    }
    .checkoutForm{
        margin-top: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        position: relative;
        max-width: 430px;
        width: 100%;
        max-height: fit-content;
        background: #ffffff;
        padding: 34px;
        border-radius: 6px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    .checkoutForm h2{
        position: relative;
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }
    .checkoutForm h2::before{
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 28px;
        border-radius: 12px;
        background: #4070f4;
    }
    .checkoutForm form .input-box{
        margin: 18px 0;
    }
    form .input-box textarea{
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    form .input-box input{
        height: 52px;
        width: 100%;
        outline: none;
        padding: 0 15px;
        font-size: 17px;
        font-weight: 400;
        color: #333;
        border: 1.5px solid #C7BEBE;
        border-bottom-width: 2.5px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .input-box input:focus,
    .input-box input:valid{
        border-color: #4070f4;
    }
    form .policy{
        display: flex;
        align-items: center;
    }
    form h3{
        color: #707070;
        font-size: 14px;
        font-weight: 500;
        margin-left: 10px;
    }
    .input-box.button input{
        color: #fff;
        letter-spacing: 1px;
        border: none;
        background: #4070f4;
        cursor: pointer;
    }
    .input-box.button input:hover{
        background: #0e4bf1;
    }
    form .text h3{
        color: #333;
        width: 100%;
        text-align: center;
    }
    form .text h3 a{
        color: #4070f4;
        text-decoration: none;
    }
    form .text h3 a:hover{
        text-decoration: underline;
    }
</style>