<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:04:10
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/login/lock_screen.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d7a4ab8a211_27215413',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ff9204d1895df45bc5102848cd60ab43daca060' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/login/lock_screen.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/alert_box.tpl' => 1,
  ),
),false)) {
function content_5f6d7a4ab8a211_27215413 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7477456165f6d7a4ab88cf1_12804747', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8126553535f6d7a4ab89d26_50342043', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_7477456165f6d7a4ab88cf1_12804747 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1"><?php echo lang('please_enter_password');?>
</span>
</div>
<div class="app app-header-fixed ">

    <?php echo form_open('login/validate_lock_screen','role="form" class="" method="POST" name="form" id="form"');?>

    <div class="modal-over bg-black">
        <div class="modal-center lock_screen animated fadeInUp text-center">
            <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <div class="thumb-lg">
                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['user_photo']->value;?>
" class="img-circle">
            </div>
            <p class="h4 m-t m-b"><?php echo $_smarty_tpl->tpl_vars['user_user_name']->value;?>
</p>
            <div class="input-group">
                <input type="password" class="form-control text-sm btn-rounded no-border" placeholder="<?php echo lang('please_enter_password');?>
" id='password' name='user_password'>
                <span class="input-group-btn">
        <button type="submit" class="btn btn-success btn-rounded no-border"><i class="fa fa-arrow-right"></i></button>
      </span>
            </div>
        </div>
    </div>
    <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['user_user_name']->value;?>
" name="user_username" /> <?php echo form_close();?>


</div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_8126553535f6d7a4ab89d26_50342043 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
>
        $("#form").submit(function(){
            var pass = $("#password").val();
            pass = encodeURIComponent(window.btoa(pass));
            $("#password").val(pass);
        }); 
    <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
