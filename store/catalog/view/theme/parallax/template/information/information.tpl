<?php echo $header; ?>
    <!--  breadcrumb -->
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
            <section class="main-page container">
                <div class="main-container col2-left-layout">
                    <div class="main">
                        <div class="row">
                            <!--  left side -->
                            <div class="col-sm-4 col-md-3 col-lg-3">
                                <?php echo $column_left; ?>
                               
                            </div>
                            <!-- / left side-->
                            <div class="col-sm-8 col-md-9 col-lg-9">
                                <div class="col-main">
                                    <!--  my account Right side -->
                                    <section class="account-page">
                                        <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>

                                        <div class="account-form">
                                            <div class="account-form-inner">
                                                <div class="account-details-wrap">
                                                  <div id="content"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $description; ?><?php echo $content_bottom; ?></div>
                                                </div>
                                            </div>
                                        </div>

                                    </section>
                                    <!-- / my account Right side -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--  testimonial -->
<?php echo $footer; ?>