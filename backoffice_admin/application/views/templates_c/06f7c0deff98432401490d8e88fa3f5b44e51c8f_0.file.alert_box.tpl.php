<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:14:31
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/alert_box.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6201a789c880_42109588',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '06f7c0deff98432401490d8e88fa3f5b44e51c8f' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/alert_box.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6201a789c880_42109588 (Smarty_Internal_Template $_smarty_tpl) {
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
