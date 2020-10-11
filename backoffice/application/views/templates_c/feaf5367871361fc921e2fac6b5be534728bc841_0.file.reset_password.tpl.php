<?php
/* Smarty version 3.1.30, created on 2020-09-28 13:53:20
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/login/reset_password.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f715e3048bdc1_34275224',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'feaf5367871361fc921e2fac6b5be534728bc841' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/login/reset_password.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/alert_box.tpl' => 2,
    'file:layout/error_box.tpl' => 1,
    'file:layout/login_footer.tpl' => 1,
  ),
),false)) {
function content_5f715e3048bdc1_34275224 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10494724125f715e3048b418_17427032', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_10494724125f715e3048b418_17427032 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="validate_msg15"><?php echo lang('you_must_enter_password');?>
</span>
    <span id="validate_msg18"><?php echo lang('password_miss_match');?>
</span>
    <span id="validate_msg16"><?php echo lang('minimum_six_characters_required');?>
</span>
    <span id="validate_msg17"><?php echo lang('you_must_enter_your_password_again');?>
</span>

</div>
<div class="app app-header-fixed ">


    <div class="container w-xxl w-auto-xs">
        <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <div class=" app-header-fixed "></div>
        <div class="navbar-brand_login block m-t"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
" /> </div>
        <div class="m-b-lg">
            <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
 <?php echo form_open('','id="reset_password_form" class="form-validation" name="reset_password_form" method="post"');?>

            <input type="hidden" id="key" name="key" value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
            <input type="hidden" name="user_name" id="user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
">
            <div class="text-danger wrapper text-center" ng-show="authError">
            </div>
            <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <div class="list-group">
                <div class="list-group-item">
                    <input type="password" class="form-control no-border" id="pass" name="pass" placeholder="<?php echo lang('new_password');?>
"><?php echo form_error('pass');?>

                </div>

                <div class="list-group-item">
                    <input type="password" class="form-control no-border" id="confirm_pass" name="confirm_pass" placeholder="<?php echo lang('confirm_password');?>
"><?php echo form_error('confirm_pass');?>

                </div>
                <div class="list-group-item forget_pass">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin" id="captcha" />
                    <a href="#" onclick="
                                                document.getElementById('captcha').src = '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin/' + Math.random();
                                                document.getElementById('captcha-form').focus();" id="change-image" class="pull-right"><?php echo lang('not_readable_change_text');?>
</a>
                </div>
                <div class="list-group-item">
                    <input type="text" placeholder="<?php echo lang('enter_cpacha');?>
" name="captcha" id="captcha-form" autocomplete="off" class="form-control no-border" />
                </div>
            </div>
            <input type="submit" id="reset_password_submit" class="btn btn-lg btn-primary btn-block" name="reset_password_submit" value="<?php echo lang('reset_password');?>
" /> <?php echo form_close();?>

        </div>
        <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

        </div>
    </div>

</div>
<div class="col-sm-12 text-center"> <small class="text-muted "><?php $_smarty_tpl->_subTemplateRender("file:layout/login_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</small> </div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
