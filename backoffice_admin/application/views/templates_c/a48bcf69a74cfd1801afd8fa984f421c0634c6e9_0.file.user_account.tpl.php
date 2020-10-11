<?php
/* Smarty version 3.1.30, created on 2020-08-05 18:55:33
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/profile/user_account.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a7405e76612_01219038',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a48bcf69a74cfd1801afd8fa984f421c0634c6e9' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/profile/user_account.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f2a7405e76612_01219038 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5594311135f2a7405e75005_16006234', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15856518805f2a7405e76103_28540526', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_5594311135f2a7405e75005_16006234 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
	<span id="error_msg"><?php echo lang('you_must_enter_user_name');?>
</span>
	<span id="row_msg"><?php echo lang('rows');?>
</span>
	<span id="show_msg"><?php echo lang('shows');?>
</span>
</div>

<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if ($_smarty_tpl->tpl_vars['posted']->value) {?>
	<div id="user_account"></div>
	<div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</div>
<?php }?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_15856518805f2a7405e76103_28540526 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

	<?php echo '<script'; ?>
>
		$(function () {
			ValidateSearchMember.init();
		});
	<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
