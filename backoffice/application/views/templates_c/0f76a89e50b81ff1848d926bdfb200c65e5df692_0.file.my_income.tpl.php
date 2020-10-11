<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:38:02
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/payout/my_income.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6dac6a2a1e92_34403379',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f76a89e50b81ff1848d926bdfb200c65e5df692' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/payout/my_income.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6dac6a2a1e92_34403379 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7113555605f6dac6a2a1592_39407280', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_7113555605f6dac6a2a1592_39407280 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="panel panel-default table-responsive">
<div class="panel-body">
    <?php $_smarty_tpl->_assignInScope('count', count($_smarty_tpl->tpl_vars['binary']->value));
?>
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead>
            <th><?php echo lang('slno');?>
</th>
            <th><?php echo lang('paid_date');?>
</th>
            <th><?php echo lang('paid_amount');?>
</th>
             <th><?php echo lang('status');?>
</th>
        </thead>
        <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
            <?php $_smarty_tpl->_assignInScope('i', 0);
?> 
            <?php $_smarty_tpl->_assignInScope('status', '');
?> 
            <?php $_smarty_tpl->_assignInScope('class', '');
?>
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['binary']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['i']->value+1+$_smarty_tpl->tpl_vars['page']->value;?>
 </td>
                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['paid_date'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['v']->value['paid_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                <td><?php echo lang($_smarty_tpl->tpl_vars['v']->value['paid_type']);?>
</td>
            </tr>
            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </tbody>
    </table>
    
            <?php } else { ?>
    <tbody>
        <tr>
            <td colspan="8" align="center">
                <h4 align="center"> <?php echo lang('no_income_found');?>
</h4></td>
        </tr>
    </tbody>
    </table>
    </div>
    <?php }?>

</div>
<?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
