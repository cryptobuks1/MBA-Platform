<?php
/* Smarty version 3.1.30, created on 2020-08-16 09:59:52
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/password/change_password.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3876f80768c8_56656675',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1677c89589a883efc05ea37072c1429adb01b48b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/password/change_password.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f3876f80768c8_56656675 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10062904025f3876f8075ce1_80499319', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_10062904025f3876f8075ce1_80499319 extends Smarty_Internal_Block
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
        <span id="error_msg4"><?php echo lang('you_must_enter_your_new_password_again');?>
</span>     
        <span id="error_msg6"><?php echo lang('you_must_enter_your_new_password');?>
</span>                  
        <span id="error_msg7"><?php echo lang('you_must_enter_your_confirm_password');?>
</span>  
        <span id="error_msg8"><?php echo lang('special_chars_not_allowed');?>
</span>
        <span id="validate_msg9"><?php echo lang('password_characters_allowed');?>
</span>
        <span id="validate_msg10"><?php echo lang('incorrect_username');?>
</span>
        <span id="validate_msg11"><?php echo lang('correct_username');?>
</span>
        <span id="validate_msg12"><?php echo lang('loading');?>
</span>
        <span id="validate_msg13"><?php echo lang('you_must_enter_password');?>
</span>
        <span id="validate_msg14"><?php echo lang('You_must_enter_user_name');?>
</span>
        <span id="validate_msg15"><?php echo lang('you_must_enter_your_confirm_password');?>
</span>
        <span id="validate_msg16"><?php echo lang('max_32');?>
</span>
    </div>
    <div class="tabsy">
        <?php if ($_smarty_tpl->tpl_vars['user_type']->value != 'employee') {?>
            <input type="radio" id="tab1" name="tab" checked>
            <label class="tabButton" for="tab1"><?php echo lang('change_admin_password');?>
</label>
            <div class="tab">
                <div class="content">
                    <?php echo form_open('admin/password/post_change_password','role="form" class="" id="change_pass_admin" name="change_pass_admin" method="post"');?>

                    <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>
                        <font style="padding-left: 20px;" color="red">NB:<?php echo lang('this_option_is_not_available_in_preset_demos');?>
 </font>
                        <br>
                        <br>
                    <?php }?>
                    <div class="col-sm-3 padding_both">
                        <div class="form-group">
                            <label><?php echo lang('current_password');?>
</label>
                            <input class="form-control" name="current_pwd_admin" type="password" id="current_pwd_admin" autocomplete="Off"  />
                        </div>
                    </div>
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group">
                            <label><?php echo lang('new_password');?>
</label>
                            <input class="form-control" name="new_pwd_admin" type="password" id="new_pwd_admin" autocomplete="Off" />
                        </div>
                    </div>
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group">
                            <label><?php echo lang('confirm_password');?>
</label>
                            <input class="form-control" name="confirm_pwd_admin" type="password" id="confirm_pwd_admin" autocomplete="Off" />
                        </div>
                    </div>
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/">
                    <div class="col-sm-3 padding_both_small">
                        <div class="form-group mark_paid">
                            <button class="btn btn-sm btn-primary" type="submit" name="change_pass_button_admin" id="change_pass_button_admin" value="<?php echo lang('change_admin_password');?>
" <?php if ($_smarty_tpl->tpl_vars['preset_demo']->value == 'yes') {?>disabled<?php }?>><?php echo lang('update');?>
</button>
                        </div>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
                    <?php echo form_close();?>

                </div>
            </div>
        <?php }?>
        <input type="radio" id="tab2" name="tab">
        <label class="tabButton" for="tab2"><?php echo lang('change_user_password');?>
</label>
        <div class="tab">
            <div class="content">
                <?php echo form_open('admin/password/post_change_user_password','role="form" class="" id="change_pass_common" name="change_pass_common" method="post"');?>

                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label><?php echo lang('user_name');?>
</label>
                        <input class="form-control user_autolist" type="text" id="user_name_common" name="user_name_common" value="" autocomplete="Off"><span id="referral_box" style="display:none;"></span> 
                        <span id="erro_user_name"></span>
                    </div>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <label><?php echo lang('new_password');?>
</label>
                        <input class="form-control" name="new_pwd_common" type="password" id="new_pwd_common" autocomplete="Off"/>
                    </div>
                </div>
                <div style="display:none;">
                    <span id='span_new_pwd_common'>
                        <?php echo lang('you_must_enter_new_password');?>

                    </span>
                    <span id='span_new_pwd_gt'>
                        <?php echo lang('the_password_length_should_be_greater_than_6');?>

                    </span>
                </div>
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group">
                        <label><?php echo lang('confirm_password');?>
</label>
                        <input class="form-control" name="confirm_pwd_common" type="password" id="confirm_pwd_common" autocomplete="Off" />
                    </div>
                </div>
                <input type="hidden" name="base_url" id="base_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/">
                <div class="col-sm-3 padding_both_small">
                    <div class="form-group mark_paid">
                        <button class="btn btn-sm btn-primary"  type="submit" name="change_pass_button_common"  id="change_pass_button_common" value="<?php echo lang('change_user_password');?>
" ><?php echo lang('update');?>
</button>
                    </div>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
                <?php echo form_close();?>

            </div>
        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
