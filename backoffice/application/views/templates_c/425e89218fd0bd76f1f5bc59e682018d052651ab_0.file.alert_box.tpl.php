<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:33:30
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/alert_box.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d731ad03bd1_95385806',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '425e89218fd0bd76f1f5bc59e682018d052651ab' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/layout/alert_box.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d731ad03bd1_95385806 (Smarty_Internal_Template $_smarty_tpl) {
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
