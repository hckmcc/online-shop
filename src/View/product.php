<?php require_once './static/html/header.html';
if($productOrdered){
    $reviewVisible = 'd-block';
}else{
    $reviewVisible = 'd-none';
}
if(empty($reviews)){
    $reviewsEmpty='d-block';
}else{
    $reviewsEmpty='d-none';
}
?>
<div class="pd-wrap">
    <div class="container">
        <div class="heading-section">
            <h2><?= $product->getName(); ?></h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="item">
                    <img class ="product-image" src="<?= $product->getPhoto(); ?>"  alt=""/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-dtl">
                    <div class="product-info">
                        <div class="reviews-counter">
                            <div class="rate">
                                <span>Average rating: <?= $meanRating ?> </span>
                            </div>
                            <span><?= $reviewsCount ?> Reviews</span>
                        </div>
                        <div class="product-price-discount"><span><?= $product->getPrice();?>$</span></div>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="product-count">
                        <form action="/add_product" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product->getId();?>">
                            <label>
                                <input type="number" name="amount" value="1" min="1" max="10" >
                            </label>
                            <input type="Submit" value="Add to cart">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-heading">REVIEWS</div>
        <div class="<?php echo $reviewVisible ?> product-info-tabs">
            <form class="review-form" action="/product?id=<?= $product->getId();?>" method="POST">
                <div class="form-group">
                    <label>Your rating</label>
                    <div class="reviews-counter">
                        <div class="rate">
                            <label for="star5" title="text"></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="text">1 star</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Your message</label>
                    <textarea class="form-control" name="review_text" rows="7"></textarea>
                </div>
                <input type="hidden" name="product_id" value="<?= $product->getId();?>">
                <input type="Submit" value="Submit review">
            </form>
        </div>
        <div>
            <p class="mb-20 <?php echo $reviewsEmpty?>">There are no reviews yet.</p>
            <?php if(!empty($reviews)): ?>
                <?php foreach($reviews as $review): ?>
                <div class="review-block">

                </div>
                    <hr style="height: 2px"/>
                    <div class="card text-center">
                        <div class="card-body">
                            <p class="card-text"><?= $review->getText();?></p>
                        </div>
                        <div class="card_footer">
                            <div><?= $review->getUserName();?></div>
                            <div>Rating: <?= $review->getRating();?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>

<style>
    .card, .card a {
        display: flex;
        flex-direction: row;
        text-decoration: none;
        color:black;
        margin-bottom: 10px;
        height: 100px;
        border: none;
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
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: space-between;
        align-content: center;
    }
    .review-block{
        display: grid;
        grid-template-rows: repeat(auto-fill, minmax(5px, 1fr));
        gap: 10px;
    }
    .container{
        margin-top: 20px;
    }
    .pd-wrap {
        padding: 40px 0;
        font-family: 'Poppins', sans-serif;
    }
    .heading-section {
        text-align: center;
        margin-bottom: 20px;
    }
    .sub-heading {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
        display: block;
        font-weight: 600;
        color: #2e9ca1;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    .heading-section h2 {
        font-size: 32px;
        font-weight: 500;
        padding-top: 10px;
        padding-bottom: 15px;
        font-family: 'Poppins', sans-serif;
    }
    .user-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: relative;
        min-width: 80px;
        background-size: 100%;
    }
    .item {
        padding: 0 10px;
    }
    .product-image{
        width: 100%;
        height: 200px;
        object-fit: contain;
        max-font-size: 100%;
    }
    .quote {
        position: absolute;
        top: -23px;
        color: #2e9da1;
        font-size: 27px;
    }
    .name {
        margin-bottom: 0;
        line-height: 14px;
        font-size: 17px;
        font-weight: 500;
    }
    .position {
        color: #adadad;
        font-size: 14px;
    }
    .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        outline: none;
        height: 25px;
    }
    .owl-nav button svg {
        width: 25px;
        height: 25px;
    }
    .owl-nav button.owl-prev {
        left: 25px;
    }
    .owl-nav button.owl-next {
        right: 25px;
    }
    .owl-nav button span {
        font-size: 45px;
    }
    .product-thumb .item img {
        height: 100px;
    }
    .product-name {
        font-size: 22px;
        font-weight: 500;
        line-height: 22px;
        margin-bottom: 4px;
    }
    .product-price-discount {
        font-size: 22px;
        font-weight: 400;
        padding: 10px 0;
        clear: both;
    }
    .product-price-discount span.line-through {
        text-decoration: line-through;
        margin-left: 10px;
        font-size: 14px;
        vertical-align: middle;
        color: #a5a5a5;
    }
    .display-flex {
        display: flex;
    }
    .align-center {
        align-items: center;
    }
    .product-info {
        width: 100%;
    }
    .reviews-counter {
        font-size: 13px;
    }
    .reviews-counter span {
        vertical-align: -2px;
    }
    .rate {
        float: left;
        padding: 0 10px 0 0;
    }
    .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float: right;
        width: 15px;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 21px;
        color:#ccc;
        margin-bottom: 0;
        line-height: 21px;
    }
    .rate:not(:checked) > label:before {
        content: '\2605';
    }
    .rate > input:checked ~ label {
        color: #ffc700;
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
    .product-dtl p {
        font-size: 14px;
        line-height: 24px;
        color: #7a7a7a;
    }
    .product-dtl .form-control {
        font-size: 15px;
    }
    .product-dtl label {
        line-height: 16px;
        font-size: 15px;
    }
    .form-control:focus {
        outline: none;
        box-shadow: none;
    }
    .product-count {
        margin-top: 15px;
    }
    .round-black-btn {
        border-radius: 4px;
        background: #212529;
        color: #fff;
        padding: 7px 45px;
        display: inline-block;
        margin-top: 20px;
        border: solid 2px #212529;
        transition: all 0.5s ease-in-out 0s;
    }
    .round-black-btn:hover,
    .round-black-btn:focus {
        background: transparent;
        color: #212529;
        text-decoration: none;
    }

    .product-info-tabs {
        margin-top: 50px;
    }
    .product-info-tabs .nav-tabs {
        border-bottom: 2px solid #d8d8d8;
    }
    .product-info-tabs .nav-tabs .nav-item {
        margin-bottom: 0;
    }
    .product-info-tabs .nav-tabs .nav-link {
        border: none;
        border-bottom: 2px solid transparent;
        color: #323232;
    }
    .product-info-tabs .nav-tabs .nav-item .nav-link:hover {
        border: none;
    }
    .product-info-tabs .nav-tabs .nav-item.show .nav-link,
    .product-info-tabs .nav-tabs .nav-link.active,
    .product-info-tabs .nav-tabs .nav-link.active:hover {
        border: none;
        border-bottom: 2px solid #d8d8d8;
        font-weight: bold;
    }
    .product-info-tabs .tab-content .tab-pane {
        padding: 30px 20px;
        font-size: 15px;
        line-height: 24px;
        color: #7a7a7a;
    }
    .review-form .form-group {
        clear: both;
    }
    .mb-20 {
        margin-bottom: 20px;
    }

    .review-form .rate {
        float: none;
        display: inline-block;
    }
    .review-heading {
        font-size: 24px;
        font-weight: 600;
        line-height: 24px;
        margin-bottom: 6px;
        text-transform: uppercase;
        color: #000;
    }
    .review-form .form-control {
        font-size: 14px;
    }
    .review-form input.form-control {
        height: 40px;
    }
    .review-form textarea.form-control {
        resize: none;
    }
    .review-form .round-black-btn {
        text-transform: uppercase;
        cursor: pointer;
    }
</style>
