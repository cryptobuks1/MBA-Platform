<?php
/* Smarty version 3.1.30, created on 2020-08-07 18:26:18
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/total_joining_daily.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2d102ad84ef7_35347782',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'afab5babc4fa324209ff1c038831cd77162121c5' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/report/total_joining_daily.tpl',
      1 => 1571828164,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/report/report_nav.tpl' => 1,
    'file:admin/report/header.tpl' => 1,
  ),
),false)) {
function content_5f2d102ad84ef7_35347782 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3853452825f2d102ad84517_91990421', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_3853452825f2d102ad84517_91990421 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
ob_start();
echo lang('user_joining_report');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('report_name', $_prefixVariable1);
?> <?php $_smarty_tpl->_assignInScope('excel_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/excel/create_excel_joining_report_daily");
?> <?php $_smarty_tpl->_assignInScope('csv_url', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/excel/create_csv_joining_report_daily");
?> <?php $_smarty_tpl->_subTemplateRender("file:admin/report/report_nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

<div id="print_area" class="img panel-body panel">
<?php $_smarty_tpl->_subTemplateRender("file:admin/report/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

  <div class="panel panel-default ng-scope"><?php if ($_smarty_tpl->tpl_vars['count']->value >= 1) {?>
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <tbody>
      <thead>
        <tr class="th">
          <th><?php echo lang('sl_no');?>
</th>
            <th><?php echo lang('user_name');?>
</th>
            <th><?php echo lang('full_name');?>
</th>
            <th><?php echo lang('upline_name');?>
</th>
            <th><?php echo lang('sponser_name');?>
</th>
            <th><?php echo lang('join_type');?>
</th>
            <th><?php echo lang('status');?>
</th>
            <th><?php echo lang('date_of_joining');?>
</th>
        </tr>
        </thead>
        <?php $_smarty_tpl->_assignInScope('i', 0);
?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['todays_join']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?>
            <?php $_smarty_tpl->_assignInScope('stat', "ACTIVE");
?>
        <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('stat', "BLOCKED");
?>
        <?php }?>
        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_full_name'];?>
</td>
            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['father_user']) {
echo $_smarty_tpl->tpl_vars['v']->value['father_user'];
} else { ?>NA<?php }?></td>
            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['sponsor_name']) {
echo $_smarty_tpl->tpl_vars['v']->value['sponsor_name'];
} else { ?>NA<?php }?></td>
            <td>
                <?php if ($_smarty_tpl->tpl_vars['v']->value['join_type'] == 'customer') {?>
                    <?php echo lang('customer');?>

                 <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['join_type'] == 'affiliate') {?>
                    <?php echo lang('affiliate');?>

                <?php } else { ?>
                    NA
                <?php }?></td>
            <td><?php echo $_smarty_tpl->tpl_vars['stat']->value;?>
</td>
            <td><?php echo date('Y/m/d',strtotime($_smarty_tpl->tpl_vars['v']->value['date_of_joining']));?>
</td>
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
