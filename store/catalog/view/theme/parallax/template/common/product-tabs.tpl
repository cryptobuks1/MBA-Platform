  <div class="product-details">
                                       <div class="product-media">
                                           <!--  product image  -->
                                           <div class="product-img">
                                               <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"  /></a>
                                               <!--  hover box -->
                                               <div class="hover-box">
                                                   <button data-placement="top" data-toggle="tooltip" class="btn btn-button cart-button" type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" ><i class="fa fa-shopping-cart"></i><span><?php echo $button_cart; ?></span></button>
                                                   <a href="<?php echo $product['quickview']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                             <!--      <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
                                                   <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>-->
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