<?php echo $header; ?>
   <!--  slider -->
      <?php if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?> 
<?php echo $content_top; ?>
<div id="content" class="<?php echo $class; ?>"></div> 
            <!--  category product -->
            <section class="category-product padding-top margin-buttom">
                <div class="container">
                    <div class="row">
                        <!-- left area-->
                        <div class="col-sm-4 col-md-3 col-lg-3">
                            <!-- category menu -->
                            <div class="nav_vmmenu-area">
                                <div class="nav_inner">
                                    <div class="vmmenu-title gray9-bg"><i class="fa fa-list"></i><span><?php echo $wg24themeoptionpanel_t_category_prallax; ?></span></div>
                                    <div class="category-list">
                                        <div class="category-list-inner">
                                            <ul class="sf-vartical-menu sf-menu">
                                                <li>
                                                    <a href=""><i class="fa fa-home"></i><span><?php echo $wg24themeoptionpanel_hometext_prallax; ?></span></a>
                                                </li>
                                            <?php  foreach ($categories as $category) {  ?>
                                        <?php if ($category['children']) { ?>
                                        <li class="parrent">
                                            <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
                                            <ul class="sfmenuffect">
                                                <?php  foreach ($category['children'] as $children) {  ?> 
                                                <?php if ($children['children3']) { ?>
                                                <li class="parrent">
                                                    <a href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                    <ul class="sfmenuffect" >
                                                       <?php  foreach ($children['children3'] as $children3) {  ?>  
                                                       <li> <a href="<?php echo $children3['href']; ?>"><span><?php echo $children3['name']; ?></span></a></li>
                                                          <?php } ?>
                                                    </ul>
                                                </li>
                                                <?php }else { ?> 
                                                    <li>
                                                        <a href="<?php echo $children['href']; ?>"><span><?php echo $children['name']; ?></span></a>
                                                    </li>
                                                <?php } ?>
                                                 <?php }  ?> 
                                            </ul>
                                        </li>
                                        <?php } else{ ?>
                                        <li>
                                            <a href="<?php echo $category['href']; ?>"><span><?php echo $category['name']; ?></span></a>
                                        </li>
                                        
                                    <?php }} ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="more lable0 gray9-bg">
                                        <a class="dropdown-toggle" aria-expanded="false" href="#" data-toggle="dropdown"><i class="fa fa-plus"></i><span><?php echo $wg24themeoptionpanel_t_category_prallax; ?></span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- / category menu -->
                            <!--  today deals -->
                            <div class="todaydeals-box padding-top-product">
                                <div class="today-inner">
                                    <!--  today deals title and icon -->
                                   <!-- <div class="product-top-ber">
                                        <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_populartext_prallax; ?></span></h2>
                                    </div>-->
                                    <!-- / today deals title and icon -->
                                    <div class="todaydel-products medium-products product-container">
                       <?php  foreach ($pproducts as $product) { ?>
                        <!-- item -->
                        <div class="item">
                            <div class="product-details">
                                <div class="product-media">
                                    <!--  product image  -->
                                    <div class="product-img">
                                        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                        <!--  hover box -->
                                        <div class="hover-box">
                                            <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                            <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                         <!--   <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
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
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <!-- / item -->
                    <?php } ?>
           
                                    </div>
                                </div>
                            </div>
                            <!-- / today deals -->
                            <!--  cat banner -->
                            <?php if(isset($wg24themeoptionpanel_home1leftcollec_prallax)) { ?>
                            <div class="left-cat-banner padding-top-product">
                                <div class="left-cat-banner-inner">
                                    <div class="after-before-line-top"></div>
                                  <?php  echo  html_entity_decode($wg24themeoptionpanel_home1leftcollec_prallax); ?>
                                  
                                    <div class="after-before-line-buttom"></div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- / cat banner -->
                        </div>
                        <!-- / left area-->
                        <!--  right area-->
                        <div class="col-sm-8 col-md-9 col-lg-9">
                             <?php if(isset($wg24themeoptionpanel_home1megasale_prallax)) { ?>
                            <!--  add banner -->
                            <div class="add-banner-top margin-buttom">
                                <div class="add-banner-top-inner resbaner">
                                    <div class="row">
                                         <?php  echo  html_entity_decode($wg24themeoptionpanel_home1megasale_prallax); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- add banner -->
                                <?php } ?>
                                
                            <?php if(isset($categories)){ ?>    
                            <!-- our product area -->
                            <div class="our-product-area">
                                <!-- our product top bar -->
                                <div class="product-top-ber">
                                    <h2 class="product-hadding"><span> <?php  echo  html_entity_decode($wg24themeoptionpanel_home1ourpeocuttext_prallax); ?></span></h2>
                                </div>
                                <!-- / our product top bar -->
                                <!-- our product box -->
                                
                                <div class="category-products">
                                        <!--toolbar-->
                                        <!--<div class="toolbar">
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
                                               
                                            </div>
                                        </div>-->
                                        <!-- toolbar -->
                                        <div class="product-container">
                                            <div id="products-grid" >
                                               
                                                     <?php foreach ($catproducts1 as $product) { ?>
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
                                                           
                                                                <button id="cart_add_<?php echo $product['product_id']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                           
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
                                                       <?php foreach ($catproducts1 as $product) { ?>
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
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                
                                <!-- / our product box -->
                            </div>
                            <!-- / our product area-->
                            <?php } ?>
                            
                        </div>
                        <!-- / right area-->
                    </div>
                </div>
            </section>
            <!-- / category product -->
             <?php if($wg24themeoptionpanel_home1freedeliverymes_prallax!='') { ?>
            <!--  free shipping -->
            <section class="free-shipping">
                <div class="freeshipping-img">
                    <div class="free-shipping-inner ">
                        <div class="container resbaner">
                            <div class="row">
                                 <?php  echo  html_entity_decode($wg24themeoptionpanel_home1freedeliverymes_prallax); ?>
                                <div class=" col-sm-6 col-md-3 col-lg-3">
                                    <div class="free-shipping-box twitter">
                                        <div class="twitter-hadding">
                                            <span>  <?php  echo  html_entity_decode($wg24themeoptionpanel_home1latesttext_prallax); ?></span>
                                        </div>
                                        <div id="twitter-feed"></div>
                       <script type="text/javascript" charset="utf-8" src="catalog/view/theme/parallax/image/twitteroauth/jquery.tweet.js"></script>   
                        <script type="text/javascript">
                            jQuery(document).ready(function($) {
                            $('#twitter-feed').tweet({
                            modpath: 'catalog/view/theme/parallax/image/twitteroauth/',
                            count:"<?php echo  $wg24themeoptionpanel_count_twitter_prallax;?>",
                            username:"<?php echo  $wg24themeoptionpanel_twit_id_prallax;?>",
                            loading_text: 'loading twitter feed...'
                        });
                });
                        </script>
                      
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / free shipping -->
            <?php } ?>
       
           <?php echo $content_bottom; ?>
 <?php } ?>       
          <!-- home 1 end -->     
<?php if($wg24themeoptionpanel_homepage123_prallax=="homepage2") { ?> 
                <?php echo $content_top; ?>    
                 <?php if($wg24themeoptionpanel_home2freedeliverymes_prallax!='') { ?>
                    <!--  free shipping -->
                    <div class="style-2 free-shipping-inner padding-top margin-buttom">
                        <div class="row">
                            <?php  echo  html_entity_decode($wg24themeoptionpanel_home2freedeliverymes_prallax); ?>
                        </div>
                    </div>
                    <?php } ?>  
                            <!--  / free shipping -->
                        <?php if(isset($categories)){ ?>    
                            <!-- our product area -->
                            <div class="our-product-area">
                                <!-- our product top bar -->
                                <div class="product-top-ber">
                                    <h2 class="product-hadding"><span> <?php  echo  html_entity_decode($wg24themeoptionpanel_home1ourpeocuttext_prallax); ?></span></h2>
                                </div>
                                <!-- / our product top bar -->
                                <!-- our product box -->
                                <div class="our-product-box">
                                    <ul class="nav nav-tabs tab-menu">
                                     <?php $countca=1;  foreach ($categories as $category) {  
                                        if($countca<=3){ ?>
                                        <li class="<?php if($countca==1) echo 'active';?> "><a data-toggle="tab"   href="#cateproduct<?php  echo  $countca; ?>"> <?php  echo  $category['name']; ?></a></li>
                                       
                                     <?php  } $countca=$countca+1; } ?>
                                    </ul>
                                    <div class="tab-contents">
                                        <div id="cateproduct1" class="tab-pane  fade active in" role="tabpanel">
                                            <div class="our-products medium-products product-container">
                                    <?php  foreach ($catproducts1 as $product) { ?>
                                    <!-- item -->
                                   
                                    <div class="item">
                                    <div class="product-details">
                                       <div class="product-media">
                                           <!--  product image  -->
                                           <div class="product-img">
                                               <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                               <!--  hover box -->
                                               <div class="hover-box">
                                                   <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
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
                                    <!-- / item -->
                               
                                    <?php } ?>            
                                            </div>
                                        </div>
                                        <div id="cateproduct2" class="tab-pane  fade" role="tabpanel">
                                             <div class="our-products medium-products product-container">
                                    <?php  foreach ($catproducts2 as $product) { ?>
                                    <!-- item -->
                                    <div class="item"> 
                                    <div class="product-details">
                                       <div class="product-media">
                                           <!--  product image  -->
                                           <div class="product-img">
                                               <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                               <!--  hover box -->
                                               <div class="hover-box">
                                                   <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                   <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                                       <!--   <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
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
                                    <!-- / item -->
                                    <?php } ?>            
                                            </div>
                                        </div>
                                        <div id="cateproduct3" class="tab-pane  fade" role="tabpanel">
                                             <div class="our-products medium-products product-container">
                                    <?php foreach ($catproducts3 as $product) { ?>
                                    <!-- item -->
                                    <div class="item"> 
                                    <div class="product-details">
                                       <div class="product-media">
                                           <!--  product image  -->
                                           <div class="product-img">
                                               <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                               <!--  hover box -->
                                               <div class="hover-box">
                                                   <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
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
                                    <!-- / item -->
                                    <?php } ?>            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / our product box -->
                            </div>
                            <!-- / our product area-->
                            <?php } ?>
                            
                        </aside>
                        <!-- / right side -->
                    </div>
                </div>
            </div>    

            
     <?php if($wg24themeoptionpanel_home2dealoftheday_prallax!='') { ?>          
<!-- timer banner-->
<section class="timer-banner padding-top">
 <div class="timer-banner-inner">
     <div class="container resbaner">
         <div class="row">
              <?php  echo  html_entity_decode($wg24themeoptionpanel_home2dealoftheday_prallax); ?>
         </div>
     </div>
 </div>
</section>
<!--  / timer banner-->
   <?php } ?>            
 <?php echo $content_bottom; ?>
 <?php } ?>          
           
       <!-- home 2 end -->
       
      <!-- home 1 end -->     
<?php if($wg24themeoptionpanel_homepage123_prallax=="homepage3") { ?> 
    <?php echo $content_top; ?>    
       <?php if(isset($categories)){ ?>    
        <!--  our product area-->
            <section class="our-product-area padding-top">
                <div class="our-product-box style-tab-3">
                    <!--  our product top bar -->
                    <div class="our-tab-header style-3 product-tab tab-style-2">
                        <h2 class="product-tab-title">
                            <strong class="tab-left-line">&nbsp;</strong>
                            <span><?php  echo  html_entity_decode($wg24themeoptionpanel_home1ourpeocuttext_prallax); ?></span>
                            <strong class="tab-left-line">&nbsp;</strong>
                        </h2>
                        <div class="container">
                            <!-- / our product top bar -->
                            <!--  our product box -->
                            <ul class="nav nav-tabs">
                                <?php $countca=1;  foreach ($categories as $category) {  
                                        if($countca<=5){ ?>
                                        <li class="<?php if($countca==1) echo 'active';?> "><a data-toggle="tab"   href="#cat<?php  echo  $countca; ?>"><span class="fa fa-diamond "></span> <?php  echo  $category['name']; ?></a></li>
                               <?php  } $countca=$countca+1; } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-contents medium-products container">
                        <div id="cat1" class="tab-pane  fade active in" role="tabpanel">
                            <div class="our-products-home3 product-container">
                               <?php $size1=count($catproducts1); $m1=0; foreach ($catproducts1 as $product) { ?>
                                    <!-- item -->
                                      <?php if($m1++%2==0):?>
                                    <div class="item">
                                          <?php endif;?>   
                                    <?php include('product-tabs.tpl'); ?>
                                    <?php if($m1%2==0 || $m1==$size1):?>     
                                    </div>
                                    <!-- / item -->
                                   <?php endif;  ?>
                                    <?php } ?> 
                            </div>
                        </div>
                        <div id="cat2" class="tab-pane  fade" role="tabpanel">
                            <div class="our-products-home3 product-container">
                                  <?php $size2=count($catproducts2); $m2=0; foreach ($catproducts2 as $product) { ?>
                                    <!-- item -->
                                      <?php if($m2++%2==0):?>
                                    <div class="item">
                                          <?php endif;?>   
                                   <?php include('product-tabs.tpl'); ?>
                                    <?php if($m2%2==0 || $m2==$size2):?>     
                                    </div>
                                    <!-- / item -->
                                   <?php endif;  ?>
                                    <?php } ?>   
                            </div>
                        </div>
                        <div id="cat3" class="tab-pane  fade" role="tabpanel">
                            <div class="our-products-home3 product-container">
                            <?php $size3=count($catproducts3); $m3=0; foreach ($catproducts3 as $product) { ?>
                                    <!-- item -->
                                      <?php if($m3++%2==0):?>
                                    <div class="item">
                                          <?php endif;?>   
                                   <?php include('product-tabs.tpl'); ?>
                                    <?php if($m3%2==0 || $m3==$size3):?>     
                                    </div>
                                    <!-- / item -->
                                   <?php endif;  ?>
                                    <?php } ?>   
                            </div>
                        </div>
                        <div id="cat4" class="tab-pane  fade" role="tabpanel">
                            <div class="our-products-home3 product-container">
                              <?php $size4=count($catproducts4); $m4=0; foreach ($catproducts4 as $product) { ?>
                                    <!-- item -->
                                      <?php if($m4++%2==0):?>
                                    <div class="item">
                                          <?php endif;?>   
                                    <?php include('product-tabs.tpl'); ?>
                                    <?php if($m4%2==0 || $m4==$size4):?>     
                                    </div>
                                    <!-- / item -->
                                   <?php endif;  ?>
                                    <?php } ?>
                            </div>
                        </div>
                        <div id="cat5" class="tab-pane  fade" role="tabpanel">
                            <div class="our-products-home3 product-container">
                                 <?php $size5=count($catproducts5); $m5=0; foreach ($catproducts5 as $product) { ?>
                                    <!-- item -->
                                      <?php if($m5++%2==0):?>
                                    <div class="item">
                                          <?php endif;?>  
                                          <?php include('product-tabs.tpl'); ?>
                                    <?php if($m5%2==0 || $m5==$size5):?>     
                                    </div>
                                    <!-- / item -->
                                   <?php endif;  ?>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / our product box -->
            </section>
            <!-- / our product -->          
        <?php } ?>     
  <?php if($wg24themeoptionpanel_home3hotdealbanner_prallax!='') { ?>     
        <!-- promo banner-4 -->
            <div class="banner-bottom padding-top">
                <div class="container">
                    <div class="row">
                        <?php  echo  html_entity_decode($wg24themeoptionpanel_home3hotdealbanner_prallax); ?>
                    </div>
                </div>
            </div>
            <!-- / promo banner-4 -->   
     <?php } ?>   
        
        
               
 <?php echo $content_bottom; ?>
 <?php } ?>            
           
           
           
           
<?php echo $footer; ?>