{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
        <span id="error_msg2">{lang('the_password_length_should_be_greater_than_6')}</span>        
        <span id="error_msg3">{lang('password_mismatch')}</span>  
        <span id="error_msg6">{lang('you_must_enter_new_password')}</span>  
        <span id="error_msg8">{lang('special_chars_not_allowed')}</span>
        <span id="error_msg4">{lang('you_must_enter_confirm_password')}</span>
        <span id="validate_msg16">{lang('max_32')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {if $preset_demo eq 'yes'}
                <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_for_preset_users')} </font>
                <br><br>
            {/if}
            {form_open('user/password/post_change_password','role="form" class="" id="change_pass_admin" name="change_pass_admin"  method="post" ')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required">{lang('current_password')}</label>
                    <input class="form-control" name="current_pwd_admin" type="password" id="current_pwd_admin" tabindex="1" autocomplete="Off" >
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('new_password')}</label>
                    <input class="form-control" name="new_pwd_admin" type="password" id="new_pwd_admin" size="20"  autocomplete="Off" tabindex="2" />
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="required">{lang('confirm_password')}</label>
                    <input class="form-control" name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" size="20"  autocomplete="Off" tabindex="3" />
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button class="btn btn-primary" type="submit" name="change_pass_button_admin" id="change_pass_button_admins" value="{lang('change_password')}" tabindex="4" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
{/block}
