<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
<?php echo $header; ?>
<!--  breadcrumb area-->
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
<!-- / breadcrumb area-->
<!--  product details area-->
<section class="main-page container">
    <div class="main-container col1-layout">
        <div class="main">
             <?php if($wg24themeoptionpanel_productlayout_prallax=='left' || $wg24themeoptionpanel_productlayout_prallax=='right'){ ?>
               <div class="row">
                    <?php if($wg24themeoptionpanel_productlayout_prallax=='left'){ ?>
                            <!--  left side -->
                            <aside class="col-sm-4 col-md-3 col-lg-3">
                                <?php echo $column_left ?>
                                <!-- / aside category banner -->
                            </aside>
                            <!-- / left side -->
                            <!-- Right side -->
                           <?php } ?>   
                            <div class="col-sm-8 col-md-9 col-lg-9">
             <?php } ?>
             
            <div class="col-main">
                <div class="product-view" id="content">
                    <div class="product-essential ">
                        <div class="row">
                            <!-- view product -->
                            <div class="<?php if($wg24themeoptionpanel_productlayout_prallax=='wminiproducts'){ ?>  col-sm-5 col-md-4 col-lg-4 <?php } elseif($wg24themeoptionpanel_productlayout_prallax=='left' || $wg24themeoptionpanel_productlayout_prallax=='right'){ ?>  col-sm-12 col-md-5 col-lg-5 <?php } else { ?> col-sm-5 col-md-4 col-lg-4 <?php } ?>">
                                <div class="product-img-box resbaner">
                                    <?php if ($thumb || $images) { ?>
                                    <?php if ($thumb) { ?>
                                    <!-- big images -->
                                    <p class="product-view-img colorbox">
                                        <img id="zoom_image" data-zoom-image="<?php echo $popup; ?>" src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" />
                                        <a href="<?php echo $popup; ?>" class="fa fa-search-plus icon colorbox" title=""></a>
                                    </p>
                                    <?php } ?>


                                    <?php if ($images) { ?>
                                    <!-- more views -->
                                    <div class="more-views">
                                        <ul id="more" class="colorbox">
                                            <?php foreach ($images as $image) { ?>
                                            <li><a  href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" data-image="<?php echo $image['popup']; ?>" data-zoom-image="<?php echo $image['popup']; ?>" class="elevatezoom-gallery colorbox"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- / view product -->
                            <!-- product content -->
                            <div class="<?php if($wg24themeoptionpanel_productlayout_prallax=='wminiproducts'){ ?>  col-sm-7 col-md-5 col-lg-5 <?php }elseif($wg24themeoptionpanel_productlayout_prallax=='left' || $wg24themeoptionpanel_productlayout_prallax=='right'){ ?> col-sm-12 col-md-7 col-lg-7 <?php }else { ?> col-sm-7 col-md-8 col-lg-8 <?php } ?>">
                                <div class="product-shop">
                                    <div class="products-name">
                                        <h1><?php echo $heading_title; ?></h1>
                                    </div>
                                    <div class="ratting-box">
                                        <?php if ($review_status) { ?>      
                                        <div class="rating">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <?php if ($rating < $i) { ?>
                                            <span class="star-o"></span>
                                            <?php } else { ?>
                                            <span class="star active"></span>
                                            <?php } ?>
                                            <?php } ?>   
                                        </div>
                                        <div class="product-review">
                                            <ul>
                                                <li><a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a></li>
                                                <li> | <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $text_write; ?></a> </li>
                                            </ul>
                                        </div>
                                        <?php } ?>                
                                    </div>
                                    <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style" data-url="<?php echo $share; ?>"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                                    <!-- AddThis Button END -->                     

                                    <div class="product-price">
                                        <?php if ($price) { ?>
                                        <ul class="list-unstyled">
                                            <?php if (!$special) { ?>
                                            <li>
                                                <h2  class="new-price"><?php echo $price; ?></h2>
                                            </li>
                                            <?php } else { ?>
                                            <li><span style="text-decoration: line-through;"><?php echo $price; ?></span></li>
                                            <li>
                                                <h2 class="new-price"><?php echo $special; ?></h2>
                                            </li>
                                            <?php } ?>
                                            <?php if ($tax) { ?>
                                            <li><?php echo $text_tax; ?> <?php echo $tax; ?></li>
                                            <?php } ?>
                                            <?php if ($points) { ?>
                                            <li><?php echo $text_points; ?> <?php echo $points; ?></li>
                                            <?php } ?>
                                            <?php if ($discounts) { ?>
                                            <li>
                                                <hr>
                                            </li>
                                            <?php foreach ($discounts as $discount) { ?>
                                            <li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
                                            <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>

                                    </div>  
                                    <ul class="list-unstyled">
                                        <?php if ($manufacturer) { ?>
                                        <li><?php echo $text_manufacturer; ?> <a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
                                        <?php } ?>
                                        <li><?php echo $text_model; ?> <span class="editable instock"><?php echo $model; ?></span></li>
                                        <?php if ($reward) { ?>
                                        <li><?php echo $text_reward; ?><span class="editable instock"> <?php echo $reward; ?></span></li>
                                        <?php } ?>
                                        <li><?php echo $text_stock; ?> <span class="editable instock"><?php echo $stock; ?></span></li>

                                    </ul>

                                    <div id="product">
                                        <?php if ($options) { ?>
                                        <hr>
                                        <h3><?php echo $text_option; ?></h3>
                                        <?php foreach ($options as $option) { ?>
                                        <?php if ($option['type'] == 'select') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                    <?php if ($option_value['price']) { ?>
                                                    (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                    <?php } ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'radio') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label"><?php echo $option['name']; ?></label>
                                            <div id="input-option<?php echo $option['product_option_id']; ?>">
                                                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                                        <?php if ($option_value['image']) { ?>
                                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
                                                        <?php } ?>                    
                                                        <?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'checkbox') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label"><?php echo $option['name']; ?></label>
                                            <div id="input-option<?php echo $option['product_option_id']; ?>">
                                                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                                                        <?php if ($option_value['image']) { ?>
                                                        <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
                                                        <?php } ?>
                                                        <?php echo $option_value['name']; ?>
                                                        <?php if ($option_value['price']) { ?>
                                                        (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                                                        <?php } ?>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'text') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'textarea') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'file') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label"><?php echo $option['name']; ?></label>
                                            <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block" data-toggle="tooltip" title=""><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                                            <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'date') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <div class="input-group date">
                                                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" autocomplete="off" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span></div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'datetime') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <div class="input-group datetime">
                                                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                </span></div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($option['type'] == 'time') { ?>
                                        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <div class="input-group time">
                                                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                                                </span></div>
                                        </div>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php } ?>
                                        <?php if ($recurrings) { ?>
                                        <hr>
                                        <h3><?php echo $text_payment_recurring; ?></h3>
                                        <div class="form-group required">
                                            <select name="recurring_id" class="form-control">
                                                <option value=""><?php echo $text_select; ?></option>
                                                <?php foreach ($recurrings as $recurring) { ?>
                                                <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block" id="recurring-description"></div>
                                        </div>
                                        <?php } ?>
                                          <div class="add-to-cart">
                                            <?php if ($minimum > 1) { ?>
                                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
                                            <?php } ?>
                                       
                                        <div class="input-content">
                                            <label><?php echo $entry_qty; ?>:</label>
                                            <div class="box-qty">
                                                <input type="text" name="quantity" value="<?php echo $minimum; ?>"  id="input-quantity" class="input-text qty" />
                                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                                                <div class="qty-arrows">
                                                    <input type="button" class="qty-increase" onclick="var qty_el = document.getElementById('input-quantity');
                                                                                    var qty = qty_el.value;
                                                                                    if (!isNaN(qty))
                                                                                    qty_el.value++;
                                                                                    return false;" value="+">
                                                    <input type="button" class="qty-decrease" onclick="var qty_el = document.getElementById('input-quantity');
                                                                                    var qty = qty_el.value;
                                                                                    if (!isNaN(qty) && qty >1)
                                                                                    qty_el.value--;
                                                                                    return false;                                                                           " value="-">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-button white"><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>                
                                     <!--   <a class="btn btn-button gray9 border" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i></a>
                                        <a class="btn btn-button gray9 border" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-exchange"></i></a>-->
                                         </div>
                                        
                                    </div>
                                  

                                </div>
                            </div>
                            <!-- / product content -->
                            <?php if($wg24themeoptionpanel_productlayout_prallax=='wminiproducts'){ ?>
                            <div class=" col-md-3 col-lg-3 hiden-sm">
                               <!--  best sale -->
                               <div class="best-sale-category ">
                                  <div class="product-top-ber ">
                                       <h2 class="product-hadding"><span><?php echo $wg24themeoptionpanel_home1bestsaletext_prallax; ?></span></h2>
                                   </div>
                                  <div class="product-item" id="minibestsaleproduct">
                                         <?php  $size1=count($bproducts); $m1=0; foreach ($bproducts as $product) { ?>
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
                            <?php }  ?>  
                                   </div>
                               </div>
                               <!-- / best sale -->
                               </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="product-collateral row-fluid padding-top">
                        <!-- tab -->
                        <div class="single-product-tab">
                            <ul class="nav nav-tabs" id="myTab">
                                 <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
                        <?php if ($attribute_groups) { ?>
                        <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
                        <?php } ?>
                        <?php if ($review_status) { ?>
                        <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
                        <?php } ?> 
                         <?php if ($wg24themeoptionpanel_p_tab_contorl_prallax="show") { ?>
                         <li><a href="#tab-custom" data-toggle="tab"><?php echo $wg24themeoptionpanel_p_tab_title_prallax; ?></a></li>
                        <?php } ?> 
                        
                        
                        
                            </ul>
                              <div class="tab-content">
                                  <div class="tab-pane active" id="tab-description"><div class="single-product-description"><?php echo $description; ?></div></div>
                          <?php if ($wg24themeoptionpanel_p_tab_contorl_prallax="show") { ?>
                        <div class="tab-pane active" id="tab-custom"><div class="single-product-description">
                                <?php  echo  html_entity_decode($wg24themeoptionpanel_p_tab_content_prallax); ?>
                            </div></div>
                        <?php } ?> 
                                  
                                  
                                  <?php if ($attribute_groups) { ?>
                        <div class="tab-pane" id="tab-specification">
                            <div class="single-product-description">
                            <table class="table table-bordered">
                                <?php foreach ($attribute_groups as $attribute_group) { ?>
                                <thead>
                                    <tr>
                                        <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                    <tr>
                                        <td><?php echo $attribute['name']; ?></td>
                                        <td><?php echo $attribute['text']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php } ?>
                            </table>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($review_status) { ?>
                        <div class="tab-pane" id="tab-review">
                            <div class="single-product-description">
                            <form class="form-horizontal" id="form-review">
                                <div id="review"></div>
                                <h2><?php echo $text_write; ?></h2>
                                <?php if ($review_guest) { ?>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                        <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                                        <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                                        <div class="help-block"><?php echo $text_note; ?></div>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo $entry_rating; ?></label>
                                        &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                        <input type="radio" name="rating" value="1" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="2" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="3" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="4" />
                                        &nbsp;
                                        <input type="radio" name="rating" value="5" />
                                        &nbsp;<?php echo $entry_good; ?></div>
                                </div>
                                <?php echo $captcha; ?>
                                <div class="buttons clearfix">
                                   
                                        <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-button gray9-bg white"><?php echo $button_continue; ?></button>
                                 
                                </div>
                                <?php } else { ?>
                                <?php echo $text_login; ?>
                                <?php } ?>
                            </form>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                      <div class="buttons clearfix">
                                   
                                       <a href="<?php echo $checkout; ?>"> <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-button gray9-bg white"><?php echo $button_continue; ?></button></a>
                                 
                                </div>
                        </div>
                        <!-- / tab -->
                          <?php if ($products) { ?>
                        <!-- upsale products -->
                        <section class="full-width-product-area padding-top">
                            <?php if($wg24themeoptionpanel_productlayout_prallax=='wminiproducts'){ ?>
                             <div class="row">
                                    <!-- banner -->
                                    <div class="col-sm-3 col-md-3 col-lg-3 hidden-sm">
                                        <div class="aside-category-banner hidden-xs">
                                              <?php  echo  html_entity_decode($wg24themeoptionpanel_rpaddbanner_prallax); ?>
                                        </div>
                                    </div>
                                    <!-- banner -->
                                    <div class="col-sm-12 col-md-9 col-lg-9">
                              <?php } ?>
                            
                            <!--  product title and icon -->
                            <div class="product-top-ber">
                                <h2 class="product-hadding"><span><?php echo $text_related; ?></span></h2>
                            </div>
                            <div class="related-prodcuts<?php if($wg24themeoptionpanel_productlayout_prallax!='default'){ ?>2 <?php } ?>  medium-products product-container">
               <?php foreach ($products as $product) { ?>
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
                                <a href="<?php echo $product['href']; ?>" data-placement="top" data-toggle="tooltip" class="btn btn-button button-search white-bg " title="<?php echo $wg24themeoptionpanel_quicviewtext_prallax ?>"><i class="fa fa-search"></i></a>
                                  <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-wishlist white-bg" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                <button data-placement="top" data-toggle="tooltip" type="button" class="btn btn-button button-compare white-bg" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
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
                          <?php if($wg24themeoptionpanel_productlayout_prallax=='wminiproducts'){ ?>  
                             </div>
                             </div>
                             <?php } ?> 
                        </section>
                        <!-- / upsale products -->
                        <?php } ?>
                    </div>
                </div>
            </div>
             
             
             
             
             <?php if($wg24themeoptionpanel_productlayout_prallax=='left' || $wg24themeoptionpanel_productlayout_prallax=='right'){ ?>
               </div>
                <!-- / Right side -->
                    <?php if($wg24themeoptionpanel_productlayout_prallax=='right'){ ?>
                            <!--  left side -->
                            <aside class="col-sm-4 col-md-3 col-lg-3">
                                 <?php echo $column_left ?>
                            </aside>
                            <!-- / left side -->
                            <!-- Right side -->
                           <?php } ?>   
                
                
            </div>
          <?php } ?>
        </div>
    </div>
</section>
<!-- / product details -->
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
    $.ajax({
    url: 'index.php?route=product/product/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
            $('#recurring-description').html('');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    if (json['success']) {
            $('#recurring-description').html(json['success']);
            }
            }
    });
            });
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
    $.ajax({
    url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
            dataType: 'json',
            beforeSend: function() {
            $('#button-cart').button('loading');
            },
            complete: function() {
            $('#button-cart').button('reset');
            },
            success: function(json) {
            $('.alert, .text-danger').remove();
                    $('.form-group').removeClass('has-error');
                    if (json['error']) {
            if (json['error']['option']) {
            for (i in json['error']['option']) {
            var element = $('#input-option' + i.replace('_', '-'));
                    if (element.parent().hasClass('input-group')) {
            element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            } else {
            element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
            }
            }
            }

            if (json['error']['recurring']) {
            $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
            }

            // Highlight any found errors
            $('.text-danger').parent().addClass('has-error');
            }

            if (json['success']) {
            $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    $('#cart > button').html('<span class="fa fa-shopping-bag"></span><span id="cart-total" class="cart-top-title">' + json['total'] + '</span>');
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
            }
            },
            error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
    });
            });
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
    pickTime: false
            });
            $('.datetime').datetimepicker({
    pickDate: true,
            pickTime: true
            });
            $('.time').datetimepicker({
    pickDate: false
            });
            $('button[id^=\'button-upload\']').on('click', function() {
    var node = this;
            $('#form-upload').remove();
            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
            $('#form-upload input[name=\'file\']').trigger('click');
            if (typeof timer != 'undefined') {
    clearInterval(timer);
    }

    timer = setInterval(function() {
    if ($('#form-upload input[name=\'file\']').val() != '') {
    clearInterval(timer);
            $.ajax({
            url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                    $(node).button('loading');
                    },
                    complete: function() {
                    $(node).button('reset');
                    },
                    success: function(json) {
                    $('.text-danger').remove();
                            if (json['error']) {
                    $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                    }

                    if (json['success']) {
                    alert(json['success']);
                            $(node).parent().find('input').val(json['code']);
                            var file_name = json['filename'];
                            $('.btn-block').prop('title', file_name);
                    }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
            });
    }
    }, 500);
            });
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();
            $('#review').fadeOut('slow');
            $('#review').load(this.href);
            $('#review').fadeIn('slow');
            });
            $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');
            $('#button-review').on('click', function() {
    $.ajax({
    url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
            type: 'post',
            dataType: 'json',
            data: $("#form-review").serialize(),
            beforeSend: function() {
            $('#button-review').button('loading');
            },
            complete: function() {
            $('#button-review').button('reset');
            },
            success: function(json) {
            $('.alert-success, .alert-danger').remove();
                    if (json['error']) {
            $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
            }

            if (json['success']) {
            $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']:checked').prop('checked', false);
            }
            }
    });
            });
            $(document).ready(function() {
    $('.thumbnails').magnificPopup({
    type:'image',
            delegate: 'a',
            gallery: {
            enabled:true
            }
    });
            });
//--></script>
<?php echo $footer; ?>
