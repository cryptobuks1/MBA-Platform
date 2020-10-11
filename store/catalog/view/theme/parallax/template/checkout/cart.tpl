<?php echo $header; ?>
<!-- start breadcrumb -->
<section class="breadcrumb-area padding-top-product">
    <div class="container">
        <div class="breadcrumb breadcrumb-box">
            <ul>
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></span></span></a></li>
                <?php } ?>

            </ul>
        </div>
    </div>
</section>
<!-- / breadcrumb -->
<!-- shopping-cart -->
<section class="main-page container">
    <?php if ($attention) { ?>
    <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="main-container col1-layout">
        <div class="main">
            <div class="col-main" id="content">
                <!-- start shopping cart area-->
                <section class="shopping-cart">
                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                    <?php if ($weight) { ?>
                    <p> &nbsp;(<?php echo $weight; ?>)</p>
                    <?php } ?>
                    <div class="shopping-content">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="table-responsive">
                                <table class="cart-table data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo $column_image; ?></th>
                                            <th class="text-left"><?php echo $column_name; ?></th>
                                            <th class="text-left"><?php echo $column_model; ?></th>
                                            <th class="text-left"><?php echo $column_quantity; ?></th>
                                            <th class="text-right"><?php echo $column_price; ?></th>
                                            <th class="text-right"><?php echo $column_total; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $id=1;foreach ($products as $product) { ?>
                                        <tr>
                                            <td class="text-center"><?php if ($product['thumb']) { ?>
                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
                                                <?php } ?></td>
                                            <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                                <?php if (!$product['stock']) { ?>
                                                <span class="text-danger">***</span>
                                                <?php } ?>
                                                <?php if ($product['option']) { ?>
                                                <?php foreach ($product['option'] as $option) { ?>
                                                <br />
                                                <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                                                <?php } ?>
                                                <?php } ?>
                                                <?php if ($product['reward']) { ?>
                                                <br />
                                                <small><?php echo $product['reward']; ?></small>
                                                <?php } ?>
                                                <?php if ($product['recurring']) { ?>
                                                <br />
                                                <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                                                <?php } ?></td>
                                            <td class="text-left"><?php echo $product['model']; ?></td>
                                            <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">

                                                    <span class="input-group-btn">
                                                        <button data-toggle="tooltip" title="<?php echo $button_update; ?>" type="submit" >
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                        <button onclick="cart.remove('<?php echo $product['cart_id']; ?>');"  type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </span>
                                                    <div class="qty-area">
                                                        <div class="input-content">
                                                            <div class="box-qty">
                                                                <input type="text" id="input-quantity<?php echo $id; ?>" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="input-text qty" />
                                                                <div class="qty-arrows" style="margin-top: -40px;">
                                                                    <input type="button" value="+" onclick="var qty_el = document.getElementById('input-quantity<?php echo $id; ?>');
                                                                                        var qty = qty_el.value;
                                                                                        if (!isNaN(qty))
                                                                                        qty_el.value++;
                                                                                        return false;" class="qty-increase">
                                                                    <input type="button" value="-" onclick="var qty_el = document.getElementById('input-quantity<?php echo $id; ?>');
                                                                                        var qty = qty_el.value;
                                                                                        if (!isNaN(qty) && qty > 1 )
                                                                                        qty_el.value--;
                                                                                        return false;" class="qty-decrease">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div></td>
                                            <td class="text-right"><?php echo $product['price']; ?></td>
                                            <td class="text-right"><?php echo $product['total']; ?></td>
                                        </tr>
                                        <?php $id=$id+1; } ?>
                                        <?php foreach ($vouchers as $voucher) { ?>
                                        <tr>
                                            <td></td>
                                            <td class="text-left"><?php echo $voucher['description']; ?></td>
                                            <td class="text-left"></td>
                                            <td class="text-left"><div class="input-group btn-block" style="max-width: 200px;">
                                                    <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i class="fa fa-times-circle"></i></button>
                                                    </span></div></td>
                                            <td class="text-right"><?php echo $voucher['amount']; ?></td>
                                            <td class="text-right"><?php echo $voucher['amount']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="buttons">
                            <div class="float-right">
                                <a class="btn btn-button gray9-bg white" href="<?php echo $continue; ?>"><?php echo $button_shopping; ?></a>
                                <a class="btn btn-button tomato-bg white" href="<?php echo $checkout; ?>"><?php echo $button_checkout; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="estimate-ship-tax">
                        <div class="estimate-ship-tax-inner">
                            <div class="row">
                                <!-- Estimate -->
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <?php if ($modules) { ?>
                                   <!--<h2><?php echo $text_next; ?></h2>
                                    <p><?php echo $text_next_choice; ?></p>-->
                                    <div class="panel-group" id="accordion">
                                        <?php foreach ($modules as $module) { ?>
                                        <?php echo $module; ?>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <!--  total  -->
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="cart-shopping-total">
                                        <table class="table table-bordered">
                                            <thead>
                                                <?php foreach ($totals as $total) { ?>       
                                                <tr>
                                                    <th>
                                            <div class="pull-right">
                                                <div class="cart-sub-total">
                                                    <?php echo $total['title']; ?>:<span class="inner-left-md"><?php echo $total['text']; ?></span>
                                                </div>
                                            </div>
                                            </th>
                                            </tr>
                                            <?php } ?>  
                                            </thead>
                                            <!-- /thead -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="pull-right">
                                                            <a href="<?php echo $checkout; ?>" class="btn btn-button gray9-bg white checkout"><?php echo $button_checkout; ?></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!-- /tbody -->
                                        </table>
                                        <!-- /table -->
                                    </div>
                                </div>
                                <!-- / total  -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- / shopping cart area-->
            </div>
        </div>
    </div>
</section>
<!-- / shopping-cart -->
<?php echo $footer; ?>
