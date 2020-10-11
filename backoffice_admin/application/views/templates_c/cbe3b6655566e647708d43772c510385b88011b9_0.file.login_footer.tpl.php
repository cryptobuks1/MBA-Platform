<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:14:31
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/login_footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6201a78c4291_64197549',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbe3b6655566e647708d43772c510385b88011b9' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/login_footer.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6201a78c4291_64197549 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- footer -->
<?php echo date('Y');?>
 &copy; <?php echo $_smarty_tpl->tpl_vars['site_info']->value['company_name'];?>
 <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {
if ($_smarty_tpl->tpl_vars['DEMO_STATUS']->value == 'yes') {?> - <a href="https://ioss.in" target="_blank" style="text-decoration: none; color: #169ac3;"><?php echo lang('developed_by_infinite_open_source_solution_llp');?>
</a> <?php }
}?>
<!-- / footer --><?php }
}
