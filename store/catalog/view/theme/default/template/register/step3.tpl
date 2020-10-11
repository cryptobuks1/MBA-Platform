<?php foreach ($products as $product) { ?>
<div class="row">
    <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
                <div class="caption">
                    <h4 style="text-align: center;"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                    <p><?php echo $product['description']; ?></p>
                    <?php if ($product['price']) { ?>
                    <p class="price">
                        <?php if (!$product['special']) { ?>
                        <?php echo $product['price']; ?>
                        <?php } else { ?>
                        <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                        <?php } ?>
                        <?php if ($product['tax']) { ?>
                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                        <?php } ?>
                        <span><?php echo $text_product_pv_value; ?> : <?php echo $product['pair_value']; ?></span>
                    </p>
                    <?php } ?>
                    <div>

                    </div>
                    <?php if ($product['rating']) { ?>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <?php if ($product['rating'] < $i) { ?>
                        <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } else { ?>
                        <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="button-group text-center">
                    <?php if ($registration_pack == $product['product_id']) { ?>
                    <button disabled type="button" id="" style="cursor: no-drop;float: none;width: 100%;" ><i class="fa fa-check-square-o"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart_added; ?></span></button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a style="margin-top: 230px;margin-left: 50px;" id="" href="<?php echo $change_package; ?>" class="btn btn-primary"><?php echo $text_change_package; ?></a>
    </div>
    <?php } ?>
</div>
<div class="button clearfix">
    <div class="pull-right">
        <button id="button-step3-back" class="btn btn-default" type="button"><?php echo $button_back; ?></button>
        <button id="button-step3-continue" class="btn btn-primary" type="button"><?php echo $button_continue; ?></button>
    </div>
</div>