<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:23:34
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/report_nav.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2961566537f3_54819685',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a882729401788cbd50abced381cd7ec42b9dce85' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/report_nav.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2961566537f3_54819685 (Smarty_Internal_Template $_smarty_tpl) {
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
