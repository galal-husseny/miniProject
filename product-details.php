<?php include_once "header.php" ?>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area bg-image-3 ptb-150">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h3>SINGLE PRODUCT</h3>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Single Product</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->
<!-- Product Deatils Area Start -->
<?php
if (isset($_GET['pro'])) {
    include_once "Product.php";
    $pro = new Product();
    $pro->setId($_GET['pro']);
    $result = $pro->getSingleProduct();
    if (!empty($result)) {
        $product = $result->fetch_object();
?>
        <div class="product-details pt-100 pb-95">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-img">
                            <img class="zoompro" src="assets/img/product/<?php echo $product->photo ?>" data-zoom-image="assets/img/product-details/product-detalis-bl1.jpg" alt="zoom" />
                            <div id="gallery" class="mt-20 product-dec-slider owl-carousel">

                                <a>
                                    <img src="assets/img/product/<?php echo $product->photo ?>" alt="">
                                </a>

                            </div>
                            <!-- <span>-29%</span> -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-content">
                            <h4><?php echo $product->name; ?></h4>
                            <div class="rating-review">
                                <div class="pro-dec-rating">
                                    <?php for ($i = 0; $i < $product->rating_avg; $i++) { ?>
                                        <i class="ion-android-star-outline theme-star"></i>

                                    <?php } ?>
                                    <?php for ($i = 0; $i < 5 - $product->rating_avg; $i++) { ?>
                                        <i class="ion-star theme-color"></i>

                                    <?php } ?>

                                    

                                </div>
                                <div class="pro-dec-review">
                                    <ul>
                                        <li><?php echo $product->rating_count ?> Reviews </li>
                                        <!-- <li> Add Your Reviews</li> -->
                                    </ul>
                                </div>
                            </div>
                            <span><?php echo $product->price ?> EGP</span>
                            <div class="in-stock">
                                <p>Available: <span>In stock</span></p>
                            </div>
                            <p><?php
                                $wordsCount = 20;
                                $detailsArray = str_word_count($product->details, 1);
                                array_splice($detailsArray, $wordsCount, count($detailsArray));
                                $detailsString = implode(" ", $detailsArray);
                                echo $detailsString . '...';

                                ?></p>
                            <div class="pro-dec-feature">
                                <ul>
                                    <li><input type="checkbox"> Protection Plan: <span> 2 year $4.99</span></li>
                                    <li><input type="checkbox"> Remote Holder: <span> $9.99</span></li>
                                    <li><input type="checkbox"> Koral Alexa Voice Remote Case: <span> Red $16.99</span></li>
                                    <li><input type="checkbox"> Amazon Basics HD Antenna: <span>25 Mile $14.99</span></li>
                                </ul>
                            </div>
                            <div class="quality-add-to-cart">
                                <div class="quality">
                                    <label>Qty:</label>
                                    <input class="cart-plus-minus-box" type="text" name="qtybutton" value="02">
                                </div>
                                <div class="shop-list-cart-wishlist">
                                    <a title="Add To Cart" href="#">
                                        <i class="icon-handbag"></i>
                                    </a>
                                    <a title="Wishlist" href="#">
                                        <i class="icon-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="pro-dec-categories">
                                <ul>
                                    <li class="categories-title">Categories:</li>
                                    <li><a href="#">Green,</a></li>
                                    <li><a href="#">Herbal, </a></li>
                                    <li><a href="#">Loose,</a></li>
                                    <li><a href="#">Mate,</a></li>
                                    <li><a href="#">Organic </a></li>
                                </ul>
                            </div>
                            <div class="pro-dec-categories">
                                <ul>
                                    <li class="categories-title">Tags: </li>
                                    <li><a href="#"> Oolong, </a></li>
                                    <li><a href="#"> Pu'erh,</a></li>
                                    <li><a href="#"> Dark,</a></li>
                                    <li><a href="#"> Special </a></li>
                                </ul>
                            </div>
                            <div class="pro-dec-social">
                                <ul>
                                    <li><a class="tweet" href="#"><i class="ion-social-twitter"></i> Tweet</a></li>
                                    <li><a class="share" href="#"><i class="ion-social-facebook"></i> Share</a></li>
                                    <li><a class="google" href="#"><i class="ion-social-googleplus-outline"></i> Google+</a></li>
                                    <li><a class="pinterest" href="#"><i class="ion-social-pinterest"></i> Pinterest</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Deatils Area End -->
        <div class="description-review-area pb-70">
            <div class="container">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav text-center">
                        <a class="active" data-toggle="tab" href="#des-details1">Description</a>
                        <a data-toggle="tab" href="#des-details2">Tags</a>
                        <a data-toggle="tab" href="#des-details3">Review</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details1" class="tab-pane active">
                            <div class="product-description-wrapper">
                                <p><?php echo $product->details ?></p>
                            </div>
                        </div>
                        <div id="des-details2" class="tab-pane">
                            <div class="product-anotherinfo-wrapper">
                                <ul>
                                    <li><span>Tags:</span></li>
                                    <li><a href="#"> Green,</a></li>
                                    <li><a href="#"> Herbal,</a></li>
                                    <li><a href="#"> Loose,</a></li>
                                    <li><a href="#"> Mate,</a></li>
                                    <li><a href="#"> Organic ,</a></li>
                                    <li><a href="#"> special</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="rattings-wrapper">
                                <?php
                                $reviews = new Product();
                                $reviews->setId($_GET['pro']);
                                $result2 = $reviews->getReviewsByProduct();
                                if (!empty($result2)) {
                                    $rates = $result2->fetch_all(MYSQLI_ASSOC);
                                    foreach ($rates as $key => $value) {
                                ?>
                                        <div class="rattings-wrapper">
                                            <div class="sin-rattings">
                                                <div class="star-author-all">
                                                    <div class="ratting-star f-left">
                                                        <?php for ($i = 0; $i < $value['value']; $i++) { ?>
                                                            <i class="ion-star theme-color"></i>
                                                        <?php } ?>
                                                        <?php for ($i = 0; $i < 5 - $value['value']; $i++) { ?>
                                                            <i class="ion-android-star-outline theme-star"></i>
                                                        <?php } ?>

                                                        <span>(<?php echo $value['value']; ?>)</span>
                                                    </div>
                                                    <div class="ratting-author f-right">
                                                        <h3><?php echo $value['name']; ?></h3>
                                                        <!-- <span>12:24</span>
                                                    <span>9 March 2018</span> -->
                                                    </div>
                                                </div>
                                                <p><?php echo $value['comment'] ?></p>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="alert alert-warning">
                                        No Reviews Yet.
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="ratting-form-wrapper">
                                <h3>Add your Comments :</h3>
                                <div class="ratting-form">
                                    <form action="#">
                                        <div class="star-box">
                                            <h2>Rating:</h2>
                                            <div class="ratting-star">
                                                <i class="ion-star theme-color"></i>
                                                <i class="ion-star theme-color"></i>
                                                <i class="ion-star theme-color"></i>
                                                <i class="ion-star theme-color"></i>
                                                <i class="ion-star"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-20">
                                                    <input placeholder="Name" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="rating-form-style mb-20">
                                                    <input placeholder="Email" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="rating-form-style form-submit">
                                                    <textarea name="message" placeholder="Message"></textarea>
                                                    <input type="submit" value="add review">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-area pb-100">
            <div class="container">
                <div class="product-top-bar section-border mb-35">
                    <div class="section-title-wrap">
                        <h3 class="section-title section-bg-white">Related Products</h3>
                    </div>
                </div>
                <div class="featured-product-active hot-flower owl-carousel product-nav">
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img alt="" src="assets/img/product/product-1.jpg">
                            </a>
                            <span>-30%</span>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">Le Bongai Tea</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>$100.00 -</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img alt="" src="assets/img/product/product-2.jpg">
                            </a>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">Society Ice Tea</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>$100.00 -</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img alt="" src="assets/img/product/product-3.jpg">
                            </a>
                            <span>-30%</span>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">Green Tea Tulsi</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>$100.00 -</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img alt="" src="assets/img/product/product-4.jpg">
                            </a>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">Best Friends Tea</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>$100.00 -</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img alt="" src="assets/img/product/product-5.jpg">
                            </a>
                            <span>-30%</span>
                            <div class="product-action">
                                <a class="action-wishlist" href="#" title="Wishlist">
                                    <i class="ion-android-favorite-outline"></i>
                                </a>
                                <a class="action-cart" href="#" title="Add To Cart">
                                    <i class="ion-ios-shuffle-strong"></i>
                                </a>
                                <a class="action-compare" href="#" data-target="#exampleModal" data-toggle="modal" title="Quick View">
                                    <i class="ion-ios-search-strong"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-content text-left">
                            <div class="product-hover-style">
                                <div class="product-title">
                                    <h4>
                                        <a href="product-details.html">Instant Tea Premix</a>
                                    </h4>
                                </div>
                                <div class="cart-hover">
                                    <h4><a href="product-details.html">+ Add to cart</a></h4>
                                </div>
                            </div>
                            <div class="product-price-wrapper">
                                <span>$100.00 -</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        header('Location:404.php');
    }
} else {
    header('Location:404.php');
}

?>

<?php include_once "footer.php" ?>