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
            <!--  category product -->
            <section class="main-page container">
                <div class="main-container col2-left-layout">
                    <div class="main" id="content">
                        <div class="row">
                            <!--  left side -->
                            <aside class="col-sm-4 col-md-3 col-lg-3 left-column">
                               <?php echo $column_left; ?>
                            </aside>
                            <!-- / left -->
                            <!-- Right side -->
                            <aside class=" col-sm-8 col-md-9 col-lg-9">
                                <div class="col-main">
            <div class="page-title">
            <span><?php echo $heading_title; ?></span>
        </div>
      
          <?php if ($categories) { ?>
                                    <!--  our product -->
                                    <div class="category-products">
                                        <div class="product-container">
                                           <p><strong><?php echo $text_index; ?></strong>
        <?php foreach ($categories as $category) { ?>
        &nbsp;&nbsp;&nbsp;<a href="index.php?route=product/manufacturer#<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
        <?php } ?>
      </p>
      <?php foreach ($categories as $category) { ?>
      <h2 id="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></h2>
      <?php if ($category['manufacturer']) { ?>
      <?php foreach (array_chunk($category['manufacturer'], 4) as $manufacturers) { ?>
      <div class="row">
        <?php foreach ($manufacturers as $manufacturer) { ?>
        <div class="col-sm-3"><a href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a></div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
                                        </div>
                                     
                                    </div>
                                    <!-- / our product -->
                                    
            <?php } else{ ?>
            <p><?php echo $text_empty; ?></p>
            <div class="buttons">
            <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-button gray9-bg white"><?php echo $button_continue; ?></a></div>
            </div>
            <?php } ?>
                                </div>
                            </aside>
                            <!-- / Right side -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / category product -->
<?php echo $footer; ?>