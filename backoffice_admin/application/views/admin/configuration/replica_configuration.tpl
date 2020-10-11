
<div id="span_js_messages" style="display:none;">
    <span id="msg1">{lang('facebook_url_is_required')}</span>
    <span id="msg2">{lang('twitter_url_is_required')}</span>
    <span id="msg3">{lang('youtube_url_is_required')}</span>
    <span id="msg4">{lang('instagram_url_is_required')}</span>
    <span id="msg5">{lang('linkedin_url_is_required')}</span>
    <span id="msg6">{lang('google_plus_url_is_required')}</span>
    <span id="msg7">{lang('youtube_url_is_not_valid')}</span>
    <span id="msg8">{lang('facebook_url_is_not_valid')}</span>
    <span id="msg9">{lang('google_plus_url_is_not_valid')}</span>
    <span id="msg10">{lang('linkedin_url_is_not_valid')}</span>
    <span id="msg11">{lang('twitter_url_is_not_valid')}</span>
    <span id="msg12">{lang('instagram_url_is_not_valid')}</span>
    <span id="msg13">{lang('you_must_enter_main_matter')}</span>
    <span id="msg14">{lang('title_url_is_required')}</span>
    <span id="msg15">{lang('address_url_is_required')}</span>

</div>    

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab">
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('top_banner')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            </a> 
            <div id="tab" class="panel-collapse panel-collapse collapse">
                <div class="panel-body">
                    {form_open_multipart('admin/configuration/content_management','role="form" class="" name="upload_materials" id="upload_materials1"')}
                        <div class="form-group">
                            <label class="control-label required">{lang('upload_top_banner')}</label>
                                <div data-provides="fileupload" class="bg_file_upload"> 
                                    <input name="banner_image" id="banner_image" type="file" >                                           
                                </div>
                                <span class="help-block m-b-none">{lang('please_choose_a_png_file.')}</span>
                                <span class="help-block m-b-none">{lang('max_size_should_2MB')}</span>     
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subtitle">{lang('current_top_banner')}</label>
                              {if isset($content['top_banner'])}
                                  <input class="form-control" type="text" value="{$content['top_banner']}" readonly='true' style="overflow: hidden;white-space: nowrap;">
                              {else}
                                  <input class="form-control" type="text" value="banner-tchnoly.jpg" readonly='true' style="overflow: hidden;white-space: nowrap;"> 
                              {/if}
                        </div>
                      <div class="form-group">
                          <button class="btn btn-sm btn-primary" name="submit_image" id="submit_image" type="submit" value="submit">{lang('upload')}</button>
                      </div>

                    {form_close()}             
                </div>                                        
            </div>
            
    </div>

{*    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-1">
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('moving_banner')} 
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-1"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <div id="tab-1" class="panel-collapse panel-collapse collapse">
                <div class="panel-body"> 
                    {form_open_multipart('admin/configuration/content_management','role="form" class=""  name="upload_materials" id="upload_materials1"')}
                        <div class="form-group">
                            <label class="control-label required">{lang('upload_moving_banner')} 1</label>
                            <div data-provides="fileupload" class="bg_file_upload">
                                <input name="moving_banner1" id="moving_banner1" type="file" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subtitle">{lang('current_moving_banner')}1</label>
                            {if isset($content['moving_banner1'])}
                                <input class="form-control" type="text" value="{$content['moving_banner1']}" readonly='true' style="overflow: hidden;white-space: nowrap;">
                            {else}
                                <input class="form-control" type="text" value="MLM-Companies.jpg" readonly='true' style="overflow: hidden;white-space: nowrap;"> 
                            {/if}
                        </div>

                        <div class="form-group">
                            <label class="control-label required">{lang('upload_moving_banner')} 2</label>
                            <div data-provides="fileupload" class="bg_file_upload"> 
                                <input name="moving_banner2" id="moving_banner2" type="file" >
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label" for="subtitle">{lang('current_moving_banner')}2</label>
                            {if isset($content['moving_banner2'])}
                                <input class="form-control" type="text" value="{$content['moving_banner2']}" readonly='true' style="overflow: hidden;white-space: nowrap;">
                            {else}
                                <input class="form-control" type="text" value="test.png" readonly='true' style="overflow: hidden;white-space: nowrap;"> 
                            {/if}
                        </div>

                        <div class="form-group">
                            <label class="control-label required">{lang('upload_moving_banner')} 3</label>
                            <div data-provides="fileupload" class="bg_file_upload">
                                <input name="moving_banner3" id="moving_banner3" type="file" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subtitle">{lang('current_moving_banner')}3</label>
                            {if isset($content['moving_banner3'])}
                                <input class="form-control" type="text" value="{$content['moving_banner3']}" readonly='true' style="overflow: hidden;white-space: nowrap;">
                            {else}
                               <input class="form-control" type="text" value="mlm-world-mlm-software-development.jpg" readonly='true' style="overflow: hidden;white-space: nowrap;"> 
                            {/if}
                        </div>

                        <div class="form-group">
                            <label class="control-label required">{lang('upload_moving_banner')} 4</label>
                            <div data-provides="fileupload" class="bg_file_upload"> 
                                <input name="moving_banner4" id="moving_banner4" type="file" >            
                            </div>
                            <span class="help-block m-b-none">{lang('please_choose_a_png_file.')}</span>
                            <span class="help-block m-b-none">{lang('max_size_should_2MB')}</span>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="subtitle">{lang('current_moving_banner')}4</label>
                            {if isset($content['moving_banner4'])}
                                <input class="form-control" type="text" value="{$content['moving_banner4']}" readonly='true' style="overflow: hidden;white-space: nowrap;">
                            {else}
                                <input class="form-control" type="text" value="mlm_software.png" readonly='true' style="overflow: hidden;white-space: nowrap;">
                            {/if}
                        </div>
                        
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" name="submit_movbanner" id="submit_movbanner" type="submit" value="submit" >{lang('upload')}</button>
                        </div>

                    {form_close()}
                </div>
            </div>
            </a>
    </div> *}
                            
    <div class="panel panel-default">
     <a data-toggle="collapse" data-parent="#accordion" href="#tab-3">
            <div class="panel-heading">
                <h4 class="panel-title">{lang('content_management')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-3"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <div id="tab-3" class="panel-collapse panel-collapse collapse">
                <div class="panel-body"> 
                    {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "content_form"  id="content_form"')}
                    {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label required" for="subtitle">{lang('sub_title')}</label>
                              <input class="form-control"  id="subtitle"  name="subtitle" title="{lang('main_matter')}" value="{$subtitle}">
                              {form_error('subtitle')}
                        </div>

                        <div class="form-group">
                          <label class="control-label required" for="replica_content_main">{lang('main_matter')}</label>
                            <textarea class="ckeditor form-control"  id="replica_content_main"  name="replica_content_main" title="{lang('main_matter')}"  rows="6">{$description}</textarea>
                            {form_error('replica_content_main')}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="replica_content" id="replica_content" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    {form_close()}
                </div>  
            </div>
            </a> 
    </div>
                                
  {*  <div class="panel panel-default">
     <a data-toggle="collapse" data-parent="#accordion" href="#tab-4"> 
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('video_banner')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-4"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <div id="tab-4" class="panel-collapse panel-collapse collapse">
                 <div class="panel-body">
                    {form_open_multipart('admin/configuration/content_management','role="form" class="" name="youtube_profile" id="youtube_profile"')}
                    {include file="layout/error_box.tpl"}
                        <div class="form-group">                              
                            <label class="control-label required" for="new_passcode">{lang('youtube_url')}</label>
                            <input class="form-control" type="text" name="banner_link" id="banner_link" {if isset($content['video'])}value = "{$content['video']}"{else}value="https://www.youtube.com/watch?v=zd92vBBv1r8"{/if} />
                            {form_error('banner_link')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://www.youtube.com/example.')}</p>
                        </div>

                        <div class="form-group">
                                <button class="btn btn-sm btn-primary" name="submit_video" id="submit_video" type="submit" value="submit">{lang('update')}</button>
                        </div>
                    {form_close()}
                </div>
            </div>
            </a> 
    </div> 
                        
    <div class="panel panel-default">
     <a data-toggle="collapse" data-parent="#accordion" href="#tab-5">
            <div class="panel-heading">
                <h4 class="panel-title">{lang('social_profile')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-5"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            <div id="tab-5" class="panel-collapse panel-collapse collapse">
                <div class="panel-body">  
                    {form_open_multipart('admin/configuration/content_management','role="form" class="" name="socail_profile11" id="socail_profile11"')}
                    {include file="layout/error_box.tpl"}
                        <div class="form-group">                           
                            <label class=" control-label" for="new_passcode">{lang('facebook')}</label>
                            <input class="form-control" type="text" name="facebook" id="facebook" {if isset($content['facebook'])}value = "{$content['facebook']}"{/if}/>
                            {form_error('facebook')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://www.facebook.com/example.')}</p>
                        </div>

                        <div class="form-group">                           
                            <label class="control-label" for="new_passcode">{lang('twitter')}</label>
                            <input class="form-control" type="text" name="twitter" id="twitter" {if isset($content['twitter'])}value = "{$content['twitter']}"{/if} />
                            {form_error('twitter')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://www.twitter.com/example.')}</p>
                        </div>

                        <div class="form-group">                           
                            <label class="control-label" for="new_passcode">{lang('linkedin')}</label>
                            <input class="form-control" type="text" name="linkedin" id="linkedin" {if isset($content['linkedin'])}value = "{$content['linkedin']}"{/if}/>
                            {form_error('linkedin')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:http://www.linkedin.com/in/example.')}</p>
                        </div>

                        <div class="form-group">                           
                            <label class="control-label" for="new_passcode">{lang('google_plus')}</label>
                            <input class="form-control" type="text" name="google_plus" id="google_plus" {if isset($content['google_plus'])}value = "{$content['google_plus']}"{/if}/>
                            {form_error('google_plus')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://plus.google.com/example.')}</p>
                        </div>

                        <div class="form-group">                           
                            <label class="control-label" for="new_passcode">{lang('youtube')}</label>
                            <input class="form-control" type="text" name="youtube" id="youtube" {if isset($content['youtube'])}value = "{$content['youtube']}"{/if}/>
                            {form_error('youtube')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://www.youtube.com/example.')}</p>
                        </div>

                        <div class="form-group">                           
                            <label class="control-label" for="new_passcode">{lang('instagram')}</label>
                            <input class="form-control" type="text" name="instagram" id="instagram" {if isset($content['instagram'])}value = "{$content['instagram']}"{/if}/>
                            {form_error('instagram')}
                            <span class="help-block" ></span>
                            <p style="color: #737373;">{lang('Eg:https://www.instagram.com/example.')}</p>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" name="submit_social" id="submit_social" type="submit" value="submit">{lang('update')}</button>
                        </div>

                    {form_close()}
                </div>
            </div>
            </a> 
    </div>*}

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-6">
            <div class="panel-heading">
                <h4 class="panel-title">  {lang('terms_and_conditions')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-6"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_form"  id="terms_form"')}                                             
                <div id="tab-6" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                    {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                                <textarea class="ckeditor form-control"  id="content_terms"  name="content_terms" title="{lang('main_matter')}"  rows="6">{if isset($content['terms'])}{$content['terms']}{else}
                                All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more{/if}</textarea>
                                {form_error('content_terms')}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_term" id="submit_term" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    </div>   
                </div>
            {form_close()}
            </a> 
    </div>

    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-7">
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('privacy_policy')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-7"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "policy_form"  id="policy_form"')}
                <div id="tab-7" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                        {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                            <textarea class="ckeditor form-control"  id="content_policy"  name="content_policy" title="{lang('main_matter')}" rows="6">{if isset($content['policy'])}{$content['policy']}{else}
                              All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more.
                            {/if}
                            </textarea>
                            {form_error('content_policy')}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" name="submit_policy" id="submit_policy" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    </div>
                </div> 
            {form_close()}
            </a>
    </div>
                
    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-8">
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('about_us')} 
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-8"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "about_form"  id="about_form"')}
                <div id="tab-8" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                        {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                            <textarea class="ckeditor form-control"  id="content_about"  name="content_about" title="{lang('about_us')}" rows="6">{if isset($content['about_us'])}{$content['about_us']}{else}
                            The Infinite MLM software is an entire solution for all type of business plan like Binary,Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP™. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet, Replicating Website, E-Pin, E-Commerce Shopping Cart,Web Design{/if}
                            </textarea>
                            {form_error('content_about')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_about" id="submit_policy" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    </div> 
                </div>
            {form_close()} 
            </a>
    </div>
                
    <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-9">
            <div class="panel-heading">
                <h4 class="panel-title"> {lang('contact_us')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-9"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
                {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "address_form"  id="address_form"')}
                    <div id="tab-9" class="panel-collapse panel-collapse collapse">
                        <div class="panel-body">
                            {include file="layout/error_box.tpl"}    
                                <div class="form-group">
                                  <label class=" control-label" for="txtDefaultHtmlArea">{lang('address')}</label>
                                    <textarea class="ckeditor form-control"  id="address"  name="address" title="{lang('contact_us')}" rows="6">{if isset($content['address'])}{$content['address']}{else}
                                    2nd Floor, TK Tower, Kettangal,NIT Campus (P.O.), Calicut - 673601, Kerala,{/if}</textarea>
                                    {form_error('address')}
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary"  name="submit_address" id="submit_about" type="submit" value="{lang('update')}" > {lang('update')}</button>
                                </div>
                        </div>
                    </div>  
                {form_close()}
                </a> 
    </div>
    
   {* <div class="panel panel-default">
    <a data-toggle="collapse" data-parent="#accordion" href="#tab-10">
            <div class="panel-heading">
                <h4 class="panel-title">  {lang('upgrade_terms_and_conditions')}
                    <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#tab-10"> <i class="glyphicon glyphicon-chevron-down"></i> </span> 
                </h4>
            </div>
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_form"  id="terms_form"')}                                             
                <div id="tab-10" class="panel-collapse panel-collapse collapse">
                    <div class="panel-body">
                    {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                                <textarea class="ckeditor form-control"  id="content_terms"  name="content_terms" title="{lang('main_matter')}"  rows="6">{if isset($content['upgrade_terms_cond'])}{$content['upgrade_terms_cond']}{else}
                                All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more{/if}</textarea>
                                {form_error('content_terms')}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_upgrade_term" id="submit_upgrade_term" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    </div>   
                </div>
            {form_close()}
            </a> 
    </div>*}


{include file="common/notes.tpl" notes=lang('note_replication_configuration_page')}
                    