<?php
/* Smarty version 3.1.30, created on 2020-08-05 00:33:47
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/login/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2971cb682320_25337235',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6bca10e94ab98380f6ff37cb2965685ccfe5ea09' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/login/index.tpl',
      1 => 1571982579,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/alert_box.tpl' => 1,
    'file:layout/login_footer.tpl' => 1,
  ),
),false)) {
function content_5f2971cb682320_25337235 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14259723525f2971cb681979_47329586', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_14259723525f2971cb681979_47329586 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;"> <span id="error_msg1"><?php echo lang('please_enter_username');?>
</span> <span id="error_msg2"><?php echo lang('please_enter_password');?>
</span> <span id="error_msg3"><?php echo lang('please_enter_captcha');?>
</span> </div>
<div class=" app-header-fixed"></div>
<div class="container w-xxl">
    <div class="navbar-brand_login block m-t"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
" /> </div>
    
    <div class="m-b-lg">
        <?php echo form_open('login/verifylogin','class="" id="login_form" name="login_form" autocomplete="off"');?>

        <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <input type="password" style="display:none">
        <input type="text" style="display:none">
        <div class="text-danger wrapper text-center" ng-show="authError"> </div>
        
        <div class="list-group form-group">
            <div class="list-group-item">
                <input type="text" name="user_username" id="user_username" autocomplete="Off" size="32" maxlength="128" placeholder="<?php echo lang('user_name');?>
" value="<?php echo $_smarty_tpl->tpl_vars['url_user_name']->value;?>
" class="form-control no-border">
            </div>
            <div class="list-group-item form-group">
                <input type="password" name="user_password" id="user_password" size="32" maxlength="32" placeholder="<?php echo lang('password');?>
" class="form-control no-border password">
            </div>
            <?php if ($_smarty_tpl->tpl_vars['CAPTCHA_STATUS']->value == 'yes') {?>
            <div class="list-group-item forget_pass">
                <img src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/user" id="captcha" />
                <a class="pull-right" href="#" onclick="document.getElementById('captcha').src = '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/user/' + Math.random();document.getElementById('captcha_user').focus();" id="change-image"> <?php echo lang('not_readable_change_text');?>
</a>
            </div>
            <div class="list-group-item">
                <input type="text" placeholder="<?php echo lang('enter_cpacha');?>
" class="form-control no-border" name="captcha_user" id="captcha_user" autocomplete="off" /> <?php echo form_error('captcha');?>

            </div>
            <?php }?>
        </div>
        <div class="m-t-xxl">
            <input type="submit" id="user_login" name="user_login" value="<?php echo lang('login');?>
" class="btn btn-lg btn-primary btn-block" /><span id="loginmsg" style="display:none"></span>
        </div>
        <?php echo form_close();?>

        <div class="text-center m-t-md"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
login/forgot_password"><?php echo lang('forgot_password');?>
?</a></div>
        <div class="line line-dashed"></div>
       <!-- <p class="text-center"><small><?php echo lang('dont_have_an_account');?>
? </small></p>
        <a class="btn btn-lg btn-default btn-block" href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
register/user_register" class="register">
                                <?php echo lang('sign_up_now');?>

                            </a>--></div>
    <div class="text-center"></div>
</div>
<div class="col-sm-12 text-center"> <small class="text-muted "><?php $_smarty_tpl->_subTemplateRender("file:layout/login_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</small> </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
