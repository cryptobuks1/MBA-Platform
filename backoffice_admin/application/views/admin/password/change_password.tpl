{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('you_must_enter_your_current_password')}</span>        
        <span id="error_msg2">{lang('the_password_length_should_be_greater_than_6')}</span>        
        <span id="error_msg3">{lang('password_mismatch')}</span>  
        <span id="error_msg4">{lang('you_must_enter_your_new_password_again')}</span>     
        <span id="error_msg6">{lang('you_must_enter_your_new_password')}</span>                  
        <span id="error_msg7">{lang('you_must_enter_your_confirm_password')}</span>  
        <span id="error_msg8">{lang('special_chars_not_allowed')}</span>
        <span id="validate_msg9">{lang('password_characters_allowed')}</span>
        <span id="validate_msg10">{lang('incorrect_username')}</span>
        <span id="validate_msg11">{lang('correct_username')}</span>
        <span id="validate_msg12">{lang('loading')}</span>
        <span id="validate_msg13">{lang('you_must_enter_password')}</span>
        <span id="validate_msg14">{lang('You_must_enter_user_name')}</span>
        <span id="validate_msg15">{lang('you_must_enter_your_confirm_password')}</span>
        <span id="validate_msg16">{lang('max_32')}</span>
    </div>
    <div class="tabsy">
        {if $user_type!='employee'}
            <input type="radio" id="tab1" name="tab" checked>
            <label class="tabButton" for="tab1">{lang('change_admin_password')}</label>
            <div class="tab">
                <div class="content">
                    {form_open('admin/password/post_change_password','role="form" class="" id="change_pass_admin" name="change_pass_admin" method="post"')}
                    {if $preset_demo eq 'yes'}
                        <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_in_preset_demos')} </font>
                        <br>
                        <br>
                    {/if}
                    <div class="col-sm-3 padding_both">
                        <div class="form-group">
                            <label>{lang('current_password')}</label>
                            <input class="form-control" name="current_pwd_admin" type="password" id="current_pwd_admin" autocomplete="Off"  />
                        </div>
                    </div>
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group">
                            <label>{lang('new_password')}</label>
                            <input class="form-control" name="new_pwd_admin" type="password" id="new_pwd_admin" autocomplete="Off" />
                        </div>
                    </div>
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group">
                            <label>{lang('confirm_password')}</label>
                            <input class="form-control" name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" autocomplete="Off" />
                        </div>
                    </div>
                    <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group mark_paid">
                            <button class="btn btn-sm btn-primary" type="submit" name="change_pass_button_admin" id="change_pass_button_admin" value="{lang('change_admin_password')}" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    {form_close()}
                </div>
            </div>
        {/if}
        <input type="radio" id="tab2" name="tab">
        <label class="tabButton" for="tab2">{lang('change_user_password')}</label>
        <div class="tab">
            <div class="content">
                {form_open('admin/password/post_change_user_password','role="form" class="" id="change_pass_common" name="change_pass_common" method="post"')}
                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label>{lang('user_name')}</label>
                        <input class="form-control user_autolist" type="text" id="user_name_common" name="user_name_common" value="" autocomplete="Off"><span id="referral_box" style="display:none;"></span> 
                        <span id="erro_user_name"></span>
                    </div>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <label>{lang('new_password')}</label>
                        <input class="form-control" name="new_pwd_common" type="password" id="new_pwd_common" autocomplete="Off"/>
                    </div>
                </div>
                <div style="display:none;">
                    <span id='span_new_pwd_common'>
                        {lang('you_must_enter_new_password')}
                    </span>
                    <span id='span_new_pwd_gt'>
                        {lang('the_password_length_should_be_greater_than_6')}
                    </span>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <label>{lang('confirm_password')}</label>
                        <input class="form-control" name="confirm_pwd_common" type="password" id="confirm_pwd_common" autocomplete="Off" />
                    </div>
                </div>
                <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group mark_paid">
                        <button class="btn btn-sm btn-primary"  type="submit" name="change_pass_button_common"  id="change_pass_button_common" value="{lang('change_user_password')}" >{lang('update')}</button>
                    </div>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
{/block}