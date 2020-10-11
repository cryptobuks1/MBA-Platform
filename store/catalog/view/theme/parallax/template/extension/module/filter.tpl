   <!--  catalog  -->
    <div class="catalog-area padding-top-product">
        <div class="catalog-inner">
            <h2 class="product-hadding"><span><?php echo $heading_title; ?></span></h2>
            <form>
            <div class="catalog-box">
                <?php foreach ($filter_groups as $filter_group) { ?>  
                <div class="catalog-price-box">
                    <div class="catalog-title"><?php echo $filter_group['name']; ?></div>
                    <div class="price-box">
                        <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
        <?php foreach ($filter_group['filter'] as $filter) { ?>
        <div class="checkbox">
          <label>
            <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
            <?php echo $filter['name']; ?>
            <?php } else { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" />
            <?php echo $filter['name']; ?>
            <?php } ?>
          </label>
        </div>
        <?php } ?>
      </div>
                    </div>
                </div>
                   <?php } ?>
    <button type="button" id="button-filter" class="btn btn-primary"><?php echo $button_filter; ?></button>
    <input type="button" id="button-filterreset"  class="btn btn-primary" value="Reset"/>
            </div>
            </form> 
        </div>
    </div>
    <!-- / catalog -->
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	filter = [];

	$('input[name^=\'filter\']:checked').each(function(element) {
		filter.push(this.value);
	});

	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});

$('#button-filterreset').on('click', function() {
	location = '<?php echo $action; ?>';
});



//--></script>
