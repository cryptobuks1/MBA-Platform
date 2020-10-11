<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:12:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/common/chat.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f295eb0cc1534_18239008',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53183d0bc6c3098ff3885197ecbadcfb517a2f9b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/common/chat.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f295eb0cc1534_18239008 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['LIVECHAT_STATUS']->value == 'yes') {?>
    <?php echo $_smarty_tpl->tpl_vars['CHAT_CODE']->value;?>

<?php }
}
}
