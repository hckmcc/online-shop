<?php require_once './static/html/header.html'; ?>
<div class="main">
<div class="container">
    <h3>Order items</h3>
    <div class="card-deck">
        <?php if(!is_null($productsInCart)): ?>
        <?php foreach($productsInCart as $product): ?>
            <div class="card text-center">
                <img class="card-img-top" src="<?= $product->getProductPhoto(); ?>" alt="">
                <div class="card-body">
                    <p class="card-text text-muted"><?= $product->getProductCategoryName();?></p>
                    <h5 class="card-title"><?= $product->getProductName();?></h5>
                </div>
                <div class="card_footer">
                    <label>Price:</label>
                    <div><?= $product->getProductPrice();?>$</div>
                    <label>Quantity:</label>
                    <div><?= $product->getProductAmount();?>pcs</div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="checkoutForm">
    <h2>Checkout</h2>
    <form action="/order" method="POST">
        <div class="input-box">
            <label style="color: red"><?php if (isset($errors['name'])){print_r($errors['name']);};?></label>
            <input type="text" placeholder="Enter your name" name="name" required>
        </div>
        <div class="input-box">
            <label style="color: red"><?php if (isset($errors['phone'])){print_r($errors['phone']);};?></label>
            <input type="text" placeholder="Enter your phone" name="phone" required>
        </div>
        <div class="input-box">
            <label style="color: red"><?php if (isset($errors['address'])){print_r($errors['address']);};?></label>
            <input type="text" placeholder="Enter your address" name="address" required>
        </div>
        <div class="input-box">
            <textarea placeholder="Enter your comment" name="comment"></textarea>
        </div>
        <div class="orderInfo">
            <p>Total price:</p>
            <p><?php print_r($totalPrice) ?>$</p>
        </div>
        <div class="input-box button">
            <input type="Submit" value="Place the order">
        </div>
    </form>
</div>
</div>
<style>
    .main{
        display: flex;
        flex-direction: row;
        margin-left: 8%;
        margin-right: 3%;
    }
    .container{
        margin-top: 20px;
    }
    .card-deck{
        display: grid;
        grid-template-rows: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
    }
    .card, .card a {
        display: flex;
        flex-direction: row;
        text-decoration: none;
        color:black;
        margin-bottom: 10px;
        height: 150px;
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
        font-size: 18px;
        background-color: white;
        max-height: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 10px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card_footer label{
        font-weight: bold;
        font-size: 18px;
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
    .orderInfo{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-weight: bold;
        font-size: 18px;
    }
</style>