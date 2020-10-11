{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg1">{lang('enter_subject')}</span>
    <span id="validate_msg2">{lang('enter_message')}</span>    
    <input type = "hidden" name = "logo" id = "logo" value = "{$SITE_URL}images/logos/{$site_info["logo"]}" >
</div>

{* <div class="b wrapper m-b-sm panel">
    <p>{lang('note_invite_banner_config')}</p>
</div> *}

<!-------- Email Invite ----------> 
    <div class="panel">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">{lang('email_invite')}</span>
             {form_open('admin/add_email_invite','role="form" class="smart-wizard pull-right" method="post"  name="" id=""')}
            <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit" value="" name="" id=""><i class="fa fa-plus"></i>{lang('add_email_invite')}</button>
            {form_close()}
        </legend>
            {if count($social_invite_email)>0}
            {assign var="i" value="0"}
            {assign var="class" value=""}
            {foreach from=$social_invite_email item=v} 
                <div class="testimonials-item">
                    <div class="user">
                        <img src="{$SITE_URL}/uploads/images/logos/Mail.png" alt="">
                    </div>
                    <div class="testimonials-content">
                        <h3 class="user-name">{$v.subject}</h3>
                        <span>{lang('email_invite')}</span>
                        <div class="txt">
                            <p>{$v.content}</p>
                        </div>
                        <div class="m-b-btn panel-body">
                          {form_open('admin/member/delete_social_invite', 'method="post" class="smart-wizard inline"')}
                              <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                              <button class="btn btn-danger" type='submit' id='delete' name='delete' value="delete"><i class="fa fa-trash-o "></i></button>
                          {form_close()}
                          {form_open('admin/edit_invite_wallpost','method="post" class="smart-wizard inline"')}
                              <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                              <input type='hidden' id='type' name='type' value='{$v.type}'>
                              <button class="btn btn-info" type='submit' id='edit' name='edit' value="edit"><i class="fa fa-edit"></i></button>
                          {form_close()}
                        </div>
                    </div>
                </div>
                 {/foreach} 
            {else}
                <div class="b wrapper m-b-sm panel">
                <h4 align="center">{lang('no_data')}</h4>
            </div>
            {/if}
        {$result_per_page1}
    </div>
</div>
    
<!-------- Email Invite-------------->

<!-------- Facebook Invite ---------->  

    <div class="panel">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">{lang('facebook_invite')}</span>
             {form_open('admin/add_facebook_invite','role="form" class="smart-wizard pull-right" method="post"  name="" id=""')}
            <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit" value="" name="" id=""><i class="fa fa-plus"></i>{lang('add_facebook_invite')}</button>
            {form_close()}
        </legend>
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
                                <div class="m-b-btn panel-body">
                                    <button class="btn btn-primary" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                                  {form_open('admin/member/delete_social_invite', 'method="post"  class="smart-wizard inline"')}
                                      <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                      <button class="btn btn-danger" title="{lang('delete')}" type='submit'  id='delete'  name='delete' value="delete"><i class="fa fa-trash-o "></i></button>
                                  {form_close()}
                                  {form_open('admin/edit_invite_wallpost','method="post"  class="smart-wizard inline"')}
                                      <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                      <input type='hidden' id='type' name='type' value='{$v.type}'>
                                      <button class="btn btn-info" type='submit'  id='edit' name='edit' value="edit"><i class="fa fa-edit"></i></button>
                                  {form_close()}
                                </div>
                        </div>
                    </div>
                {/foreach}
            {else}
            <div class="b wrapper m-b-sm panel">
                <h4 align="center">{lang('no_data')}</h4>
            </div>
            {/if}
        {$result_per_page2}
    </div>
    </div>
<!-------- Facebook Invite ---------->

<!-------- Twitter Invite ----------->

    <div class="panel">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">{lang('twitter_invite')}</span>
                 {form_open('admin/add_social_invite','role="form" class="smart-wizard pull-right" method="post"  name="" id=""')}
                <input type='hidden' id='' name='social_media' value='twitter_invite'>
                <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit" value="" name="" id=""><i class="fa fa-plus"></i>{lang('add_twitter_invite')}</button>
                {form_close()}
            </legend>
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
                        <div class="m-b-btn panel-body">
                            <button class="btn btn-primary" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                            {form_open('admin/member/delete_social_invite', 'method="post" class="smart-wizard inline"')}
                                <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                <button class="btn btn-danger" title="{lang('delete')}" type='submit'  id='delete'  name='delete' value="delete"><i class="fa fa-trash-o "></i></button>
                            {form_close()}
                            {form_open('admin/edit_invite_wallpost','method="post" class="smart-wizard inline"')}
                                <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                <input type='hidden' id='type' name='type' value='{$v.type}'>
                                <button class="btn btn-info" type='submit'  id='edit' name='edit' value="edit"><i class="fa fa-edit"></i></button>
                            {form_close()}
                        </div>
                    </div>
                </div>
             {/foreach}
            {else}
                <div class="b wrapper m-b-sm panel">
                <h4 align="center">{lang('no_data')}</h4>
            </div>
            {/if}
            {$result_per_page4}   
        </div>
    </div>
    
<!-------- Twitter Invite ----------->

<!-------- Instagram Invite --------->

    <div class="panel">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">{lang('instagram_invite')}</span>
                {form_open('admin/add_social_invite','role="form" class="smart-wizard pull-right" method="post"  name="" id=""')}
                <input type='hidden' id='' name='social_media' value='instagram_invite'>
                <button class="btn m-b-xs btn-sm btn-primary btn-addon" type="submit" value="" name="" id=""><i class="fa fa-plus"></i>{lang('add_instagram_invite')}</button>
                {form_close()}
            </legend>

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
                        <div class="m-b-btn panel-body">
                            <button class="btn btn-primary" onclick="Sharer('{$v.id}');"><i class="fa fa-share-alt"></i></button>
                            {form_open('admin/member/delete_social_invite', 'method="post" class="smart-wizard inline"')}
                                <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                <button class="btn btn-danger" title="{lang('delete')}" type='submit'  id='delete'  name='delete' value="delete"><i class="fa fa-trash-o "></i></button>
                            {form_close()}
                            {form_open('admin/edit_invite_wallpost','method="post" class="smart-wizard inline"')}
                                <input type='hidden' id='invite_text_id' name='invite_text_id' value='{$v.id}'>
                                <input type='hidden' id='type' name='type' value='{$v.type}'>
                                <button class="btn btn-info" type='submit'  id='edit' name='edit' value="edit"><i class="fa fa-edit"></i></button>
                            {form_close()}
                        </div>
                    </div>
                </div>
            {/foreach}
            {else}
                <div class="b wrapper m-b-sm panel">
                <h4 align="center">{lang('no_data')}</h4>
            </div>
            {/if}
            {$result_per_page5}             
        </div>
    </div>
<!-------- Instagram Invite ----------->
{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/all.js" type="text/javascript" ></script>  
{/block}