<?php
/* Smarty version 3.1.30, created on 2020-09-26 16:51:23
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/error_box.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6ee4eb0066a6_09137690',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aae0c602b822a02475380fdb49158138bf91967c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/lcp/error_box.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6ee4eb0066a6_09137690 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['MESSAGE_DETAILS']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['MESSAGE_STATUS']->value) {?>
        <?php if ($_smarty_tpl->tpl_vars['MESSAGE_TYPE']->value) {?>
            <?php $_smarty_tpl->_assignInScope('message_class', "errorHandler alert alert-success");
?>
        <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('message_class', "errorHandler alert alert-danger");
?>
        <?php }?>

        <div id="message_box"  class="<?php echo $_smarty_tpl->tpl_vars['message_class']->value;?>
">
            <div id="message_note">                           
                <?php echo $_smarty_tpl->tpl_vars['MESSAGE_DETAILS']->value;?>

            </div>
            <a href="#" id= "close_link" class="panel-close pull-right" style="margin-top: -18px;"> 
                <i class="fa fa-times"></i>
            </a>
        </div>
    <?php }
}
}
}
