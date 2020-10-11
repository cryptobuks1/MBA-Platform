<?php
/* Smarty version 3.1.30, created on 2020-09-29 13:54:10
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/payout_released_report_weekly.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f72afe2f03148_52724145',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f684bf8d8b892b867005729835a06a08eefb2189' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/payout_released_report_weekly.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user/report/report_nav.tpl' => 1,
    'file:user/report/header.tpl' => 1,
  ),
),false)) {
function content_5f72afe2f03148_52724145 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3470690465f72afe2f02893_84704484', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3470690465f72afe2f02893_84704484 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('excel_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/excel/create_excel_payout_released_report_weekly");
?> <?php $_smarty_tpl->_assignInScope('csv_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/excel/create_csv_payout_released_report_weekly");
ob_start();
echo lang('payout_release_report');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('report_name', $_prefixVariable1);
$_smarty_tpl->_subTemplateRender("file:user/report/report_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

<div id="print_area" class="img panel-body panel">
<?php $_smarty_tpl->_subTemplateRender("file:user/report/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
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
