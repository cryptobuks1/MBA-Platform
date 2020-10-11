{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div class="container">
    <div class="padding_top"></div>
    <div class="row">
        <div id="span_js_messages" style="display:none;">
            <span id="error_msg1"> {lang('you_must_enter_your_name')}</span>
            <span id="error_msg2">{lang('you_must_enter_your_email_id')}</span>
            <span id="error_msg3">{lang('please_enter_a_valid_number')}</span>
            <span id="error_msg4">{lang('invalid_email_format')}</span>
            <span id="error_msg5">{lang('you_must_enter_your_last_name')}</span>
            <span id="error_msg6">{lang('you_must_enter_your_phone_number')}</span>
            <span id="error_msg7">{lang('atleast_3_char')}</span>
            <span id="error_msg8">{lang('no_more_than_32_char')}</span>
            <span id="error_msg9">{lang('alpha_space')}</span>
            <span id="error_msg10">{lang('no_more_than_200_char')}</span>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <div class="text-center lcp_logo">
                <img src="{$SITE_URL}/uploads/images/logos/{$site_info['logo']}">
            </div>

            {include file="lcp/error_box.tpl" name=""}
            <div class="panel panel-default">
                <div class="panel-tools">
                        {if $LANG_STATUS=='yes'}
                        <div class="header_lang">
                            <div class="dropdown">						 
                                {foreach from=$LANG_ARR item=v}
                                    {if $LANG_ID == $v.lang_id} 
                                        <button class="dropbtn">
                                            <img src='{$PUBLIC_URL}images/flags/{$v.lang_code}.png' title="{$v.lang_name}"/>
                                        </button>
                                    {/if}
                                {/foreach}

                                <div class="dropdown-content">   
                                    {foreach from=$LANG_ARR item=v}
                                         {*  <a href="javascript:changeDefaultLanguage('{$v.lang_code}');">*}
                                        <a href="javascript:getSwitchLanguage('{$v.lang_code}');">
{*                                       <a href="javascript:changeLCPDefaultLanguage('{$v.lang_id}');">*}
                                            <img src='{$PUBLIC_URL}images/flags/{$v.lang_code}.png'/>&nbsp;{$v.lang_name}
                                        </a>
                                    {/foreach}
                                </div>
                            </div>                
                        </div>
                    {/if}
                </div>
                <div class="panel-body">
                    <h4 class="text-center">{lang('fill_out_the_form_below')}</h4>
                    
                    {form_open('lcp/home','role = "form" name="lcp_form" id="lcp_form" method="post"')}
                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>  
                    <div class="form-group">
                            <label>{lang('first_name')} <font color="#ff0000">*</font></label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{if isset($lcp_post_array['first_name'])}{$lcp_post_array['first_name']}{/if}">
                            {if isset($lcp_error['first_name'])}<span class='val-error'>{$lcp_error['first_name']}</span>{/if}
                        </div>
                        <div class="form-group">
                            <label>{lang('last_name')} <font color="#ff0000">*</font></label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{if isset($lcp_post_array['last_name'])}{$lcp_post_array['last_name']}{/if}">
                            {if isset($lcp_error['last_name'])}<span class='val-error'>{$lcp_error['last_name']} </span>{/if}
                        </div>
                        <div class="form-group">
                            <label>{lang('Your_Best_Email_Address')} <font color="#ff0000">*</font></label>
                            <input type="text" name="email" id="email_id" class="form-control" value="{if isset($lcp_post_array['email'])}{$lcp_post_array['email']}{/if}">
                            {if isset($lcp_error['email'])}<span class='val-error'>{$lcp_error['email']} </span>{/if}
                        </div>
                        <div class="form-group">
                            <label>{lang(skype_id)}</label>
                            <input type="text" name="skype_id" id="skype_id" class="form-control">
                            {if isset($lcp_error['skype_id'])}<span class='val-error'>{$lcp_error['skype_id']} </span>{/if}
                        </div>
                        <div class="form-group">
                            <label>{lang('Your_Telephone_Cell_Number')} <font color="#ff0000">*</font></label>
                            <input type="tel" name="phone" id="phone" class="form-control">
                            {if isset($lcp_error['phone'])}<span class='val-error'>{$lcp_error['phone']} </span>{/if}
                        </div>
                        <div class="form-group">
                            <label >{lang('select_country')}</label>
                            <select class="form-control" name="country" id="country">
                                <option value="" class="form-control">{lang(select)} </option>
                                {$countries}
                            </select>
                            {if isset($lcp_error['country'])}<span class='val-error'>{$lcp_error['country']} </span>{/if}
                        </div>
                        <div class="form-group">
                            <label>{lang('Your_Comments_Please')}</label>
                            <textarea type="text" name="comment" id="comment" class="form-control" coloum="4" maxlength="200">{if isset($lcp_post_array['comment'])}{$lcp_post_array['comment']}{/if} </textarea>
                        </div>
                        <button type="submit" id="add_lcp" name="add_lcp" value="add_lcp" class="btn btn-sm btn-primary">{lang(Submit)}</button>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
{/block}

{block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validatecontact.js" type="text/javascript" ></script>
{/block}