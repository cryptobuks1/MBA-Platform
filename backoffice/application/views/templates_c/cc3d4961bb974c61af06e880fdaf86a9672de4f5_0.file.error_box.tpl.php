<?php
/* Smarty version 3.1.30, created on 2020-09-28 16:33:52
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/error_box.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f7183d0c049f8_61167278',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cc3d4961bb974c61af06e880fdaf86a9672de4f5' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/replica/error_box.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f7183d0c049f8_61167278 (Smarty_Internal_Template $_smarty_tpl) {
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
                <table>
                    <tr>
                        <td>                            
                            <?php echo $_smarty_tpl->tpl_vars['MESSAGE_DETAILS']->value;?>

                        </td>
                    </tr>
                </table>
            </div>
            <a href="javascript:void(0)" id= "close_link" class="panel-close pull-right" style="margin-top: -18px;"> <i class="fa fa-times"></i></a>
        </div>
    <?php }
}?>

<?php }
}
