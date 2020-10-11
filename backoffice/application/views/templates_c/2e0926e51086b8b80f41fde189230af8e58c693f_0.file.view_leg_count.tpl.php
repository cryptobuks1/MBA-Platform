<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:37:48
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/leg_count/view_leg_count.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d822cdd11a2_33214679',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2e0926e51086b8b80f41fde189230af8e58c693f' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/leg_count/view_leg_count.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d822cdd11a2_33214679 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_counter')) require_once '/home/mbatradingacadem/public_html/office/backoffice/application/third_party/Smarty/plugins/function.counter.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13545529875f6d822cdd03f4_38102612', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_13545529875f6d822cdd03f4_38102612 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="button_back">
        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
    </div>
    <div class="panel panel-default table-responsive ng-scope">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th" align="center"> </tr>
                <tr class="th">
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('userid_fullname');?>
</th>
                    <th><?php echo lang('left_point');?>
</th>
                    <th><?php echo lang('right_point');?>
</th>
                    <th><?php echo lang('left_carry');?>
</th>
                    <th><?php echo lang('right_carry');?>
</th>
                    <th><?php echo lang('total_pair');?>
</th>
                    <th><b><?php echo lang('amount');?>
</b></th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['user_leg_detail']->value) != 0) {?>
                <?php $_smarty_tpl->_assignInScope('left_leg_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('right_leg_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('left_carry_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('right_carry_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('total_leg_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('total_leg_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('total_amount_tot', "0");
?>
                <?php $_smarty_tpl->_assignInScope('k', "0");
?>
                <?php $_smarty_tpl->_assignInScope('class', '');
?>
                <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_leg_detail']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>

                        <?php $_smarty_tpl->_assignInScope('left', ((string)$_smarty_tpl->tpl_vars['v']->value['left']));
?>
                        <?php $_smarty_tpl->_assignInScope('right', ((string)$_smarty_tpl->tpl_vars['v']->value['right']));
?>
                        <?php $_smarty_tpl->_assignInScope('left_carry', ((string)$_smarty_tpl->tpl_vars['v']->value['left_carry']));
?>
                        <?php $_smarty_tpl->_assignInScope('right_carry', ((string)$_smarty_tpl->tpl_vars['v']->value['right_carry']));
?>
                        <?php $_smarty_tpl->_assignInScope('tot_leg', ((string)$_smarty_tpl->tpl_vars['v']->value['total_leg']));
?>
                        <?php $_smarty_tpl->_assignInScope('tot_amt', ((string)$_smarty_tpl->tpl_vars['v']->value['total_amount']));
?>

                        <?php $_smarty_tpl->_assignInScope('left_leg_tot', $_smarty_tpl->tpl_vars['left_leg_tot']->value+$_smarty_tpl->tpl_vars['left']->value);
?>
                        <?php $_smarty_tpl->_assignInScope('right_leg_tot', $_smarty_tpl->tpl_vars['right_leg_tot']->value+$_smarty_tpl->tpl_vars['right']->value);
?>
                        <?php $_smarty_tpl->_assignInScope('left_carry_tot', $_smarty_tpl->tpl_vars['left_carry_tot']->value+$_smarty_tpl->tpl_vars['left_carry']->value);
?>
                        <?php $_smarty_tpl->_assignInScope('right_carry_tot', $_smarty_tpl->tpl_vars['right_carry_tot']->value+$_smarty_tpl->tpl_vars['right_carry']->value);
?>
                        <?php $_smarty_tpl->_assignInScope('total_leg_tot', $_smarty_tpl->tpl_vars['total_leg_tot']->value+$_smarty_tpl->tpl_vars['tot_leg']->value);
?>
                        <?php $_smarty_tpl->_assignInScope('total_amount_tot', $_smarty_tpl->tpl_vars['total_amount_tot']->value+$_smarty_tpl->tpl_vars['tot_amt']->value);
?>

                        <?php if ($_smarty_tpl->tpl_vars['k']->value%2 == 0) {?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                        <?php }?>
                        <tr align="center" >
                            <td><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user'];?>
-<?php echo $_smarty_tpl->tpl_vars['v']->value['detail'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['left']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['right']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['left_carry']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['right_carry']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['tot_leg']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['tot_amt']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        </tr>
                        <?php $_smarty_tpl->_assignInScope('k', $_smarty_tpl->tpl_vars['k']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


                    <?php $_smarty_tpl->_assignInScope('class', 'total');
?>

                    <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" align="center" >
                        <td colspan="2" class="text-right"><b><?php echo lang('total');?>
</b></td>
                         
                        <td><b><?php echo $_smarty_tpl->tpl_vars['left_leg_tot']->value;?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['right_leg_tot']->value;?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['left_carry_tot']->value;?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['right_carry_tot']->value;?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['total_leg_tot']->value;?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['total_amount_tot']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b></td>
                    </tr>
                </tbody>
            <?php } else { ?>
                <h3><?php echo lang('no_leg_count_found');?>
</h3>
            <?php }?>          
        </table>
        </div>
       
    </div>
     <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
