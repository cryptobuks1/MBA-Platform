<?php
/* Smarty version 3.1.30, created on 2020-08-05 20:45:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/login/login_employee.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a8dbccb1956_29712774',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0880df08a6e944e3db598c2cbe5b5f6e9285bd59' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/login/login_employee.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/alert_box.tpl' => 1,
    'file:layout/login_footer.tpl' => 1,
  ),
),false)) {
function content_5f2a8dbccb1956_29712774 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_10963197065f2a8dbccb1030_12274627', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_10963197065f2a8dbccb1030_12274627 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg4"><?php echo lang('please_enter_password');?>
</span>
    <span id="error_msg3"><?php echo lang('please_enter_captcha');?>
</span>
</div>
<div class="app app-header-fixed ">


    <div class="container w-xxl w-auto-xs">
        <div class=" app-header-fixed "></div>
        <div class="navbar-brand_login block m-t"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
" /> </div>
        <div class="m-b-lg">
            <?php echo form_open('login/verify_employee_login','id="login_form" name="login_form" class="form-validation" ');?>

            <div class="text-danger wrapper text-center" ng-show="authError">
            </div>
            <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <div class="list-group">
                <div class="list-group-item">
                    <input type="text" name="user_username" id="employee_username" placeholder="<?php echo lang('privileged_user_name');?>
" class="form-control no-border" value="<?php echo $_smarty_tpl->tpl_vars['employee_username']->value;?>
" />
                </div>
                <div class="list-group-item">
                    <input type="password" name="user_password" id="employee_password" placeholder="<?php echo lang('password');?>
" class="form-control no-border">
                </div>
            </div>
            <input type="submit" class="btn btn-lg btn-primary btn-block" id="user_login" name="user_login" value="<?php echo lang('login');?>
" />
            <div class="line line-dashed"></div> <?php echo form_close();?>

        </div>
        <div class="text-center" ng-include="'tpl/blocks/page_footer.html'">

        </div>
    </div>

</div>
<div class="col-sm-12 text-center"> <small class="text-muted "> <?php $_smarty_tpl->_subTemplateRender("file:layout/login_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</small> </div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
