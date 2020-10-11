 <!--  latest blog -->
            <section class="latest-blog-area padding-top">
                <div class="latest-blog-inner">
                    <div class="container">
                        <div class="latest-blog-hadding">
                            <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1blogtitletext_prallax; ?></span></h2>
                        </div>
                        <div class="<?php if(($wg24themeoptionpanel_homepage123_prallax=='homepage1')|| ($wg24themeoptionpanel_homepage123_prallax=='homepage2')) { ?>latest-blog-container<?php } else { ?>  latest-blog-container3 <?php } ?>">
                             <?php foreach ($blogpost as $product) { ?> 
                            <div class="latest-blog-box">
                                <div class="latest-blog-box-inner">
                                    <div class="latest-blog-content">
                                        <div class="blog-img">
                                            <a href="<?php echo $product['href']; ?>">
                                            <?php if(!empty($product['video'])){ echo $product['video'];}else{ ?>
                                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['title']; ?>" title="<?php echo $product['title']; ?>"  />
                                            </a>
                                            <?php } ?>
                                        </div>
                                        <div class="blog-content blog-content1">
                                            <div class="blog-content-inner padding-top-product">
                                                <div class="hadding-title"><a href="<?php echo $product['href']; ?>"><?php echo $product['title']; ?></a></div>
                                            </div>
                                            <div class="post-content">
                                                <ul class="post-meta">
                                                    <li><span class="fa fa-comment-o"></span><a href="#"><?php echo $product['totalcomment'];?>  <?php  echo $wg24themeoptionpanel_blogcommenttext_prallax; ?> </a></li>
                                                    <li><span class="fa fa-pencil"></span><a href="#"><?php  echo $wg24themeoptionpanel_blogpostbttext_prallax; ?> <?php echo $product['postadmin']; ?></a></li>
                                                    <li><span class="fa fa-calendar"></span><a href="#"><?php echo $product['adddate']; ?></a></li>
                                                </ul>
                                            </div>
                                            <div class="post-detail margin-buttom-product">
                                                <p><?php echo $product['description']; ?> </p>
                                            </div>
                                            <a class="read-more" href="<?php echo $product['href']; ?>"><span class="fa fa-book"></span> <?php echo $wg24themeoptionpanel_blogreadmoretext_prallax; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <?php } ?>
                          
                        </div>
                    </div>
                </div>
            </section>
            <!-- / latest blog -->
            
      
            
            
            