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
    <div class="main-container col1-layout">
        <div class="main">
            <div class="col-main" id="content">
                <!-- start shopping cart area-->
                <section class="shopping-cart">
                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                 
                    <div class="shopping-content">
                        <div id="content" >
      <p><?php echo $text_error; ?></p>
      <div class=" clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
                    </div>
                
                </section>
                <!-- / shopping cart area-->
            </div>
        </div>
    </div>
</section>
<!-- / shopping-cart -->
<?php echo $footer; ?>

