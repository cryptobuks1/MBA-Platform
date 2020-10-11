<?php echo $header; ?>
<style>
    @media (min-width: 992px) {
        .col2-left-layout .category-products .products-grid li:nth-child(3n+1) {
            clear: none;
        }
    }
</style>
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
                            <!-- Right side -->
                            <aside class="col-lg-12">
                                <div class="col-main">
                                    <!--  category big banner -->
                                    <?php if ($thumb || $description) { ?>
                                      <section class="category-big-banner ">
                                       <div class="category-big-banner-box">
                                           <div class="category-big-banner-img">
                                               <?php if ($thumb) { ?>
                                                   <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>"  />
                                               <?php } ?>
                                           </div>
                                       </div>
                                    <?php if ($description) { ?>
                                    <div class="catdes"><?php echo $description; ?></div>
                                    <?php } ?>
                                    </section>
                                    <?php } ?>
          <?php if($wg24themeoptionpanel_c_sub_categor_prallax=="show"){ ?>                          
                                    <!--  category big banner -->
                                      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 5) { ?>
      <div class="row">
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { ?>
      <div class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
     <?php } ?> 
         <?php if ($products) { ?>
         <a href="<?php echo $compare; ?>" id="compare-total" class="btn btn-link"><?php echo $text_compare; ?></a>
                                    <!--  our product -->
                                    <div class="category-products">
                                        <!--toolbar-->
                                        <div class="toolbar">
                                            <div class="sorter">
                                                <p class="view-mode">
                                                    <label>View as:</label>
                                                    <a title="<?php echo $button_grid; ?>" id="gridview" class="active"><i class="fa fa-th-large"></i><span><?php echo $button_grid; ?></span></a>
                                                    <a title="<?php echo $button_list; ?>" id="listview"><i class="fa fa-th-list"></i><span><?php echo $button_list; ?></span></a>
                                                </p>
                                                <div class="sort-by">
                                                    <select id="input-sort" class="select selector1 form-control" onchange="location = this.value;">
                                                           <option> <?php echo $text_sort; ?></option>
                                                       <?php foreach ($sorts as $sorts) { ?>
                                                      <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                                      <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                                                      <?php } else { ?>
                                                      <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                                      <?php } ?>
                                                      <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="limiter">
                                                    <select id="input-limit" class="select selector1 form-control" onchange="location = this.value;">
                                                    <?php foreach ($limits as $limits) { ?>
                                                    <?php if ($limits['value'] == $limit) { ?>
                                                    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="pager pager-area">
                                                    <p class="amount"><?php echo $results; ?></p>
                                                    <div class="pagination pages" id="pagination">
                                                        <?php echo $pagination; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- toolbar -->
                                        <div class="product-container">
                                            <div id="products-grid" >
                                               
                                                     <?php foreach ($products as $product) { ?>
                                                      <ul class="products-grid row medium-products">
                                                    <!-- item -->
                                                            <li class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                                <div class="item">
                                                                   <div class="product-details">
                                                            <div class="product-media">
                                                            <!--  product image  -->
                                                            <div class="product-img">
                                                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                            <!--  hover box -->
                                                            <div class="hover-box">
                                                            <?php if ($registration_pack == $product['product_id']) { ?>
                                                                <button id="cart_add_<?php echo $product['product_id']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" ><i class="fa fa-check-square-o"></i><span><?php echo $button_cart_added; ?></span></button>
                                                            <?php }else { ?>
                                                                <button id="cart_add_<?php echo $product['product_id']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                            <?php } ?>
                                                            <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                            <!--  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>-->
                                                            </div>
                                                            <!-- / hover box -->
                                                            </div>
                                                            <!-- / product image -->
                                                            <!--  sale and new box -->
                                                            <div class="product-lable-box">
                                                            <?php if ($product['price'] && $product['special']) { ?>
                                                            <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                                            <?php } ?> 
                                                            <?php foreach ($is_new as $isnew) { 
                                                            if($isnew['product_id']==$product['product_id']){ ?>
                                                            <div class="lable-new"><?php echo $wg24themeoptionpanel_newtext_prallax; ?></div>
                                                            <?php } } ?>       
                                                            </div>
                                                            <!-- / sale and new box -->
                                                            </div>
                                                            <div class="line-color"></div>
                                                            <div class="product-content">
                                                            <div class="product-content-inner">
                                                            <div class="product-con-left">
                                                            <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                            <div class="product-name"><span><?php echo $text_product_pv_value; ?> : <?php echo $product['pair_value']; ?></span></div>
                                                            <div class="ratting-box">
                                                            <div class="rating">
                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>
                                                            </div>
                                                            <div class="product-con-right">
                                                            <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                            </div>

                                                            </div>

                                                            </div>
                                                            </div>
                                                                </div>
                                                            </li>
                                                             <li class="col-xs-12 col-sm-8">
                                                                 <div style="margin-top:60px !important;">
                                                                     <?php echo $product['description']; ?>
                                                                     <div style="font-size:10px !important;margin-top:5px !important;"><a href="<?php echo $product['href']; ?>" class="btn btn-button gray9-bg white"><?php echo "Read More"; ?></a></div>
                                                                 </div>
                                                             </li>
                                                            </ul>
                                                    <!-- / item -->
                                                    <?php } ?>
                                                
                                            </div>
                                            <div id="products-list" style="display: none;">
                                                <ol class="list-product">
                                                       <?php foreach ($products as $product) { ?>
                                                   <!-- item -->
                                                    <li class="item  row">
                                                       <!-- image -->
                                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                                            <div class="list-product-img">
                                                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                                            </div>
                                                        </div>
                                                        <!-- / images -->
                                                        <!-- content -->
                                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                                            <div class="list-product-content">
                                                                <div class="list-product-content-inner">
                                                                    <div class="product-lint-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                                                                    <div class="ratting-box">
                                                                        <div class="rating">
                                                                            <?php if ($product['rating']) { ?>
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } else { ?>
                                                            <span class="star active"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            <?php } else{ ?> 
                                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <span class="star-o"></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                     <div class="product-price">
                                                            <?php if ($product['price']) { ?>
                                                            <?php if (!$product['special']) { ?>
                                                            <span class="new-price"> <?php echo $product['price']; ?></span>
                                                            <?php } else { ?>
                                                            <span class="new-price"><?php echo $product['special']; ?></span> <span class="old-price"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                            <?php } ?>
                                                            </div>
                                                                    <div class="product-discription">
                                                                        <?php if ($product['description']) { ?>
                                                                         <p> <?php echo $product['description']; ?></p>
                                                                        <?php } ?>
                                                                         
                                                                    </div>
                                                                    <div class="add-to-cart">
                                                                        <button data-placement="top" data-toggle="tooltip" class="btn btn-button gray9-bg white" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>
                                                            <a data-placement="top" data-toggle="tooltip" class="btn btn-button gray9 border" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></a>
                                                            <a data-placement="top" data-toggle="tooltip"  class="btn btn-button gray9 border" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></a>
                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- / content -->
                                                    </li>
                                                    <!-- / item -->
                                                  <?php } ?>
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="toolbar toolbar-bottom">
                                            <div class="sorter margin-buttom padding-top-product">
                                                
                                                <div class="pager pager-area">
                                                    <p class="amount"><?php echo $results; ?></p>
                                                    <div class="pagination pages" id="pagination">
                                                         <?php echo $pagination; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / our product -->
                                    <?php if ($products) { ?>
                                    <div class="buttons">
                                        <div class="pull-right">
                                            <a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a>
                                        </div>
                                    </div>
                                    <?php } ?>
            <?php } if (!$categories && !$products) { ?>
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
<input type="hidden" id="text_cart_added" value="<?php echo $button_cart_added; ?>">
<input type="hidden" id="text_cart" value="<?php echo $button_cart; ?>">            
<?php echo $footer; ?>
