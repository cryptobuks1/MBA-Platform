<?php echo $header; ?>
   <!--  breadcrumb -->
            <section class="breadcrumb-area padding-top-product">
                <div class="container">
                    <div class="breadcrumb breadcrumb-box">
                        <ul>
                            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                            <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- / breadcrumb -->
            <!--  login -->
            <section class="main-page container">
                <div class="main-container col1-layout">
                    <div class="main">
                        <div class="col-main">
                            <!--  login-->
                            <section class="account-login-area">
                                <div class="login-area">
                                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                                     <div id="content" ><?php echo $content_top; ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left" colspan="2"><?php echo $text_recurring_detail; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left" style="width: 50%;"><b><?php echo $text_order_recurring_id; ?></b> #<?php echo $order_recurring_id; ?><br />
                <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?><br />
                <b><?php echo $text_status; ?></b> <?php echo $status; ?><br />
                <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?></td>
              <td class="text-left" style="width: 50%;"><b><?php echo $text_order_id; ?></b> <a href="<?php echo $order; ?>">#<?php echo $order_id; ?></a><br />
                <b><?php echo $text_product; ?></b> <a href="<?php echo $product; ?>"><?php echo $product_name; ?></a><br />
                <b><?php echo $text_quantity; ?></b> <?php echo $product_quantity; ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $text_description; ?></td>
              <td class="text-left"><?php echo $text_reference; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left" style="width: 50%;"><?php echo $recurring_description; ?></td>
              <td class="text-left" style="width: 50%;"><?php echo $reference; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <h3><?php echo $text_transaction; ?></h3>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-left"><?php echo $column_type; ?></td>
              <td class="text-right"><?php echo $column_amount; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($transactions) { ?>
            <?php foreach ($transactions as $transaction) { ?>
            <tr>
              <td class="text-left"><?php echo $transaction['date_added']; ?></td>
              <td class="text-left"><?php echo $transaction['type']; ?></td>
              <td class="text-right"><?php echo $transaction['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td colspan="3" class="text-center"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php echo $recurring; ?><?php echo $content_bottom; ?></div>
                                </div>
                            </section>
                            <!-- / login -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / login -->

<?php echo $footer; ?>
