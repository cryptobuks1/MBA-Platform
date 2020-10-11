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
                          <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
                        <div class="col-main">
                            <!--  login-->
                            <section class="account-login-area">
                                <div class="login-area">
                                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                                      <div id="content" ><?php echo $content_top; ?>
      <div class="title-box padding-top-product">
            <span class="sub-title "><?php echo $text_my_account; ?></span>
        </div>
      <ul class="list-unstyled">
        <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>

                
                    <li><a href="<?php echo $backoffice_url; ?>" target="_blank"><?php echo $text_access_my_backoffice; ?></a></li>
                
            
        <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      </ul>
      <?php if ($credit_cards) { ?>
        <div class="title-box padding-top-product">
            <span class="sub-title "><?php echo $text_credit_card; ?></span>
        </div>
      <ul class="list-unstyled">
        <?php foreach ($credit_cards as $credit_card) { ?>
        <li><a href="<?php echo $credit_card['href']; ?>"><?php echo $credit_card['name']; ?></a></li>
        <?php } ?>
      </ul>
      <?php } ?>
        <div class="title-box padding-top-product">
            <span class="sub-title "><?php echo $text_my_orders; ?></span>
        </div>
      <ul class="list-unstyled">
        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        <?php if ($reward) { ?>
        <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
        <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      </ul>
       <div class="title-box padding-top-product">
            <span class="sub-title "><?php echo $text_my_newsletter; ?></span>
        </div>
      <ul class="list-unstyled">
        <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
      </ul>
      <?php echo $content_bottom; ?></div>
                                </div>
                            </section>
                            <!-- / login -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / login -->

<?php echo $footer; ?> 