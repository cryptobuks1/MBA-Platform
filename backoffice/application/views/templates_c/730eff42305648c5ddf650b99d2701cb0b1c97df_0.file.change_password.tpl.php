<?php
/* Smarty version 3.1.30, created on 2020-09-25 19:57:11
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/password/change_password.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6dbef7350a44_84695919',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '730eff42305648c5ddf650b99d2701cb0b1c97df' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/password/change_password.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6dbef7350a44_84695919 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15637792465f6dbef734fec9_25997790', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15637792465f6dbef734fec9_25997790 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1"><?php echo lang('you_must_enter_your_current_password');?>
</span>        
        <span id="error_msg2"><?php echo lang('the_password_length_should_be_greater_than_6');?>
</span>        
        <span id="error_msg3"><?php echo lang('password_mismatch');?>
</span>  
        <span id="error_msg6"><?php echo lang('you_must_enter_new_password');?>
</span>  
        <span id="error_msg8"><?php echo lang('special_chars_not_allowed');?>
</span>
        <span id="error_msg4"><?php echo lang('you_must_enter_confirm_password');?>
</span>
        <span id="validate_msg16"><?php echo lang('max_32');?>
</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>
                <font style="padding-left: 20px;" color="red">NB:<?php echo lang('this_option_is_not_available_for_preset_users');?>
 </font>
                <br><br>
            <?php }?>
            <?php echo form_open('user/password/post_change_password','role="form" class="" id="change_pass_admin" name="change_pass_admin"  method="post" ');?>

            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required"><?php echo lang('current_password');?>
</label>
                    <input class="form-control" name="current_pwd_admin" type="password" id="current_pwd_admin" tabindex="1" autocomplete="Off" >
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="required"><?php echo lang('new_password');?>
</label>
                    <input class="form-control" name="new_pwd_admin" type="password" id="new_pwd_admin" size="20"  autocomplete="Off" tabindex="2" />
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="required"><?php echo lang('confirm_password');?>
</label>
                    <input class="form-control" name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" size="20"  autocomplete="Off" tabindex="3" />
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button class="btn btn-primary" type="submit" name="change_pass_button_admin" id="change_pass_button_admins" value="<?php echo lang('change_password');?>
" tabindex="4" <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>disabled<?php }?>><?php echo lang('update');?>
</button>
                </div>
            </div>
            <?php echo form_close();?>

        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
