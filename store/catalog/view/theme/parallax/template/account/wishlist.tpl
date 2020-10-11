<?php echo $header; ?>

            <!-- breadcrumb area-->
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
            <!-- / breadcrumb area-->
            <!-- main -->
            <section class="main-page container">
                <div class="main-container col1-layout">
                    <div class="main">
                        <div class="col-main">
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
                            <!-- / Order History-->
                            <section class="wishlist-box oder-history">
                                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                                <div class="shopping-content">
                                        <div id="content" ><?php echo $content_top; ?>
      <?php if ($products) { ?>
      <div class="table-responsive">
        <table class="cart-table data-table">
          <thead>
            <tr>
              <th class="text-center"><?php echo $column_image; ?></th>
              <th class="text-left"><?php echo $column_name; ?></th>
              <th class="text-left"><?php echo $column_model; ?></th>
              <th class="text-right"><?php echo $column_stock; ?></th>
              <th class="text-right"><?php echo $column_price; ?></th>
              <th class="text-right"><?php echo $column_action; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-center"><?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                <?php } ?></td>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['stock']; ?></td>
              <td class="text-right"><?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
                  <?php } ?>
                </div>
                <?php } ?></td>
              <td class="text-right"><button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_cart; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></button>
                <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-times"></i></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
                                </div>
                            </section>
                            <!-- / Order History -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / main -->
<?php echo $footer; ?>