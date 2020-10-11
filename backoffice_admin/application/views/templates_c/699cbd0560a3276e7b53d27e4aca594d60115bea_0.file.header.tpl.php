<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:23:34
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f296156658348_27465607',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '699cbd0560a3276e7b53d27e4aca594d60115bea' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/header.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f296156658348_27465607 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="img"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/logos/<?php echo $_smarty_tpl->tpl_vars['site_info']->value["logo"];?>
" /> </div>
<div class="row">
    <div class="col-xs-6">
      <h4><?php echo $_smarty_tpl->tpl_vars['site_info']->value["company_name"];?>
</h4>
      <p><?php echo $_smarty_tpl->tpl_vars['site_info']->value["company_address"];?>
</p>
      <p> <?php echo lang('phone');?>
:  <?php echo $_smarty_tpl->tpl_vars['site_info']->value["phone"];?>
<br>
        <?php echo lang('email');?>
:<?php echo $_smarty_tpl->tpl_vars['site_info']->value["email"];?>
 </p>
    </div>
</div>

<!---<h3 class="text-center"><?php echo $_smarty_tpl->tpl_vars['report_name']->value;?>
</h3>
<?php if ($_smarty_tpl->tpl_vars['report_date']->value) {?>
    <p class="text-center"><?php echo $_smarty_tpl->tpl_vars['report_date']->value;?>
</p>
<?php }?>-->
<br><?php }
}
