jQuery(document).ready(function($) {
 //$("#tabs").tabs();
    // Fade out the save message
$('.fade1').delay(1000).fadeOut(1000);
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 210 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 255 );
		return this;
	}
	$("#wg24-popup-patterns-save").center();
	$("#wg24-popup-save").center();
	$("#wg24-popup-reset").center();
			
	$(window).scroll(function() { 
                $("#wg24-popup-patterns-save").center();
		$("#wg24-popup-save").center();
		$("#wg24-popup-reset").center();
	});
			
	$(".radio-box-picture").click(function(){
		$(this).parent().parent().find(".radio-box-picture").removeClass("add-radio-picture");
		$(this).addClass("add-radio-picture");
	});
	$(".for-radio-picture-label").hide();
	$(".radio-box-picture").show();
	$(".of-radio-img-radio").hide();

	$(".wg24-radio-tile-img").click(function(){
		$(this).parent().parent().find(".wg24-radio-tile-img").removeClass("wg24-radio-tile-selected");
		$(this).addClass("wg24-radio-tile-selected");
	});
        
	$(".of-radio-tile-label").hide();
	$(".wg24-radio-tile-img").show();
	$(".wg24-radio-tile-radio").hide();
         var token=$('.panel-body').attr('title');
       
			//AJAX Upload
			$(".upload_button").each(function(){
			var selected_object = $(this);
			var selected_id = $(this).attr("id");	
			new AjaxUpload(selected_id, {
				 action: 'index.php?route=extension/module/wg24themeoptionpanel/update&token='+token,
				  name: selected_id, 
				  data: {
						action: "of_ajax_post_action",
						type: "pattern_upload",
						data: selected_id },
				  autoSubmit: true,
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						selected_object.text("Uploading");
						this.disable(); 
						interval = window.setInterval(function(){
							var text = selected_object.text();
							if (text.length <13){	selected_object.text(text + "."); }
							else { selected_object.text("Uploading"); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					selected_object.text("Upload");	
					this.enable();
					
					if(response.search("Upload Error") > -1){
						var return_data = "<span class='upload-error'>" + response + "</span>";
						$(".upload-error").remove();
						selected_object.parent().after(return_data);
					
					}
					else{
					var return_data = '<img class="for-body-picture" id="image_'+selected_id+'" src="'+response+'" alt="" />';
                                       
						$(".upload-error").remove();
						$("#image_" + selected_id).remove();	
						selected_object.parent().after(return_data);
						$("img#image_"+selected_id).fadeIn();
						selected_object.next("span").fadeIn();
						selected_object.parent().prev("input").val(response);      
					}
				  }
				});
			
			});
                        
                         $(".reset_button").click(function(){
			
					var selected_object = jQuery(this);
					var selected_id = jQuery(this).attr("id");
					var theID = jQuery(this).attr("title");	
					 var url ='index.php?route=extension/module/wg24themeoptionpanel/update&token='+token;
				
					var data = {
						action: "of_ajax_post_action",
						type: "image_reset",
						data: selected_id
					};
					$.post(url, data, function(response) {
                                              var image_to_remove = jQuery("#image_" + theID);
						var button_to_hide = jQuery("#reset_" + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						selected_object.parent().prev("input").val("");
					});
					
					return false; 
					
				});  
                        
			
                                        $('.selectColor').each(function(){
                                        var Othis = this; //cache a copy of the this variable for use inside nested function
                                        var initialColor = $(Othis).next('input').attr('value');
                                        $(this).ColorPicker({
                                        color: initialColor,
                                        onShow: function (colpkr) {
                                        $(colpkr).fadeIn(500);
                                        return false;
                                        },
                                        onHide: function (colpkr) {
                                        $(colpkr).fadeOut(500);
                                        return false;
                                        },
                                        onChange: function (hsb, hex, rgb) {
                                        $(Othis).children('div').css('backgroundColor', '#' + hex);
                                        $(Othis).next('input').attr('value','#' + hex);
                                }
                                });
                                }); //end color picker
                                
       
                                     $(".save-button").click(function(){
                                         $('.save-button').button('loading');
                                       var serializeddata =$("#for_form").serialize(); 
					var url ='index.php?route=extension/module/wg24themeoptionpanel/update&token='+token;
					var data1 = {
						type: "wg24administrationvalue",
						action: "of_ajax_post_action",
						data: serializeddata
					};
					$.post(url, data1, function(response) {
						var success = $("#wg24-popup-save");
						var loading = $(".wg24-loading-img");
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
                                                   $('.save-button').button('reset');
						   success.fadeOut(); 						
						}, 2000);
					});
					
					return false; 

					
				});   
	styleSelect = {
		init: function () {
		$(".for-body-selected").each(function () {
			$(this).prepend("<span>" + $(this).find(".select option:selected").text() + "</span>");
		});
		$(".select").on("change", function () {
			$(this).prev("span").replaceWith("<span>" + $(this).find("option:selected").text() + "</span>");
		});
		
		}
	};
        styleSelect.init()


	$('.sw-show').click(function(){
		var parent = $(this).parents('.switch');
		$('.sw-hide',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$('.sw-hide').click(function(){
		var parent = $(this).parents('.switch');
		$('.sw-show',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});
 }); 
 
function toggleLanguageFlags(elt)
{
	$(elt).parents('.displayed_flag').siblings('.language_flags').toggle();
}
function changeLanguage(field, fieldsString, id_language_new, iso_code)
{
    $('div[id^='+field+'_]').hide();
	var fields = fieldsString.split('¤');
	for (var i = 0; i < fields.length; ++i)
	{
		$('div[id^='+fields[i]+'_]').hide();
		$('#'+fields[i]+'_'+id_language_new).show();
		$('#'+'language_current_'+fields[i]).attr('src', 'language/' + iso_code +'/'+  iso_code +'.png');
	}
	$('#languages_' + field).hide();
	id_language = id_language_new;
}    
                
              
              