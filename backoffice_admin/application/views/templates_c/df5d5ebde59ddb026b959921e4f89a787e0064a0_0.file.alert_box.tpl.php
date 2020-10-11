<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:12:16
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/alert_box.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f295eb0cb3c27_30291114',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'df5d5ebde59ddb026b959921e4f89a787e0064a0' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/layout/alert_box.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f295eb0cb3c27_30291114 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['MESSAGE_DETAILS']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['MESSAGE_STATUS']->value) {?>
        <?php if ($_smarty_tpl->tpl_vars['MESSAGE_TYPE']->value) {?>
            <?php $_smarty_tpl->_assignInScope('message_class', "errorHandler alert alert-success");
?>
        <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('message_class', "errorHandler alert alert-danger");
?>
        <?php }?>
        <div class="<?php echo $_smarty_tpl->tpl_vars['message_class']->value;?>
">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $_smarty_tpl->tpl_vars['MESSAGE_DETAILS']->value;?>

        </div>
    <?php }
}
}
}
