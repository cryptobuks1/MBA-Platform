
<!--  brand logo -->
            <section class="brand-logo-area padding-top">
                <div class="container">
                    <h2 class="product-hadding"><span><?php echo $heading_title; ?></span></h2>
                    <div class="brand-logo-box" id="brand-logo">
                            <?php foreach ($banners as $banner) { ?>
                            <div class="item">
                            <?php if ($banner['link']) { ?>
                            <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>"  /></a>
                            <?php } else { ?>
                            <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
                            <?php } ?>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </section>
            <!-- / brand logo -->
            
 <?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage1") { ?>             
  <?php if($wg24themeoptionpanel_miniproducts_prallax=="show")   { ?>    
<!--  mini product -->
<section class="mini-product-area padding-top">
<div class="container">
   <div class="row">
       <div class="col-sm-4 col-md-4  col-lg-4">
           <div class="best-sale-produt">
               <div class="best-sale-produt-inner">
                   <div class="product-top-ber ">
                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?></span></h2>
                   </div>
               </div>
               <div class="product-item" id="minibestsaleproduct">
                          <?php  if($bestsales!="test"){ $size1=count($bestsales); $m1=0; foreach ($bestsales as $product) { ?>
                            <!-- item -->
                              <?php if($m1++%3==0):?>
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
                            <?php if($m1%3==0 || $m1==$size1):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php } } ?>  
               </div>
           </div>
       </div>
       <div class="col-sm-4 col-md-4  col-lg-4">
           <div class="top-rate-produt">
               <div class="best-sale-produt-inner">
                   <div class="product-top-ber ">
                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1toprattingtext_prallax; ?></span></h2>
                   </div>
               </div>
               <div class="product-item" id="minitopratingproduct">
                  <?php  if($toprated!="test"){ $size2=count($toprated); $m2=0; foreach ($toprated as $product) { ?>
                            <!-- item -->
                              <?php if($m2++%3==0):?>
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
                            <?php if($m2%3==0 || $m2==$size2):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php } } ?>  
               </div>
           </div>
       </div>
       <div class="col-sm-4 col-md-4  col-lg-4">
           <div class="special-produt">
               <div class="best-sale-produt-inner">
                   <div class="product-top-ber ">
                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1Specialtext_prallax; ?></span></h2>
                   </div>
               </div>
               <div class="product-item" id="minispecialproduct">
                     <?php  if($specials!="test"){ $size3=count($specials); $m3=0; foreach ($specials as $product) { ?>
                            <!-- item -->
                              <?php if($m3++%3==0):?>
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
                            <?php if($m3%3==0 || $m3==$size3):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php } } ?>  
               </div>
           </div>
       </div>
   </div>
</div>
</section>
<!-- / mini product -->    
 <?php } } ?>
  <?php  if($wg24themeoptionpanel_homepage123_prallax=="homepage3") { ?>             
  <?php if($wg24themeoptionpanel_miniproducts_prallax=="show")   { ?>    
    <!--  mini product -->
            <section class="mini-product-area padding-top">
                <div class="container">
                    <div class="row">
                       <!-- banner -->
                         <?php if($wg24themeoptionpanel_home3minibanner_prallax!='') { ?>  
                        <div class="col-md-4 col-lg-4 resbaner">
                             <?php  echo  html_entity_decode($wg24themeoptionpanel_home3minibanner_prallax); ?>
                          
                        </div>
                        <?php  } ?>  
                        <!-- / banner -->
                        <div class="col-sm-6 col-md-4  col-lg-4">
                           <div class="best-sale-produt">
               <div class="best-sale-produt-inner">
                   <div class="product-top-ber ">
                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?></span></h2>
                   </div>
               </div>
               <div class="product-item" id="minibestsaleproduct">
                          <?php  if($bestsales!="test"){ $size1=count($bestsales); $m1=0; foreach ($bestsales as $product) { ?>
                            <!-- item -->
                              <?php if($m1++%3==0):?>
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
                            <?php if($m1%3==0 || $m1==$size1):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php } } ?>  
               </div>
           </div>
                        </div>
                        <div class=" col-sm-6 col-md-4  col-lg-4">
                         <div class="special-produt">
               <div class="best-sale-produt-inner">
                   <div class="product-top-ber ">
                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1Specialtext_prallax; ?></span></h2>
                   </div>
               </div>
               <div class="product-item" id="minispecialproduct">
                     <?php  if($specials!="test"){ $size3=count($specials); $m3=0; foreach ($specials as $product) { ?>
                            <!-- item -->
                              <?php if($m3++%3==0):?>
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
                            <?php if($m3%3==0 || $m3==$size3):?>     
                            </div>
                            <!-- / item -->
                           <?php endif;  ?>
                            <?php } } ?>  
               </div>
           </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- / mini product-->   
 <?php } } ?>