<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:33:30
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/common/chat.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d731ad1edb9_27713327',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41e2c9e76f324d0c74f1199451c5e0f7d95276ee' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/common/chat.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d731ad1edb9_27713327 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['LIVECHAT_STATUS']->value == 'yes') {?>
    <?php echo $_smarty_tpl->tpl_vars['CHAT_CODE']->value;?>

<?php }
}
}
