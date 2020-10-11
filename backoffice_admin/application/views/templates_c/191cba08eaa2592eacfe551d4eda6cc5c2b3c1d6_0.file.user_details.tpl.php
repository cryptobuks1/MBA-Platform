<?php
/* Smarty version 3.1.30, created on 2020-08-16 22:57:38
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/user_details.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f392d42c111e1_91858503',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '191cba08eaa2592eacfe551d4eda6cc5c2b3c1d6' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/user_details.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f392d42c111e1_91858503 (Smarty_Internal_Template $_smarty_tpl) {
?>

<table cellpadding="0" cellspacing="0" align="center" class="table table-responsive table-bordered">
    <tr>
        <td><?php echo lang('User_Name');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['user_name'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('full_name');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['name'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('date_of_birth');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['dob'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('gender');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['gender'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('address');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['address'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('pincode');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['pin'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('email');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['email'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('mobile_no');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['mobile'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('country');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['country'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('pan_no');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['pan'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('bank_account_number');?>
</td>
         
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['acc'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('bank_name');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['bank'];?>
</td>
    </tr>
    <tr>
        <td><?php echo lang('branch_name');?>
</td>
        
        <td><?php echo $_smarty_tpl->tpl_vars['user_details']->value[0]['branch'];?>
</td>
    </tr>
</table><?php }
}
