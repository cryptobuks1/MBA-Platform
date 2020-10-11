<?php
/* Smarty version 3.1.30, created on 2020-09-29 20:54:40
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/commission_report_view.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f731270436aa4_95434617',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ae7965425fe022eb1c22c0a392a0829f63c1a4f0' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/report/commission_report_view.tpl',
      1 => 1580808775,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user/report/report_nav.tpl' => 1,
    'file:user/report/header.tpl' => 1,
  ),
),false)) {
function content_5f731270436aa4_95434617 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19445286935f731270435ec1_72869856', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_19445286935f731270435ec1_72869856 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('excel_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/excel/create_excel_commission_report/".((string)$_smarty_tpl->tpl_vars['user_name']->value));
?> <?php $_smarty_tpl->_assignInScope('csv_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/excel/create_csv_commission_report/".((string)$_smarty_tpl->tpl_vars['user_name']->value));
ob_start();
echo lang('commission_report');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('report_name', $_prefixVariable1);
$_smarty_tpl->_assignInScope('total', 0);
$_smarty_tpl->_assignInScope('tot_pay', 0);
$_smarty_tpl->_subTemplateRender("file:user/report/report_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

<div id="print_area" class="img panel-body panel">
<?php $_smarty_tpl->_subTemplateRender("file:user/report/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

  <div class="panel panel-default  ng-scope">
  <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped"><?php if ($_smarty_tpl->tpl_vars['count']->value >= 1) {?>
      <tbody>
      <thead>
        <tr>
          <th><?php echo lang('sl_no');?>
</th>
            <th><?php echo lang('user_name');?>
</th>
            <th><?php echo lang('full_name');?>
</th>
            <th><?php echo lang('from_user');?>
</th>
            <th><?php echo lang('amount_type');?>
</th>
            <th><?php echo lang('date');?>
</th>
            <th><?php echo lang('total_amount');?>
</th>
            <th><?php echo lang('amount_payable');?>
</th>
        </tr>
        </thead>
        <?php $_smarty_tpl->_assignInScope('i', 1);
?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['from_user'];?>
</td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['view_amt'] == "Board Commission") {?>
                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'];
$_prefixVariable2=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'];
$_prefixVariable3=ob_get_clean();
if ($_prefixVariable2 == 'yes' && $_prefixVariable3 == 'Board') {?>
                            <?php echo lang('table_commission');?>

                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['v']->value['view_amt'];?>

                        <?php }?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'daily_investment') {?>
                            <?php echo lang('daily_investment');?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'purchase_donation') {?>
                        <?php echo lang('purchase_donation');?>

                    <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['v']->value['view_amt'];?>

                    <?php }?>
                </td>
                <td><?php echo date('Y/m/d',strtotime($_smarty_tpl->tpl_vars['v']->value['date']));?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['total_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;
$_smarty_tpl->_assignInScope('total', $_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['v']->value['total_amount']);
?></td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount_payable']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;
$_smarty_tpl->_assignInScope('tot_pay', $_smarty_tpl->tpl_vars['tot_pay']->value+$_smarty_tpl->tpl_vars['v']->value['amount_payable']);
?></td>
            </tr>
            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <tr>
            <th colspan="5" style="text-align:right">Total</th>
            <th><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;
echo $_smarty_tpl->tpl_vars['total_amount']->value;?>
</th>
            <th><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;
echo $_smarty_tpl->tpl_vars['total_amount_payable']->value;?>
</th>
        </tr>
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
