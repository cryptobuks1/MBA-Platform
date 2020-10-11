{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_company_name')}</span>
    <span id="validate_msg2">{lang('non_valid_file')}</span>
    <span id="validate_msg3">{lang('only_png_jpg')}</span>
    <span id="validate_msg4">{lang('you_must_enter_email')}</span>
    <span id="validate_msg5">{lang('you_must_enter_valid_email')}</span>
    <span id="validate_msg15">{lang('you_must_enter_valid_url')}</span>
    <span id="validate_msg6">{lang('you_must_enter_phone')}</span>
    <span id="validate_msg7">{lang('you_must_enter_valid_phone')}</span>
    <span id="validate_msg8">{lang('you_must_company_address')}</span>
    <span id="validate_msg9">{lang('your_email_address_must_be_in_the_format_of_name@domain.com')}</span>
    <span id="validate_msg10">{lang('your_url_address_must_be_in_the_format')}</span>
    <span id="validate_msg11">{lang('digits_only')}</span>
    <span id="validate_msg12">{lang('facebook_url_is_required')}</span>
    <span id="validate_msg13">{lang('twitter_url_is_required')}</span>
    <span id="validate_msg14">{lang('instagram_url_is_required')}</span>
    <span id="validate_msg20">{lang('google_plus_url_is_required')}</span>
    <span id="validate_msg16">{lang('facebook_url_is_not_valid')}</span>
    <span id="validate_msg17">{lang('twitter_url_is_not_valid')}</span>
    <span id="validate_msg18">{lang('instagram_url_is_not_valid')}</span>
    <span id="validate_msg19">{lang('google_plus_url_is_not_valid')}</span>
    <span id="validate_msg21">{lang('max_10_digit_allowed')}</span>
    <span id="validate_msg22">{lang('max_100_char_allowed')}</span>
    <span id="validate_msg23">{lang('please_enter_atleast_5_digits')}</span>
    <span id="validate_msg24">{lang('you_must_enter_facebook_followers_count')}</span>
    <span id="validate_msg25">{lang('you_must_enter_twitter_followers_count')}</span>
    <span id="validate_msg26">{lang('you_must_enter_instagram_followers_count')}</span>
    <span id="validate_msg27">{lang('you_must_enter_google_followers_count')}</span>
    <span id="validate_msg28">{lang('you_must_enter_facebook_url')}</span>
    <span id="validate_msg29">{lang('you_must_enter_twitter_url')}</span>
    <span id="validate_msg30">{lang('you_must_enter_instagram_url')}</span>
    <span id="validate_msg31">{lang('you_must_enter_google_url')}</span>
</div>

<main>
  <div class="tabsy">
    <input type="radio" id="tab1" name="tab" {if $tab1} checked {/if}>
    <label class="tabButton" for="tab1">{lang('site_information')}</label>
        <div class="tab">
            <div class="content">
                {form_open_multipart('admin/configuration/site_information','role="form" class="" method="post"  name="site_config" id="site_config"')}
                {include file="layout/error_box.tpl"}
            
                <div class="form-group">
                    <label class="control-label required" for="co_name">{lang('company_name')}</label>
                      <input type="text" class="form-control" name="co_name" id="co_name" autocomplete="Off"  value="{$site_info_arr["co_name"]}">
                      {form_error('co_name')}
                </div>
            
                <div class="form-group">
                    <label class="control-label required" for="company_address">{lang('company_address')}</label>
                      <textarea class="form-control required" name="company_address" id="company_address"  rows="" cols="30"   autocomplete="Off" >{$site_info_arr["company_address"]}</textarea>
                      {form_error('company_address')}
                </div>
                
                <input type="hidden" name="def_lan" id="def_lan" value="{$default_lang}" />
            
                <div class="form-group">
                    <label class="control-label required" for="email">{lang('email')}</label>
                    
                    <div class="input-group m-b">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input class="form-control" type="text"  name="email" id="email"   autocomplete="Off"  value="{$site_info_arr["email"]}">
                     {form_error('email')}
                    </div>
                    
                      
                </div>
            
                <div class="form-group">
                    <label class="control-label required" for="img_logo">{lang('phone')}</label>
                    
                    <div class="input-group m-b">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input class="form-control" type="text"  name="phone" id="phone" autocomplete="Off" value="{$site_info_arr["phone"]}" maxlength="10">
                    <span id="errmsg1"></span>
                    {form_error('phone')}
                </div>
                    
                    
                    
                </div>
            
          <hr class="new_line" />

            <div class="col-sm-6 padding_both">
                 <div class="panel panel-info">
                     <div class="panel-body">                             
                             <div class="fileupload fileupload-new" data-provides="fileupload" >
                                 <div class="thumb pull-right m-l m-t-xs avatar">
                                     <div class="fileupload-new thumbnail" style=""><img src="{$SITE_URL}/uploads/images/logos/{$site_info_arr["logo"]}" alt="" value="{$site_info_arr["logo"]}" alt="...">
                                     </div>
                                     <div class="fileupload-preview fileupload-exists thumbnail" ></div>
                                 </div>
                                 <div class="user-edit-image-buttons">
                                     <div class="clear"> <a href="" class="text-info block m-b-xs">{lang('logo')} <i class="icon-twitter"></i></a>
                                     <span class="btn btn-light-grey-new btn-file">
                                         <span class="fileupload-new"><button type="button" class="btn btn-addon btn-info"> <i class="fa fa-arrow-circle-o-up"></i> {lang('upload')} </button></span>
                                         <span class="btn fileupload-exists btn-warning"><i class="fa fa-picture"></i> {lang('Change')}</span>
                                         <input type="file" id="img_logo" name="img_logo"  value="{$site_info_arr["logo"]}">
                                     </span>
                                     <a href="#" class="btn fileupload-exists btn-info" data-dismiss="fileupload">
                                         <i class="fa fa-times"></i>{lang('Remove')}
                                     </a>
                                 </div>
                                 </div>
                         </div>             
                     </div>
                 </div>
           </div> 
            <div class="col-sm-6 padding_both_small">
                     <div class="panel panel-info">
                        <div class="panel-body">
                            <div class="fileupload fileupload-new " data-provides="fileupload" >
                                <div class="thumb pull-right m-l m-t-xs avatar">
                                     <div class="fileupload-new thumbnail"><img src="{$SITE_URL}/uploads/images/logos/{$site_info_arr["favicon"]}" alt="" value="{$site_info_arr["favicon"]}">
                                       </div>
                                     <div class="fileupload-preview fileupload-exists thumbnail" ></div>
                                </div>
                                <div class="user-edit-image-buttons">
                                    <div class="clear"> <a href="" class="text-info block m-b-xs">{lang('icon')} <i class="icon-twitter"></i></a>
                                        <span class="btn btn-light-grey-new btn-file"><span class="fileupload-new"><button type="button" class="btn btn-addon btn-info"> <i class="fa fa-arrow-circle-o-up"></i> {lang('upload')} </button></span><span class="btn fileupload-exists btn-warning"><i class="fa fa-picture"></i> {lang('Change')}</span>                                           
                                            <input type="file" id="favicon" name="favicon"  value="{$site_info_arr["favicon"]}">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-info" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i>{lang('Remove')}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
          
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" name="site" id="site" value="{lang('update')}">{lang('update')}</button>
                </div>

                {form_close()}  
            </div>
        </div>

        <input type="radio" id="tab3" name="tab" {if $tab3} checked {/if}>
            <label class="tabButton" for="tab3">{lang('social_profile')}</label>
            <div class="tab">
                <div class="content">
                     {form_open('admin/configuration/site_information','role="form"  method="post"  name="link_config" id="link_config"')}
                        <input type="hidden" name="active_tab" id="active_tab" value="">
                <!-------Facebook -------> 
                <div class="col-sm-8 padding_both">
                        <div class="form-group">
                            <label class="letter_width" for="fb_count"> {lang('fb_link')}</label>
                            <input type="text" class="form-control" name="fb_link" id="fb_link" value="{$social_link[0].fb_link}" placeholder="{lang('Eg:https://www.facebook.com/example')}" size="250"/>
                            {form_error('fb_link')}
                            
                        </div>
                        </div>
                         <div class="col-sm-4 padding_both_small">
                        <div class="form-group m-t-t-t">
                            <input type="text" class="form-control" size="45" name="fb_count" id="fb_count" value="{$social_count[0].fb_count}" placeholder="{lang('count')}">
                              {form_error('fb_count')}
                               
                        </div>
                        </div>
                <!-------Facebook end -------> 
                
                <!-------Twitter ------------> 
                <div class="col-sm-8 padding_both">
                        <div class="form-group">           
                            <label class="letter_width" for="twitter_count">{lang('twitter_link')}</label>
                            <input type="text" class="form-control" name="twitter_link" id="twitter_link" value="{$social_link[0].twitter_link}" size="250" placeholder="{lang('Eg:https://www.twitter.com/example')}"/>
                            {form_error('twitter_link')}
                            
                        </div>
                        </div>
                         <div class="col-sm-4 padding_both_small">
                        <div class="form-group m-t-t-t">
                            <input type="text" class="form-control" name="twitter_count" id="twitter_count" value="{$social_count[0].twitter_count}" placeholder="{lang('count')}" size="45">
                          {form_error('twitter_count')}
                          
                        </div>  
                        </div>
                <!-------Twitter end ---------> 
                
                <!-------Instagram ------------> 
                <div class="col-sm-8 padding_both">
                        <div class="form-group">
                            <label class="letter_width" for="inst_count">{lang('inst_link')}</label>
                            <input type="text" class="form-control" name="inst_link" id="inst_link" value="{$social_link[0].inst_link}" size="250" placeholder="{lang('Eg:https://www.instagram.com/example')}">
                        
                            {form_error('inst_link')}
                        </div>
                        </div>
                         <div class="col-sm-4 padding_both_small">
                        <div class="form-group m-t-t-t">
                            <input type="text" class="form-control" name="inst_count" id="inst_count" value="{$social_count[0].inst_count}" placeholder="{lang('count')}" size="45">
                            {form_error('inst_count')}
                             
                        </div>
                        </div>
                <!-------Instagram end ------------>
                
                <!---------Google Plus ------------> 
                {* <div class="col-sm-8 padding_both">
                        <div class="form-group">
                            <label class="letter_width" for="gplus_count">{lang('gplus_link')}</label>
                            <input type="text" class="form-control" name="gplus_link" id="gplus_link" value="{$social_link[0].gplus_link}" size="250" placeholder="{lang('Eg:https://plus.google.com/example')}">
                            {form_error('gplus_link')}
                             
                        </div>
                        </div>
                         <div class="col-sm-4 padding_both_small">
                        <div class="form-group m-t-t-t">
                            <input type="text" class="form-control" name="gplus_count" id="gplus_count" value="{$social_count[0].gplus_count}" placeholder="{lang('count')}" size="45">
                            {form_error('gplus_count')}
                        </div>
                        </div> *}
                <!---------Google Plus end ------------>
                     <div class="col-sm-12 padding_both">
                        <div class="form-group"> 
                            <button class="btn btn-sm btn-primary m-t-md" name="update_social_count" id="update_social_count" value="update_social_count" >{lang('update')}</button>
                        </div>  
                      </div>
            
                    {form_close()}  
                </div>
            </div>
        </div>
</main>

{/block}