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
      <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
      <div class="row">
        <div class="col-sm-4">
          <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
        </div>
        <div class="col-sm-3">
          <select name="category_id" class="form-control">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-3">
          <label class="checkbox-inline">
            <?php if ($sub_category) { ?>
            <input type="checkbox" name="sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="sub_category" value="1" />
            <?php } ?>
            <?php echo $text_sub_category; ?></label>
        </div>
      </div>
      <p>
        <label class="checkbox-inline">
          <?php if ($description) { ?>
          <input type="checkbox" name="description" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="description" value="1" id="description" />
          <?php } ?>
          <?php echo $entry_description; ?></label>
      </p>
      <div class="button-set">
      <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-button gray9-bg white" />
      </div>
      <h2><?php echo $text_search; ?></h2>
      
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
                                                <ul class="products-grid row medium-products">
                                                     <?php foreach ($products as $product) { ?>
                                                    <!-- item -->
                                                            <li class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
                                                            </li>
                                                    <!-- / item -->
                                                    <?php } ?>
                                                </ul>
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
                                    
            <?php } else{ ?>
            <p><?php echo $text_empty; ?></p>
        
            <?php } ?>
                                </div>
                            </aside>
                            <!-- / Right side -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / category product -->
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>