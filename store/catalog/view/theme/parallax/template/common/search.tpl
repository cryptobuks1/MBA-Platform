<form id="searchbox">
    <div class="form-search" id="search">
        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control font-capitalize" />
        <button class="white gray9-bg" type="button">
            <i class="fa fa-search"></i>
        </button>
    </div>
     <?php if ($categories) { ?>
    <div class="cat-search">
        <select id="catsearch" class="searchbox" name="catsearch">
            <option value="0" selected="selected">
                <?php  if(isset($wg24themeoptionpanel_t_category_prallax)) {
                     echo  html_entity_decode($wg24themeoptionpanel_t_category_prallax);
                }
                ?>
            </option>
                <?php foreach ($categories as $category) { ?> 
                <option value="<?php echo $category['href']; ?>"> <?php echo $category['name']; ?></option>
                <?php foreach ($category['children'] as $child) { ?>
                <option value="<?php echo $child['href']; ?>">-<?php echo $child['name']; ?></option>
                <?php } ?>
                <?php } ?> 
        </select>
         <?php } ?> 
    </div>
</form>
  <script type="text/javascript"><!--
// live search
$('#search input[name=\'search\']').autocomplete({
	'source': function(request, response) {
              var cateid=$("#catsearch .dd-select input.dd-selected-value").val();
		$.ajax({
			url: 'index.php?route=common/search/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request)+'&category_id='+cateid,
			dataType: 'json',
			success: function(json) {
                             console.log(json);
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id'],
                                                price: item['price'],
						special: item['special'],
                                                thumb: item['thumb'],
                                                 href: item['href']
					}
				}));
			},
                 error: function(json){
          console.log(json);
      }
                        
		});
	}
	
});
//--></script>
  
  
