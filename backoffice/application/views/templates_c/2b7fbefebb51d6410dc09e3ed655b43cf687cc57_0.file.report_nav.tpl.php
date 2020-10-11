<?php
/* Smarty version 3.1.30, created on 2020-09-29 13:54:10
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/report_nav.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f72afe2f12426_64200831',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b7fbefebb51d6410dc09e3ed655b43cf687cc57' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/report_nav.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f72afe2f12426_64200831 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="button_back">
    <?php if ($_smarty_tpl->tpl_vars['excel_url']->value) {?><a href="<?php echo $_smarty_tpl->tpl_vars['excel_url']->value;?>
"><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i><?php echo lang('create_excel');?>
</button></a><?php }?> <?php if ($_smarty_tpl->tpl_vars['csv_url']->value) {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['csv_url']->value;?>
"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i><?php echo lang('create_csv');?>
</button></a><?php }?>
    <a onClick="print_report(); return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon hidden-xs hidden-sm hidden-md"><i class="icon-printer"></i><?php echo lang('Print');?>
</button>
    </a></div><?php }
}
