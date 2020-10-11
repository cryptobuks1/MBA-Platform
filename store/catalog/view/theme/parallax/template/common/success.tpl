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
                                       <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>

      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
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