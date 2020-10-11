<?php
/* Smarty version 3.1.30, created on 2020-08-07 15:58:06
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/leg_count/view_leg_count.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2ced6e04c864_47809834',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5241f3fe65f989f62f4be890e03789a0feaf99f6' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/leg_count/view_leg_count.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f2ced6e04c864_47809834 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1622744085f2ced6e04bbb4_27595925', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_1622744085f2ced6e04bbb4_27595925 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    <span id="error_msg"><?php echo lang('you_must_enter_user_name');?>
</span>
    <span id="row_msg"><?php echo lang('rows');?>
</span>
    <span id="show_msg"><?php echo lang('shows');?>
</span>
</div>

<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if (isset($_smarty_tpl->tpl_vars['user_name']->value) && $_smarty_tpl->tpl_vars['is_valid_username']->value) {?>
    <div id="user_account"></div>
    <div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</div>
   

    <div class="panel panel-default">
    <div class="panel-body">
     <legend>
        <span class="fieldset-legend"><?php echo lang('binary_details');?>
: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
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
                    <th><?php echo lang('amount');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['user_leg_detail']->value) > 0) {?>
                <tbody>
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
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
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
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
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
echo round($_smarty_tpl->tpl_vars['tot_amt']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    
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
echo round($_smarty_tpl->tpl_vars['total_amount_tot']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b></td>
                </tbody>
            <?php } else { ?>
                <?php if ($_smarty_tpl->tpl_vars['is_valid_username']->value) {?>
                    <tbody>
                        <tr>
                            <td colspan="8">
                                <h4><?php echo lang('no_referels');?>
</h4>
                            </td>
                        </tr>
                    </tbody>
                <?php } else { ?>
                    <tbody>
                        <tr>
                            <td colspan="8">
                                <h4><?php echo lang('Username_not_Exists');?>
</h4>
                            </td>
                        </tr>
                    </tbody>
                <?php }?>
            <?php }?>
        </table>
        </div>
        </div>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php }?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
