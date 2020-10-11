<?php
/* Smarty version 3.1.30, created on 2020-08-06 10:54:20
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2b54bc4eb593_34630527',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '840aadd551c498f8d162597547b8a52872a0f4e2' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_header.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2b54bc4eb593_34630527 (Smarty_Internal_Template $_smarty_tpl) {
?>

        <div class="col w-md bg-light dk b-r bg-auto">
            <div class="wrapper b-b bg">
                <button class="btn btn-sm btn-default pull-right visible-sm visible-xs" ui-toggle-class="show" target="#email-menu"><i class="fa fa-bars"></i></button>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/compose_mail" class="btn btn-sm btn-primary w-xs font-bold"><?php echo lang('compose');?>
</a>
            </div>
            <div class="wrapper hidden-sm hidden-xs" id="email-menu">
                <ul class="nav nav-pills nav-stacked nav-sm">
                    <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == "mail/mail_management") {?>class="active"<?php }?>>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/mail_management"><i class="fa fa-inbox"></i> <?php echo lang('inbox');?>

                            <span class="label label-primary pull-right"><?php if ($_smarty_tpl->tpl_vars['unread_mail']->value > 0) {
echo $_smarty_tpl->tpl_vars['unread_mail']->value;
} else { ?>0<?php }?></span>
                        </a>
                    </li>
                    <li <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == "mail/mail_sent") {?>class="active"<?php }?>>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/mail_sent"><i class="fa fa-envelope-o"></i> <?php echo lang('sent');?>
</a>
                    </li>
                </ul>
            </div>
        </div><?php }
}
