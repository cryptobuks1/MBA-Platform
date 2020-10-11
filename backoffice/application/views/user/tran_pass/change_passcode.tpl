{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
   <span id="error_msg1">{lang('you_must_enter_current_transaction_password')}</span>
   <span id="error_msg2">{lang('you_must_enter_new_transaction_password')}</span>
   <span id="error_msg3">{lang('transaction_password_length_should_be_more_than_8')}</span>
   <span id="error_msg4">{lang('reenter_new_transaction_password')}</span>                     
   <span id="error_msg5">{lang('new_transaction_password_mismatch')}</span>        
   <span id="error_msg6">{lang('you_must_select_a_username')}</span>
   <span id="error_msg8">{lang('captcha_required')}</span>
</div>
<main>
   <div class="tabsy">
      <input type="radio" id="tab1" name="tab" {$tab1}>
      <label class="tabButton" for="tab1">{lang('change_transaction_password')}</label>
      {if $preset_demo eq 'yes'}
      <font style="padding-left: 20px;" color="red">NB:{lang('this_option_is_not_available_for_preset_users')} </font>
      <br><br>
      {/if}
      <div class="tab">
         <div class="content">
            {form_open('user/change_passcode','role="form" name="change_pass" id="change_pass" action="" method="post" ')}
            <div class="col-sm-3 padding_both">
            <div class="form-group">
               <label >{lang('current_password')}<font color="#ff0000">*</font></label>
               <input class="form-control" type="password" name="old_passcode" id="old_passcode" tabindex="1" maxlength="32" />{form_error('old_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label >{lang('new_password')}<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="new_passcode" id="new_passcode" tabindex="2" maxlength="32" />{form_error('new_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label>{lang('re_new_passcode')}<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="re_new_passcode" id="re_new_passcode" tabindex="3" maxlength="32" />{form_error('re_new_passcode')}
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button_1">
               <button type="submit" class="btn btn-primary" name="change"  id="change"  tabindex="4" value="change" {if $preset_demo eq 'yes'}disabled{/if}>{lang('update')}</button>
            </div>
            </div>
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            {form_close()}
         </div>
      </div>
      <input type="radio" id="tab3" name="tab" {$tab2}>
      <label class="tabButton" for="tab3"> {lang('forgot_transaction_password')}</label>
      <div class="tab">
         <div class="content">
            {form_open('', 'class="" id="forgot_trans_password" name="forgot_trans_password" method="post" onload="onloadCaptcha();"')}
            <div class="col-sm-12">
               <p class="text-danger">{lang('mail_is_send_and_follow_instruction')}</p>
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
                     <input type="text" class="form-control" style="width:100%;" name="captcha" id="captcha-form" autocomplete="off" tabindex="3" />
                     <font color="red">{form_error('captcha')}</font>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary" name="forgot_password_submit"  id="forgot_password_submit"  tabindex="4" value="{lang('send_request')}" tabindex="4">{lang('send_request')}</button>
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
   });
</script>
{/block}