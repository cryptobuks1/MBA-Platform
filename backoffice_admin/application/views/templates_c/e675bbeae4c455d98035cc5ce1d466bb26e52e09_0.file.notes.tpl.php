<?php
/* Smarty version 3.1.30, created on 2020-08-05 10:02:57
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/common/notes.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29f7316454b1_61630420',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e675bbeae4c455d98035cc5ce1d466bb26e52e09' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/common/notes.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f29f7316454b1_61630420 (Smarty_Internal_Template $_smarty_tpl) {
if (DEMO_STATUS == 'yes') {?>
<div class="m-b pink-gradient">
	<div class="card-body ">
		<div class="media">
			<figure class=" avatar-50 "><i class="glyphicon glyphicon-book"></i></figure>
			<h6 class="my-0"><?php echo $_smarty_tpl->tpl_vars['notes']->value;?>
</h6>
		</div>
	</div>
</div>
<?php }
}
}
