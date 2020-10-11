<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:22:14
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/common/chat.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f620376173bd9_12838708',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0977c1985a1d94272575787634634b947a76d19f' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/common/chat.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f620376173bd9_12838708 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['LIVECHAT_STATUS']->value == 'yes') {?>
    <?php echo $_smarty_tpl->tpl_vars['CHAT_CODE']->value;?>

<?php }
}
}
