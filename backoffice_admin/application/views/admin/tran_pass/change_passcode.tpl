{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
   <span id="error_msg1">{lang('you_must_enter_current_transaction_password')}</span>
   <span id="error_msg2">{lang('you_must_enter_new_transaction_password')}</span>
   <span id="error_msg3">{lang('transaction_password_length_should_be_more_than_8')}</span>
   <span id="error_msg4">{lang('reenter_new_transaction_password')}</span>                     
   <span id="error_msg5">{lang('new_transaction_password_mismatch')}</span>        
   <span id="error_msg6">{lang('you_must_select_a_username')}</span>
   <span id="error_msg7">{lang('invalid_user_name')}</span>
   <span id="error_msg8">{lang('captcha_required')}</span>
</div>
<main>
   <div class="tabsy">
      <input type="radio" id="tab1" name="tab" {$tab1}>
      <label class="tabButton" for="tab1">{lang('change_transaction_password')}</label>
      <div class="tab">
         <div class="content">
            {form_open('','role="form"  name="change_pass" id="change_pass"')}
            {if $preset_demo eq 'yes'}
            <br>
            <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_in_preset_demos')} </font>
            <br>
            {/if}
            <div class="col-sm-3 padding_both">
            <div class="form-group">
               <label >{lang('current_password')}<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="old_passcode" id="old_passcode" tabindex="1" maxlength="32" />{form_error('old_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label >{lang('new_password')}<font color="#ff0000">*</font></label>
               <input class="form-control" type="password" name="new_passcode" id="new_passcode" tabindex="2" maxlength="32" />{form_error('new_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label>{lang('reenter_new_password')}<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="re_new_passcode" id="re_new_passcode" tabindex="3" maxlength="32" />{form_error('re_new_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button_1">
               <button type="submit" class="btn btn-primary" name="change_tran"  value="change_tran" id="change"  tabindex="4" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
            </div>
            </div>
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            {form_close()}
         </div>
      </div>
      <input type="radio" id="tab2" name="tab" {$tab2}>
      <label class="tabButton" for="tab2"> {lang('change_user_transaction_password')}</label>
      <div class="tab">
         <div class="content">
            {form_open('','role="form" name="change_pass_user" id="change_pass_user" method="post"')}
            <div class="col-sm-3 padding_both">
            <div class="form-group">
               <label >{lang('user_name')}<font color="#ff0000">*</font></label>
               <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" tabindex="0" >  {form_error('user_name')} 
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label >{lang('new_password')}<font color="#ff0000">*</font></label>
               <input class="form-control" type="password" name="new_passcode_user" id="new_passcode_user" maxlength="32" tabindex="0" /> {form_error('new_passcode_user')} 
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label>{lang('reenter_new_password')}<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="re_new_passcode_user" id="re_new_passcode_user" tabindex="0" maxlength="32" /> {form_error('re_new_passcode_user')} 
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button_1">
               <button type="submit" class="btn btn-primary" name="change_user"  id="change_user"  tabindex="0" value="change_user">{lang('update')}</button>
            </div>
            </div>
            {form_close()}
         </div>
      </div>
      <input type="radio" id="tab3" name="tab" {$tab3}>
      <label class="tabButton" for="tab3">{lang('forgot_transaction_password')}</label>
      <div class="tab">
         <div class="content">
               {form_open('', ' id="forgot_trans_password" name="forgot_trans_password" method="post" onload="onloadCaptcha();"')}
            <div class="col-sm-12">
               <input type="hidden" id="search_member_error" value="{lang('search_member_error')}"/>
               <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}"/>
                <div class="col-sm-3 padding_both">
               <div class="form-group">
                  <label >{lang('user_name')}<font color="#ff0000">*</font></label>
                  <input class="form-control user_autolist" type="text" id="user_name_1" name="user_name"  autocomplete="Off" tabindex="1" >  {form_error('user_name')} <span id ="err_usr_name" style="color:#b94a48;"></span>
               </div>
               </div>
                <div class="col-sm-3 padding_both_small">
               <div class="form-group">
                  <label >{lang('email')}</label>
                  <span id="e_ma_il_trans"></span>
                  <input type="text" class="form-control"  id="e_mail_1" name="e_mail_1" placeholder="{lang('email')}" AUTOCOMPLETE = "OFF" tabindex="2" readonly="true">
                  <input type="hidden" class="form-control"  id="e_mail" name="e_mail" placeholder="{lang('email')}" AUTOCOMPLETE = "OFF" tabindex="2" > <font color="red">{form_error('e_mail')}</font>
                </div>
               </div>
            </div>
            <div class="col-sm-6 captcha-bg">
                  <div class="col-md-12 ">
                     <div class="form-group img_wdth_capcha">
                        <img src="{$BASE_URL}captcha/load_captcha/admin" id="captcha" />
                     </div>
                     <div class="form-group">
                        <a href="#" onclick="
                           document.getElementById('captcha').src = '{$BASE_URL}captcha/load_captcha/admin/' + Math.random();
                           document.getElementById('captcha-form').focus();"
                           id="change-image" class="color">{lang('not_readable')}</a> 
                        <input type="text" class="form-control" name="captcha" id="captcha-form" autocomplete="off" tabindex="3" /><br/>
                        {form_error('captcha')}
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-primary"  name="forgot_password_submit"   id="forgot_password_submit"  value="{lang('send_request')}" tabindex="4">{lang('send_request')}</button>
                     </div>
                  </div>
            </div>
            {form_close()}
         </div>
      </div>
   </div>
</main>
{/block}
{block name=script} {$smarty.block.parent}
<script>
   jQuery(document).ready(function () {
       ValidateUser.init();
       ValidateForget.init();
   });
   
</script>
{/block}