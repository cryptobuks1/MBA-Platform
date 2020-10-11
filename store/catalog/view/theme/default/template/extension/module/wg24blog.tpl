<?php echo $header; ?>
    <!-- start breadcrumb area-->
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
                <!-- end breadcrumb area-->
                <section  class="main-page container">
                    <div class="main-container col2-left-layout">
                        <div class="main">
                            <div class="row">
                                <!-- start left area -->
                                <div class="col-sm-4 col-md-3 col-lg-3">
                                    <?php include('wg24blog_leftcolumn.tpl'); ?>
                                </div>
                                <!-- end left area-->
                                <div class="col-sm-8 col-md-9 col-lg-9">
                                    <div class="col-main">
                                        <!-- start right area-->
                                        <div class="all-blog-area">
                                            <div class="page-title"><span><?php echo $heading_title; ?></span></div>
                                            <?php if ($thumb || $description) { ?>
                                            <div class="row">
                                            <?php if ($thumb) { ?>
                                            <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
                                            <?php } ?>
                                            <?php if ($description) { ?>
                                            <div class="col-sm-10"><?php echo $description; ?></div>
                                            <?php } ?>
                                            </div>
                                            <hr>
                                            <?php } ?>
                                            
                                               <?php if ($blogpost) { ?>
                                                  <div class="category-products">
                                        <!--toolbar-->
                                        <div class="toolbar">
                                            <div class="sorter">
                                                
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
                                                    <p class="amount"></p>
                                                    <div class="pagination pages" id="pagination">
                                                        <?php echo $pagination; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- toolbar -->
                                        <div class="product-container">
                                          <div class="row">
                                                   <?php foreach ($blogpost as $product) { ?>
                                                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                                    <div class="blog-right-area">
                                                        <div class="latest-blog-box">
                                                            <div class="latest-blog-box-inner">
                                                                <div class="latest-blog-content">
                                                                    <div class="blog-img">
                                                                        <?php if(!empty($product['video'])){ echo $product['video'];}else{ ?>
                                                                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['title']; ?>" title="<?php echo $product['title']; ?>" class="img-responsive" /></a>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="blog-content">
                                                                        <div class="blog-content-inner padding-top-product">
                                                                            <div class="hadding-title"><a href="<?php echo $product['href']; ?>"><?php echo $product['title']; ?></a></div>
                                                                        </div>
                                                                        <div class="post-content">
                                                                            <ul class="post-meta">
                                                                                <li><span class="fa fa-comment-o"></span><a href="#"><?php echo $product['totalcomment']; ?> <?php echo $wg24themeoptionpanel_blogcommenttext_prallax; ?></a></li>
                                                                                <li><span class="fa fa-calendar"></span><a href="#"><?php echo $product['adddate']; ?></a></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="post-detail margin-buttom-product">
                                                                            <p><?php echo $product['description']; ?>
                                                                            </p>
                                                                        </div>
                                                                        <a href="<?php echo $product['href']; ?>" class="read-more"> <span class="fa fa-book"></span>Read More...</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                              <?php } ?>
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
                                               
                                            
                                            
                                            <!-- end right area-->
                                        <?php } else { ?>
                                    <p><?php echo $text_empty; ?></p>
                                    <div class="buttons">
                                    <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
                                    </div>
                                    <?php } ?> 
                                            
                                        </div>
                                    </div>
                                </div>  

                            </div>    
                        </div>
                    </div>
                </section>
               <!-- end product details area-->
<?php echo $footer; ?>