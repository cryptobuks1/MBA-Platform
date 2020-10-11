<?php
/* Smarty version 3.1.30, created on 2020-09-25 16:25:39
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/order/order_history.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d8d63d6b3e6_46107387',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b306e198ab2784597357a141522153f82335ab37' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/order/order_history.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d8d63d6b3e6_46107387 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/mbatradingacadem/public_html/office/backoffice/application/third_party/Smarty/plugins/modifier.date_format.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12495186805f6d8d63d6a8e8_42108156', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_12495186805f6d8d63d6a8e8_42108156 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th">
                    <th><?php echo lang('order_id');?>
</th>
                    <th><?php echo lang('user_name');?>
</th>
                    <th><?php echo lang('customer');?>
</th>
                    <th><?php echo lang('product');?>
</th>
                        <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                        <th><?php echo lang('total_pair_value');?>
</th>
                        <?php } else { ?>
                        <th><?php echo lang('total_bv');?>
</th>
                        <?php }?>
                    <th><?php echo lang('total_price');?>
</th>
                    <th><?php echo lang('shipping_method');?>
</th>
                    <th><?php echo lang('date');?>
</th>
                    <th><?php echo lang('action');?>
</th>
                </tr>
            </thead>
            <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?> 
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('root', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."user/");
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['order_id_with_prefix'];?>
</td>  
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['customer_name'];?>
</td>  
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['model'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['total_pair_value'];?>
</td>
                            <td>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['total_price'], 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value) {
?>
                                    <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['k']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_method'];?>
</td>
                            <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['date_added'],'%m-%d-%Y');?>
</td>
                            <td style="text-align: center;">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/order_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
" target="_blank"  >
                                    <button type="button" name="order_id" id="order_id" title="<?php echo lang('view_more');?>
" class="btn-link text-primary h4 new_btn" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
"><span class="fa fa-eye"></span></button>
                                </a>
                            </td>                                
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr><td colspan="13" align="center"><h4 align="center"><?php echo lang('invalid_order');?>
.</h4></td></tr>
                </tbody>
            <?php }?>
        </table>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
