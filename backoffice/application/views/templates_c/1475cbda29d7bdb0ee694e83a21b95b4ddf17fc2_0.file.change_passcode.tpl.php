<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:20:03
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tran_pass/change_passcode.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6da833131383_39101291',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1475cbda29d7bdb0ee694e83a21b95b4ddf17fc2' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tran_pass/change_passcode.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6da833131383_39101291 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9270299765f6da83312fbb9_47583118', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16464709815f6da833130e86_47365303', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_9270299765f6da83312fbb9_47583118 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
   <span id="error_msg1"><?php echo lang('you_must_enter_current_transaction_password');?>
</span>
   <span id="error_msg2"><?php echo lang('you_must_enter_new_transaction_password');?>
</span>
   <span id="error_msg3"><?php echo lang('transaction_password_length_should_be_more_than_8');?>
</span>
   <span id="error_msg4"><?php echo lang('reenter_new_transaction_password');?>
</span>                     
   <span id="error_msg5"><?php echo lang('new_transaction_password_mismatch');?>
</span>        
   <span id="error_msg6"><?php echo lang('you_must_select_a_username');?>
</span>
   <span id="error_msg8"><?php echo lang('captcha_required');?>
</span>
</div>
<main>
   <div class="tabsy">
      <input type="radio" id="tab1" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab1']->value;?>
>
      <label class="tabButton" for="tab1"><?php echo lang('change_transaction_password');?>
</label>
      <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>
      <font style="padding-left: 20px;" color="red">NB:<?php echo lang('this_option_is_not_available_for_preset_users');?>
 </font>
      <br><br>
      <?php }?>
      <div class="tab">
         <div class="content">
            <?php echo form_open('user/change_passcode','role="form" name="change_pass" id="change_pass" action="" method="post" ');?>

            <div class="col-sm-3 padding_both">
            <div class="form-group">
               <label ><?php echo lang('current_password');?>
<font color="#ff0000">*</font></label>
               <input class="form-control" type="password" name="old_passcode" id="old_passcode" tabindex="1" maxlength="32" /><?php echo form_error('old_passcode');?>

            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label ><?php echo lang('new_password');?>
<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="new_passcode" id="new_passcode" tabindex="2" maxlength="32" /><?php echo form_error('new_passcode');?>

            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group">
               <label><?php echo lang('re_new_passcode');?>
<font color="#ff0000">*</font> </label>
               <input class="form-control" type="password" name="re_new_passcode" id="re_new_passcode" tabindex="3" maxlength="32" /><?php echo form_error('re_new_passcode');?>

            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button_1">
               <button type="submit" class="btn btn-primary" name="change"  id="change"  tabindex="4" value="change" <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>disabled<?php }?>><?php echo lang('update');?>
</button>
            </div>
            </div>
            <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
            <?php echo form_close();?>

         </div>
      </div>
      <input type="radio" id="tab3" name="tab" <?php echo $_smarty_tpl->tpl_vars['tab2']->value;?>
>
      <label class="tabButton" for="tab3"> <?php echo lang('forgot_transaction_password');?>
</label>
      <div class="tab">
         <div class="content">
            <?php echo form_open('','class="" id="forgot_trans_password" name="forgot_trans_password" method="post" onload="onloadCaptcha();"');?>

            <div class="col-sm-12">
               <p class="text-danger"><?php echo lang('mail_is_send_and_follow_instruction');?>
</p>
            </div>
            <div class="col-sm-6 captcha-bg">
               <div class="col-md-12 ">
                  <div class="form-group img_wdth_capcha">
                     <img src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin" id="captcha" />
                  </div>
                  <div class="form-group">
                     <a href="#" onclick="
                        document.getElementById('captcha').src = '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin/' + Math.random();
                        document.getElementById('captcha-form').focus();"
                        id="change-image" class="color"><?php echo lang('not_readable');?>
</a> 
                     <input type="text" class="form-control" style="width:100%;" name="captcha" id="captcha-form" autocomplete="off" tabindex="3" />
                     <font color="red"><?php echo form_error('captcha');?>
</font>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary" name="forgot_password_submit"  id="forgot_password_submit"  tabindex="4" value="<?php echo lang('send_request');?>
" tabindex="4"><?php echo lang('send_request');?>
</button>
                  </div>
               </div>
            </div>
            <?php echo form_close();?>

         </div>
      </div>
   </div>
</main>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_16464709815f6da833130e86_47365303 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
>
   jQuery(document).ready(function () {
       ValidateUser.init();
   });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
