<?php
/* Smarty version 3.1.30, created on 2020-08-04 23:27:03
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/payout_released_report_weekly.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f296227edae14_95593728',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '59ecfa576d4fa2274a745203176e826f533a9382' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/payout_released_report_weekly.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/report/report_nav.tpl' => 1,
    'file:admin/report/header.tpl' => 1,
  ),
),false)) {
function content_5f296227edae14_95593728 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_16076779395f296227eda4f2_02661966', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_16076779395f296227eda4f2_02661966 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('excel_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/excel/create_excel_payout_released_report_weekly");
?> <?php $_smarty_tpl->_assignInScope('csv_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/excel/create_csv_payout_released_report_weekly");
ob_start();
echo lang('payout_release_report');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('report_name', $_prefixVariable1);
$_smarty_tpl->_subTemplateRender("file:admin/report/report_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

<div id="print_area" class="img panel-body panel">
<?php $_smarty_tpl->_subTemplateRender("file:admin/report/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

  <div class="panel panel-default ng-scope">
  <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped"><?php $_smarty_tpl->_assignInScope('j', "0");
?>
      <?php if ($_smarty_tpl->tpl_vars['count']->value >= 1) {?>
      <tbody>
      <tbody>
      <thead>
        <tr>
          <th><?php echo lang('sl_no');?>
</th>
            <th><?php echo lang('user_name');?>
</th>
            <th><?php echo lang('name');?>
</th>
            <th><?php echo lang('total_amount');?>
</th>
            <th><?php echo lang('Date');?>
</th>
                <!-- mark as paid -->
            <th><?php echo lang('status');?>
</th>
                <!-- ends -->
        </tr>
      </thead>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['binary_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <?php $_smarty_tpl->_assignInScope('j', $_smarty_tpl->tpl_vars['j']->value+1);
?>
            <tr >
                <td> <?php echo $_smarty_tpl->tpl_vars['j']->value;?>
 </td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_user_id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
                    <!-- mark as paid -->
                    <td><?php if ($_smarty_tpl->tpl_vars['v']->value['paid_status'] == 'yes') {
echo lang('paid');
} else {
echo lang('not_paid');
}?></td>
                    <!-- ends -->
            </tr>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </tbody>
      <?php } else { ?>
        <h4 align="center">
            <font><?php echo lang('no_data');?>
</font>
        </h4>
        <?php }?>
    </table>
    </div>
  </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
