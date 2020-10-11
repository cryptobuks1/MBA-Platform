  <?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?>  
<!--  featured product -->
<section class="full-width-product-area padding-top">
    <div class="container">
        <!--  product title and icon -->
        <div class="product-top-ber">
            <h2 class="product-hadding"><span><?php echo $heading_title; ?></span></h2>
        </div>
        <div class="featured-prodcuts product-container">
             <?php foreach ($products as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                               <!-- <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
        </div>
    </div>
</section>
<!-- / featured product -->
<?php } ?>


<?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage2") { ?>  
<!--  our product -->
<div class="our-product-area">
    <!--  our product top bar -->
    <div class="product-top-ber">
        <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1ourpeocuttext_prallax; ?></span></h2>
    </div>
    <!-- / our product top bar -->
    <!-- our product box -->
    <div class="our-product-box medium-products">
        <ul class="nav nav-tabs tab-menu">
            <?php if($wg24themeoptionpanel_home1newproducttext_prallax!=''){ ?>
            <li class="active"><a data-toggle="tab" href="#catnew"><?php echo $wg24themeoptionpanel_home1newproducttext_prallax; ?></a></li>
            <?php } ?>
             <?php if($wg24themeoptionpanel_home1bestsaletext_prallax!=''){ ?>
            <li class=""><a data-toggle="tab" href="#catbest"><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?></a></li>
              <?php } ?>
             <?php if($wg24themeoptionpanel_home1Specialtext_prallax!=''){ ?>
            <li class=""><a data-toggle="tab" href="#catspecial"><?php echo $wg24themeoptionpanel_home1Specialtext_prallax; ?></a></li>
              <?php } ?>
        </ul>
        <div class="tab-contents">
            <div id="catnew" class="tab-pane  fade active in" role="tabpanel">
                <div class="our-products  product-container">
                       <?php foreach ($newproducts as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                 <!-- <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
                </div>
            </div>
            <div id="catbest" class="tab-pane  fade" role="tabpanel">
                <div class="our-products product-container">
                              <?php foreach ($bestsales as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                  <!--<button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
                </div>
            </div>
            <div id="catspecial" class="tab-pane  fade" role="tabpanel">
                <div class="our-products product-container">
                              <?php foreach ($specials as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                <!--  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--  / our product box -->
</div>
<!--  / our product -->
<?php  if($wg24themeoptionpanel_home2parrallaxtheme_prallax!='') { ?> 
<!--  add banner2 -->
<div class="add-banner2-box style-2 padding-top">
 <?php  echo  html_entity_decode($wg24themeoptionpanel_home2parrallaxtheme_prallax); ?>
</div>
<!--  / add banner2 -->
<?php } ?>

     <!--  featured product -->
<section class="full-width-product-area padding-top">
    <!--  product title and icon -->
    <div class="product-top-ber">
        <h2 class="product-hadding"><span><?php echo $heading_title; ?></span></h2>
    </div>
    <div class="featured-prodcuts2 product-container">
    <?php foreach ($products as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['quickview']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                <!--  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
    </div>
</section>
<!--  / featured product -->
<?php } ?>

<?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage3") { ?>  
    <!--  featured product -->
            <section class="full-width-product-area padding-top">
                <div class="container">
                    <!--  product title and icon -->
                    <div class="product-top-ber">
                        <h2 class="product-hadding"><span><?php echo $heading_title; ?></span></h2>
                    </div>
                    <div class="featured-prodcuts medium-products product-container">
                        <?php foreach ($products as $product) { ?>
            <!-- item -->
            <div class="item">
                <div class="product-details">
                    <div class="product-media">
                        <!--  product image  -->
                        <div class="product-img">
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                            <!--  hover box -->
                            <div class="hover-box">
                                <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                              <!--    <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                            </div>
                            <!-- / hover box -->
                        </div>
                        <!-- / product image -->
                        <!--  sale and new box -->
                        <div class="product-lable-box">
                    <?php if ($product['price'] && $product['special']) { ?>
                     <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                    <?php } ?> 
                       <?php foreach ($is_new as $isnew) { 
                         if($isnew['product_id']==$product['product_id']){ ?>
                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                      <?php } } ?>       
                        </div>
                        <!-- / sale and new box -->
                    </div>
                    <div class="line-color"></div>
                    <div class="product-content">
                        <div class="product-content-inner">
                            <div class="product-con-left">
                                <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                <div class="ratting-box">
                                      <div class="rating">
                                        <?php if ($product['rating']) { ?>
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($product['rating'] < $i) { ?>
                                                <span class="star-o"></span>
                                                <?php } else { ?>
                                                 <span class="star active"></span>
                                                <?php } ?>
                                                <?php } ?>
                                        <?php } else{ ?> 
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <span class="star-o"></span>
                                                <?php } ?>
                                        <?php } ?>
                                          </div>
                                </div>
                            </div>
                            <div class="product-con-right">
                                <div class="product-price">
                                    <?php if ($product['price']) { ?>
                                    <?php if (!$product['special']) { ?>
                                    <span class="new-price"> <?php echo $product['price']; ?></span>
                                    <?php } else { ?>
                                    <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- / item -->
        <?php } ?>
                    </div>
                    <!-- add-banner-2 -->
<?php  if($wg24themeoptionpanel_home2parrallaxtheme_prallax!='') { ?> 
<!--  add banner2 -->
<div class="add-banner2-box style-2 padding-top">
 <?php  echo  html_entity_decode($wg24themeoptionpanel_home2parrallaxtheme_prallax); ?>
</div>
<!--  / add banner2 -->
<?php } ?>
                    <!-- / add-banner-2 -->
                </div>
            </section>
            <!-- / featured product -->
<?php } ?>