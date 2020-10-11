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
                                                   <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
   
      <div class="row">
        <div class="col-sm-6">
          <ul>
            <?php foreach ($categories as $category_1) { ?>
            <li><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
              <?php if ($category_1['children']) { ?>
              <ul>
                <?php foreach ($category_1['children'] as $category_2) { ?>
                <li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?></a>
                  <?php if ($category_2['children']) { ?>
                  <ul>
                    <?php foreach ($category_2['children'] as $category_3) { ?>
                    <li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-sm-6">
          <ul>
            <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
              <ul>
                <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
                <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
                <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
                <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
                <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
            <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
            <li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
            <li><?php echo $text_information; ?>
              <ul>
                <?php foreach ($informations as $information) { ?>
                <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
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

