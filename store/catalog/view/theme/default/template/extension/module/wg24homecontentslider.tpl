  <?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?>  
<?php if($module==0){ ?>
<figure class="slider-area">
        <div class="slider-area-inner">
            <div class="ajax_loading"><i class="fa fa-spinner fa-spin"></i></div>
            <div id="nivoparrallax" class="nivoSlider">
                  <?php $i=1; foreach ($banners as $banner) { ?>
                <!-- slider 1 -->
                <div class="slider-item">
                <img src="<?php echo $banner['image']; ?>" title="#imgcaption<?php echo $i;?>" alt="<?php echo $banner['description']['title']; ?>"  />
                    <div id="imgcaption<?php echo $i;?>" class="caption-item" style="display: none">
                        <div class="container">
                            <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                        </div>
                    </div>
                </div>
                <!-- / slider 1 -->
                  <?php $i=$i+1; } ?>
            </div>
        </div>
    </figure>
            <!-- / slider -->
      <?php } ?>    
 <?php } ?>
 <?php if($wg24themeoptionpanel_homepage123_prallax=="homepage2") { ?>   
<?php if($module==1){ ?>
  <!-- slider -->
  <figure class="slider-area slider-2-style">
        <div class="slider-area-inner">
            <div class="ajax_loading"><i class="fa fa-spinner fa-spin"></i></div>
            <div id="nivoparrallax" class="nivoSlider">
                  <?php $i=1; foreach ($banners as $banner) { ?>
                <!-- slider 1 -->
                <div class="slider-item">
                <img src="<?php echo $banner['image']; ?>" title="#imgcaption<?php echo $i;?>" alt="<?php echo $banner['description']['title']; ?>"  />
                    <div id="imgcaption<?php echo $i;?>" class="caption-item" style="display: none">
                        <div class="container">
                            <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                        </div>
                    </div>
                </div>
                <!-- / slider 1 -->
                  <?php $i=$i+1; } ?>
            </div>
        </div>
    </figure>

    <!-- category product -->
            <div class="category-product padding-top">
                <div class="container">
                    <div class="row">
                        <!-- left side -->
                        <aside class="col-sm-4 col-md-3 col-lg-3">
                              <!-- category menu -->
                            <div class="nav_vmmenu-area hidden-xs">
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
                                    <div class="product-top-ber">
                                        <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_populartext_prallax; ?></span></h2>
                                    </div>
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
                                            <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                            <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                        </div>
                                        <!-- / hover box -->
                                    </div>
                                    <!-- / product image -->
                                    <!--  sale and new box -->
                                    <div class="product-lable-box">
                                <?php if ($product['price'] && $product['special']) { ?>
                                 <div class="lable-sale"><?php echo $wg24themeoptionpanel_saletext_prallax; ?></div>    
                                <?php } ?>       
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
                               <?php if(isset($wg24themeoptionpanel_cateletbanner_prallax)) { ?>
                            <!--  category banner -->
                            <div class="aside-category-banner padding-top-product resbaner">
                                <div class="aside-category-banner-inner">
                                    <?php  echo  html_entity_decode($wg24themeoptionpanel_cateletbanner_prallax); ?>
                                </div>
                            </div>
                                <?php } ?>
                            <!-- / aside category banner -->
                            
                            <!--  best sale -->
                            <div class="best-sale-category padding-top-product">
                                <div class="product-top-ber ">
                                    <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?></span></h2>
                                </div>
                                <div class="product-item" id="minibestsaleproduct">
                                   <?php  $size1=count($bestsales); $m1=0; foreach ($bestsales as $product) { ?>
                            <!-- item -->
                              <?php if($m1++%4==0):?>
                            <div class="product-item-inner">
                                  <?php endif;?>   
                                  <div class="item first-item">
                            <div class="category-details">
                               <div class="category-img">
                                   <!--  product image  -->
                                       <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                   <!-- / product image -->
                               </div>
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
                            <?php if($m1%4==0 || $m1==$size1):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php  } ?>  
                                </div>
                            </div>
                            <!--  / best sale -->
                            <!-- populer tag -->
                            <div class="popular-tag padding-top-product">
                                <div class="hadding"><span><?php echo $wg24themeoptionpanel_populartexttext_prallax; ?></span></div>
                                <div class="popular-tag-content">
                                    <ul>
                                        <?php   if ($tags) { ?>
                                        <?php for ($i = 0; $i <15; $i++) { ?>
                                        <?php if ($i < (count($tags) - 1)) { ?>
                                            <li><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
                                        <?php } else { ?>
                                          <li><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <!--  / populer tag -->
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
                        </aside>
                        <!-- / left side-->
                        <!-- right side -->
                        <aside class="col-sm-8 col-md-9 col-lg-9">
<?php  } ?>
<?php } ?>


 <?php if($wg24themeoptionpanel_homepage123_prallax=="homepage3") { ?>   
<?php if($module==2){ ?>
                        <figure class="slider-area">
                            <div class="slider-area-inner">
                                <div class="ajax_loading"><i class="fa fa-spinner fa-spin"></i></div>
                                <div id="nivoparrallax" class="nivoSlider">
                                        <?php $i=1; foreach ($banners as $banner) { ?>
                                        <!-- slider 1 -->
                                        <div class="slider-item">
                                        <img src="<?php echo $banner['image']; ?>" title="#imgcaption<?php echo $i;?>" alt="<?php echo $banner['description']['title']; ?>"  />
                                        <div id="imgcaption<?php echo $i;?>" class="caption-item" style="display: none">
                                        <?php  echo  html_entity_decode($banner['description']['desce']); ?>
                                        </div>
                                        </div>
                                        <!-- / slider 1 -->
                                        <?php $i=$i+1; } ?>
                                </div>
                            </div>
                        </figure>
                        <!-- / slider-->
                    </div>
                </div>
        </div>
<?php  } ?>
<?php } ?>