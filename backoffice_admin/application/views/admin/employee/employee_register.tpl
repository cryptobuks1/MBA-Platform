{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>        
    <span id="error_msg2">{lang('you_must_enter_your_password')}</span>        
    <span id="error_msg3">{lang('You_must_enter_your_Password_again')}</span>        
    <span id="error_msg4">{lang('You_must_enter_your_email')}</span>                  
    <span id="error_msg5">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="error_msg6">{lang('mail_id_format')}</span>
    <span id="error_msg7">{lang('You_must_enter_first_name')}</span>
    <span id="error_msg8">{lang('You_must_enter_last_name')}</span>
    <span id="error_msg12">{lang('Invalid_Username')}</span>
    <span id="error_msg13">{lang('checking_username_availability')}</span>
    <span id="error_msg14">{lang('username_validated')}</span>
    <span id="error_msg15">{lang('username_already_exists')}</span>
    <span id="confirm_msg">{lang('sure_you_want_to_delete_this_feedback_there_is_no_undo')}</span>
    <span id="error_msg16">{lang('please_enter_atleast_6_characters')}</span>
    <span id="error_msg17">{lang('digits_only')}</span>
    <span id="error_msg18">{lang('alphabets_only')}</span>
    <span id="error_msg19">{lang('special_characters_are_not_allowed')}</span>
    <span id="error_msg20">{lang('please_select_a_date')}</span>
    <span id="error_msg21">{lang('please_enter_atleast_5_digits')}</span>
    <span id="error_msg22">{lang('please_enter_no_more_than_10_digits')}</span>
    <span id="error_msg23">{lang('you_must_enter_atleast_6_characters')}</span>
    <span id="error_msg24">{lang('password_mismatch')}</span>
</div> 

        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard employreglog" method="post"  name="user_register" id="user_register"')}
                    {include file="layout/error_box.tpl"}

                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
                
                    <div class="form-group">
                        <label class="control-label required" for="ref_username" >{lang('user_name')}</label>
                            <input class="form-control" type="text" name="ref_username" id="ref_username" onblur="check_username_availability(this.value)" autocomplete="Off" tabindex="1" maxlength="32"  {if isset($employee_reg_arr['ref_username'])} value="{$employee_reg_arr['ref_username']}"{/if}>
                            <span id="username_box" style="display:none;"></span>
                            {form_error('ref_username')}
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label required" for="first_name">{lang('first_name')}</label>
                            <input class="form-control" type="text"  name="first_name" id="first_name"   autocomplete="Off" tabindex="2" minlength="2"  {if isset($employee_reg_arr['first_name'])} value="{$employee_reg_arr['first_name']}"{/if}>
                            {form_error('first_name')}
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label required" for="last_name" >{lang('last_name')}</label>
                            <input class="form-control"  type="text"  name="last_name" id="last_name"   autocomplete="Off" tabindex="3"  minlength="2"  {if isset($employee_reg_arr['last_name'])} value="{$employee_reg_arr['last_name']}"{/if}>
                            {form_error('last_name')}
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label required" for="first_name">{lang('email')}</label>
                            <input class="form-control" type="text"  name="email" id="email"   autocomplete="Off" tabindex="4" maxlength="32" {if isset($employee_reg_arr['email'])} value="{$employee_reg_arr['email']}"{/if}>
                            {form_error('email')}
                    </div>

                    <div class="form-group">
                        <label class=" control-label required" for="mobile_no" >{lang('mobile_no')}</label>
                            <input class="form-control" type="number"  name="mobile_no" id="mobile_no"   autocomplete="Off" tabindex="5" maxlength="10" {if isset($employee_reg_arr['mobile_no'])} value="{$employee_reg_arr['mobile_no']}"{/if}>
                            <span id="errmsg1"></span>
                            {form_error('mobile_no')}
                       
                    </div>

                     <div class="form-group">
                        <label class="control-label required" for="pswd">{lang('password')}</label>
                            <input class="form-control" type="password" name="pswd" id="pswd" tabindex="6" autocomplete="Off" size="24" maxlength="20"  >
                        {form_error('pswd')}
                    </div>

                    <div class="form-group">
                        <label class="control-label required" for="cpswd"  >{lang('confirm_password')}</label>
                            <input class="form-control" name="cpswd" id="cpswd" type="password" tabindex="7" autocomplete="Off" size="24" maxlength="20" >
                            {form_error('cpswd')}
                    </div>
 
                    <button class="btn btn-sm btn-primary" name="register" id="register" tabindex="8" value="{lang('register_new_member')}">
                    {lang('register_new_member')}</button>

            <!--    <button class="btn btn-bricky" name="reset" id="reset" type="reset" value="{lang('reset')}" tabindex="9" style="margin-top: 1.3em;">
                    {lang('reset')} </button> -->
               
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