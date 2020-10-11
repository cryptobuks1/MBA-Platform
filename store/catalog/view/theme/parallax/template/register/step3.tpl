<div class="row">
    <aside class="col-lg-12">
        <div class="col-main">
            <div class="category-products">
                <div class="product-container">
                    <div id="products-grid" >
                        <ul class="products-grid row medium-products">
                            <?php foreach ($products as $product) { ?>
                                <!-- item -->
                                <li class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                    <div class="item">
                                        <div class="product-details">
                                            <div class="product-media">
                                                <div class="product-img">
                                                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                    <div class="hover-box">
                                                        
                                                    </div>
                                                </div>
                                                <div class="product-lable-box">
                                                    
                                                </div>
                                            </div>
                                            <div class="line-color"></div>
                                            <div class="product-content">
                                                <div class="product-content-inner">
                                                    <div class="product-con-left">
                                                        <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                        <div class="product-name"><span><?php echo $text_product_pv_value; ?> : <?php echo $product['pair_value']; ?></span></div>
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
                                </li>
                                <!-- / item -->
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
<div class="buttons">
    <div class="pull-right">
        <a href="<?php echo $change_package; ?>" class="btn btn-primary"><?php echo $text_change_package; ?></a>
        <input type="button" value="<?php echo $button_back; ?>" id="button-step3-back" class="btn btn-primary" />
        <input type="button" value="<?php echo $button_continue; ?>" id="button-step3-continue" data-loading-text="" class="btn btn-primary" />
    </div>
</div>
