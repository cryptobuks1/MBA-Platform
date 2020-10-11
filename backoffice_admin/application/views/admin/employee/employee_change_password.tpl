{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
    <span id="error_msg2">{lang('you_must_enter_atleast_6_characters')}</span>     
    <span id="error_msg3">{lang('password_mismatch')}</span>  
    <span id="error_msg4">{lang('you_must_enter_your_new_password_again')}</span>     
    <span id="error_msg5">{lang('you_must_enter_your_new_password')}</span>                  
    <span id="error_msg6">{lang('you_must_enter_your_confirm_password')}</span>  
    <span id="error_msg7">{lang('special_chars_not_allowed')}</span>
    <span id="error_msg8">{lang('You_must_enter_user_name')}</span>
</div>

        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard" id="change_pass" name="change_pass" method="post"')}
                    {include file="layout/error_box.tpl"}
                        <div class="form-group">
                            <label class="control-label required" for="user_name">{lang('user_name')}</label>
                                <input class="form-control employee_autolist" type="text" id="user_name" name="user_name" value="" tabindex="5" autocomplete="Off" >
                                {form_error('user_name')}
                        </div>
                        
                        <div class="form-group">
                            <label class=" control-label required" for="new_pwd">{lang('new_password')}</label>
                                <input class="form-control" name="new_pwd" type="password" id="new_pwd" size="20"  autocomplete="Off" tabindex="6" />
                                {form_error('new_pwd')}
                        </div>

                        <div class="form-group">
                            <label class=" control-label required" for="confirm_pwd">{lang('confirm_password')}</label>
                                <input class="form-control" name="confirm_pwd" type="password" id="confirm_pwd" size="20"  autocomplete="Off" tabindex="7" />
                                {form_error('confirm_pwd')}
                        </div>
    
                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">                                       
                        <button class="btn btn-sm btn-primary" type="submit" name="change_pass_button"  id="change_pass_button" value="{lang('change_password')}" tabindex="8">{lang('change_password')}</button>

                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>

{/block}

{block name=script}
  {$smarty.block.parent}
    <script>
        jQuery(document).ready(function() {
            ValidateUser.init();
        });
    </script>
{/block}