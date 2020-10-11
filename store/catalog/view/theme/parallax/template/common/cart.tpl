  <div class="block-cart" id="cart">
    <button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="dropdown-toggle"><span class="fa fa-shopping-bag"></span><span id="cart-total" class="cart-top-title"><?php echo $text_items; ?></span></button>
    <!-- hidden product-->
    <ul class="cart-product-list sfmenuffect">
        <?php if ($products || $vouchers) { ?>
        <?php foreach ($products as $product) { ?>
        <li class="item cart-item">
            <?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
            <?php } ?>
            <div class="product-details">
                <div class="product-details-inner">
                    <h4 class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                    <a  class="remove" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>"><span class="fa fa-remove"></span></a>
                    <?php if ($product['option']) { ?>
                    <div class="ratting-box"> 
                        <?php foreach ($product['option'] as $option) { ?>
                        - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                        <?php } ?>
                        <?php } ?>
                        <?php if ($product['recurring']) { ?>
                        <br />
                        - <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
                    </div>
                    <?php } ?>

                    <div class="product-price">
                        <span class="new-price"> <?php echo $product['quantity']; ?> X<?php echo $product['total']; ?></span>
                    </div>
                </div>
            </div>
        </li>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <li>
        <td class="text-center"></td>
        <td class="text-left"><?php echo $voucher['description']; ?></td>
        <td class="text-right">x&nbsp;1</td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
        <td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </li>
        <?php } ?>
        <li class="item cart-item">
            <div class="top-subtotal">
                <?php foreach ($totals as $total) { ?>
                <div class="sub-total">
                    <label><?php echo $total['title']; ?></label><span><?php echo $total['text']; ?></span>
                </div>
                <?php } ?>
                <div class="buttons">
                    <div class="float-right">
                        <a class="btn btn-button gray9-bg white" href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a>
                        <a class="btn btn-button tomato-bg white" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
                    </div>
                </div>
            </div>
        </li>
        <?php } else { ?>
        <li class="item cart-item">
            <p class="text-center"><?php echo $text_empty; ?></p>
        </li>
        <?php } ?>
    </ul>
    <!-- / hidden product-->
</div>




