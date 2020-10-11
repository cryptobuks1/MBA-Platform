<?php
/* Smarty version 3.1.30, created on 2020-08-17 09:58:43
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/top_earners_report.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39c833edfa75_53043151',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '08bb7d8faa1ad6aedf671a670c4dbba0cb6ee591' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/select_report/top_earners_report.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f39c833edfa75_53043151 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18193421315f39c833ed0239_03194959', 'script');
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20750315495f39c833edf253_09257133', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_18193421315f39c833ed0239_03194959 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/misc.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_20750315495f39c833edf253_09257133 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php if (count($_smarty_tpl->tpl_vars['top_earners']->value) > 0) {?>
<div class="button_back">
    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_excel_top_earners_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i><?php echo lang('create_excel');?>
</button></a>
    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_csv_top_earners_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i><?php echo lang('create_csv');?>
</button></a>
</div>
<div class="panel panel-default table-responsive">
<div class="panel-body">

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><?php echo lang('sl_no');?>
</th>
                <th><?php echo lang('full_name');?>
</th>
                <th><?php echo lang('username');?>
</th>
                <th><?php echo lang('current_balance');?>
</th>
                <th><?php echo lang('total_earnings');?>
</th>
                <th><?php echo lang('action');?>
</th>
            </tr>
        </thead>
        <tbody>
            <?php $_smarty_tpl->_assignInScope('root', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?> <?php $_smarty_tpl->_assignInScope('i', 0);
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_earners']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?> <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['current_balance']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['total_earnings']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                <td>
                    <a href="#" onclick="javascript:view_earnings('<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
', 'top_earners','<?php echo $_smarty_tpl->tpl_vars['root']->value;?>
')">
                        <div class="field1">
                            <button class="btn-link h4 has-tooltip text-info"><i class="fa fa-info"></i></button>
                            <span class="tooltip green">
            <p><?php echo lang('details');?>
</p>
            </span> </div>
                    </a>
                </td>
            </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </tbody>
    </table>
    </div>
   
</div>
<?php } else { ?>
<div class="panel-body">
    <br/>
    <p align="center"><?php echo lang('no_top_earners');?>
</p>
</div>
 <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php }?> <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
