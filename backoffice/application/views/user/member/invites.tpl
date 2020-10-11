{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
        <span id="validate_msg1">{lang('enter_to_mail_id')}</span>
        <span id="validate_msg2">{lang('enter_subject')}</span>
        <span id="validate_msg3">{lang('enter_message')}</span>
        <input type = "hidden" name = "logo" id = "logo" value = "{$PUBLIC_URL}images/logos/{$site_info["logo"]}" >
    </div>
    
    {* <div class="b wrapper m-b-sm panel">
        <p>{lang('note_invite_banner_config')}</p>
    </div> *}
    
    <main>
        <div class="tabsy">
            <input type="radio" id="tab1" name="tab" checked>
            <label class="tabButton" for="tab1">{lang('email')}</label>
            <div class="tab">
                <div class="content">
                     
                        <legend><span class="fieldset-legend">{lang('email_invites')}</span></legend>
                            {if count($social_invite_email)>0}
                                {assign var="i" value="0"}
                                {assign var="class" value=""}
                                {foreach from=$social_invite_email item=v}
                                    <div class="testimonials-item">
                                        <div class="user"><img src="{$SITE_URL}/uploads/images/logos/Mail.png" alt=""></div>
                                        <div class="testimonials-content">
                                            <h3 class="user-name">{$v.subject}</h3>
                                            <span>{lang('email_invite')}</span>
                                            <div class="txt">
                                                <p>{$v.content}</p>
                                            </div>
                                            <div class="m-b-btn panel-body">
                                              {form_open('user/member/edit_invite_wallpost','method="post"')}
                                                            <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                                            <input type='hidden' id='type' name='type' value='{$v.type}'>
                                                  <button type="submit" class="btn btn-primary" value="preview" name="invite_email" id="invite_email">{lang('Preview')}</button>
                                              {form_close()}
                                            </div>
                                        </div>
                                    </div>
                            {/foreach}
                            {else}
                                <h4 align="center"> {lang('no_data')}</h4>
                            {/if}
                            {$result_per_page1}
                    
                    
                    
                        <legend><span class="fieldset-legend">{lang('email_invite_history')}</span></legend>
                            {if count($invite_history_details)>0}
                                {assign var="i" value=0}                   
                                {foreach from=$invite_history_details item=v}
                                    <div class="testimonials-item">
                                        <div class="user">
                                            <img src="{$SITE_URL}/uploads/images/logos/Mail.png" alt="">
                                        </div>
                                        <div class="testimonials-content">
                                            <h3 class="user-name">{$v.subject}</h3>
                                            <span><i class="glyphicon glyphicon-calendar text-primary m-r-xs"></i>{$v.date}  <i class="glyphicon glyphicon-envelope text-success m-r-xs"></i>{lang('email')} : {$v.mail_id}</span>
                                            <div class="txt">
                                                <p>{$v.message}</p>
                                            </div>
                                        </div>
                                    </div>
                            {/foreach}   
                            {else}
                                <h4 align="center">{lang('no_data')}</h4>
                            {/if}   
                        {$result_per_page2}
                    </div>
              
            </div>
            <input type="radio" id="tab3" name="tab">
            <label class="tabButton" for="tab3">{lang('banner')}</label>
            <div class="tab">
                <div class="content">
                    <div style="display:none;" class="alert alert-info col-md-12" id="banner_inv">Banner Invites URL Copied</div>
                    {if count($banners)>0}
                        {assign var="i" value="0"}
                        {assign var="class" value=""}
                        {foreach from=$banners item=v}
                            <div class="">
                              <div class="panel">
                                <div class="panel-body">
                                  <article class="zm-post-lay-d clearfix">
                                    <div class="zm-post-thumb f-left">
                                        <img src="{$SITE_URL}/uploads/images/banners/{$v.content}" alt="Banner Image" class="img-ban">
                                    </div>
                                    <div class="zm-post-dis f-right">
                                        <div class="zm-post-header">
                                            <h2 class="zm-post-title"><a href="#">{$v.subject}</a></h2>
                                            <div class="form-group">
                                              <textarea class="form-control textarea_height_fix" placeholder="link" disabled="" id="banner{$v.id}">{if $v.target_url == null}<a href="{$REPLICATION_URL}/{$LOG_USER_NAME}">{else}<a href="{$v.target_url}">{/if}<img src="{$SITE_URL}/uploads/images/banners/{$v.content}" height="150" width="250"></a></textarea>
                                            </div>
                                            <div class="col-sm-6 col-xs-6 padding_both_small">
                                                <div class="form-group">
                                                    <button type="button" id="{$v.id}" class="btn btn-primary banner_inv">{lang('copy')}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </article>
                                </div>
                              </div>
                            </div>       
                        {/foreach}  
                    {else}
                        <h4 align="center"> {lang('no_data')}</h4>
                    {/if}
                    {$result_per_page3} 
                </div>
            </div>
            <input type="radio" id="tab4" name="tab">
            <label class="tabButton" for="tab4">{lang('text_invite')}</label>
            <div class="tab">
                <div class="content"> 
                    <div style="display:none;" class="alert alert-info col-md-10" id="text_inv">Text Invites URL Copied</div> 
                    {assign var="i" value="0"}
                    {assign var="class" value=""}
                    {if count($invite_text)>0}
                        {foreach from=$invite_text item=v}
                            <div class="panel panel-default">
                                <div class="panel-body">
                                  <h4 class="text-center">{$v.subject}</h4>
                                    <hr>
                                    <div class="col-sm-12 padding_both">
                                    <div class="form-group">
                                        <label><i class="fa fa-calendar"></i> {$v.uploaded_date}</label>
                                        <textarea class="form-control textarea_height_fix" disabled="" id="text{$v.id}" name="mail_content">{if $MODULE_STATUS['replicated_site_status'] == "yes"}<a href="{$REPLICATION_URL}/{$LOG_USER_NAME}"> {else} <a href="{$base_url}"> {/if}{$v.content} </a></textarea>
                                    </div>
                                    </div>
                                    <div class="col-sm-8 padding_both_small">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary text_inv" id="{$v.id}">{lang('copy')}</button>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        {/foreach}
                    {else}
                        <h4 align="center"> {lang('no_data')}</h4>
                    {/if}
                    {$result_per_page4}
                </div>
            </div>
            <input type="radio" id="tab5" name="tab">
            <label class="tabButton" for="tab5">{lang('social_invites')}</label>
            <div class="tab">
                <div class="content">
                    <legend><span class="fieldset-legend">{lang('facebook')}</span></legend>
                    <div class="row">
                        {if count($social_invite_fb)>0}
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$social_invite_fb item=v}
                                <div class="testimonials-item">
                                    <div class="user">
                                        <img src="{$SITE_URL}/uploads/images/logos/fb.png" alt="">
                                    </div>
                                    <div class="testimonials-content">
                                        <h3 class="user-name">{$v.subject}</h3>
                                        <span>{lang('facebook_invite')}</span>
                                        <div class="txt"> <p>{$v.content}</p> </div>
                                        {if $is_app}
                                            <div class="m-b-btn panel-body">
                                                <button class="btn btn-info" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            {/foreach}
                        {else}
                            <h4 align="center">{lang('no_data')}</h4>       
                        {/if}
                        {$result_per_page5}
                    </div>
                     <legend><span class="fieldset-legend">{lang('twitter')}</span></legend>
                    <div class="row">
                        {if count($social_invite_twitter)>0}
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$social_invite_twitter item=v}
                            <div class="testimonials-item">
                                <div class="user"><img src="{$SITE_URL}/uploads/images/logos/twitter.png" alt=""></div>
                                <div class="testimonials-content">
                                    <h3 class="user-name">{$v.subject}</h3>
                                    <span>{lang('twitter_invite')}</span>
                                    <div class="txt"><p>{$v.content}</p></div>
                                    {if $is_app}
                                    <div class="m-b-btn panel-body">
                                        <button class="btn btn-info" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                                    </div>
                                    {/if}    
                                </div>
                            </div>
                            {/foreach}
                        {else}
                            <h4 align="center"> {lang('no_data')}</h4> 
                        {/if}
                        {$result_per_page7}
                    </div>
                    <legend><span class="fieldset-legend">{lang('instagram')}</span></legend>
                    <div class="row">
                        {if count($social_invite_instagram)>0}
                            {assign var="i" value="0"}
                            {assign var="class" value=""}
                            {foreach from=$social_invite_instagram item=v}
                            <div class="testimonials-item">
                                <div class="user"><img src="{$SITE_URL}/uploads/images/logos/insta.png" alt=""></div>
                                <div class="testimonials-content">
                                    <h3 class="user-name">{$v.subject}</h3>
                                    <span>{lang('instagram_invite')}</span>
                                    <div class="txt"><p>{$v.content}</p></div>
                                    {if $is_app}
                                    <div class="m-b-btn panel-body">
                                        <button class="btn btn-info" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                                    </div>
                                    {/if}
                                </div>
                            </div>
                            {/foreach}
                        {else}
                            <h4 align="center"> {lang('no_data')}</h4>   
                        {/if}
                        {$result_per_page8}
                    </div>
                </div>
            </div>
        </div>
    </main>
{/block} 
{block name="script"}
    <script src="{$PUBLIC_URL}javascript/all.js" type="text/javascript" ></script>
    <script src="{$PUBLIC_URL}javascript/validate_invite_wallpost.js" ></script>
    <script src="{$PUBLIC_URL}javascript/promotion.js"></script>
{/block} 
