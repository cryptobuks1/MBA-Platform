<?php
/* Smarty version 3.1.30, created on 2020-09-25 19:46:19
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/login/forgot_password.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6dbc6b0525e9_68153294',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a09df034c3260a9f6fdc6184658f62a5316ff11' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/login/forgot_password.tpl',
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
function content_5f6dbc6b0525e9_68153294 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9529691825f6dbc6b051c36_88981617', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_9529691825f6dbc6b051c36_88981617 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1"><?php echo lang('please_enter_username');?>
</span>
    <span id="error_msg2"><?php echo lang('you_must_enter_email');?>
</span>
    <span id="error_msg3"><?php echo lang('please_enter_captcha');?>
</span>
</div>
<div class="app app-header-fixed ">


<div class="container w-xxl  w-auto-xs">
<div class=" app-header-fixed "></div>
   <div class="navbar-brand_login block m-t"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value['logo'];?>
" /> </div>
  <div class="m-b-lg">
    <?php echo form_open('','class="login_form form-validation" id="forgot_password" name="forgot_password" method="post" onload="onloadCaptcha();"');?>

      <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

      <div class="list-group">
        <div class="list-group-item form-group">
          <input type="text" id="user_name" name="user_name" placeholder="<?php echo lang('user_name');?>
" AUTOCOMPLETE = "OFF" class="form-control no-border" />
            <?php echo form_error('user_name');?>

        </div>

        <div class="list-group-item form-group">
           <input type="email" id="e_mail" name="e_mail" placeholder="<?php echo lang('email');?>
" class="form-control no-border" />
            <?php echo form_error('e_mail');?>

        </div>
        <div class="list-group-item forget_pass">
         <img src="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin" id="captcha">
         <a class="pull-right" href="#" onclick="
                                             document.getElementById('captcha').src = '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
captcha/load_captcha/admin/' + Math.random();
                                             document.getElementById('captcha-form').focus();"
                                   id="change-image"><?php echo lang('not_readable_change_text');?>
</a>
        </div>
        <div class="list-group-item">
           <input type="text" placeholder="Enter Capcha" class="form-control no-border"  name="captcha" id="captcha-form" autocomplete="off" />
        </div>
      </div>
      <input type="submit" id="forgot_password_submit" name="forgot_password_submit" class="btn btn-lg btn-primary btn-block" value="<?php echo lang('send_request');?>
" />

    <?php echo form_close();?>


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
