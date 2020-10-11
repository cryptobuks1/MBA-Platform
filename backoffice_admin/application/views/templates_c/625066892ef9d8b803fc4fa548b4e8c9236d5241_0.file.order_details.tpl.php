<?php
/* Smarty version 3.1.30, created on 2020-08-17 15:01:07
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/order/order_details.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3a0f135d1975_04558374',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '625066892ef9d8b803fc4fa548b4e8c9236d5241' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/order/order_details.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f3a0f135d1975_04558374 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.date_format.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2312290095f3a0f135d0cb6_33967302', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2312290095f3a0f135d0cb6_33967302 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="button_back">
                <a onClick="print_report();
            return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="icon-printer"></i><?php echo lang('Print');?>
</button>
                </a></div>
            <div class="panel panel-default table-responsive"  id="print_area">
                <table border="0" width="700" height="100" align="center">
                    <tbody>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <tr>
                                <td colspan="2"><h3><b><?php echo lang('order_id');?>
:<font color="#7266ba ">#<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id_with_prefix'];?>
 </font></b></h3></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b><?php echo lang('date_added');?>
: </b><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['date_added'],'%m-%d-%Y');?>
</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b><?php echo lang('shipping_method');?>
: </b><?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_method'];?>
</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td><h2><?php echo lang('payment_address');?>
</h2>
                                    <b><?php echo $_smarty_tpl->tpl_vars['v']->value['payment_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_lastname'];?>
</b><br>
                                    <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_address_1'];?>
<br>
                                    <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_city'];?>
, <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_zone'];?>
<br>
                                    <?php echo $_smarty_tpl->tpl_vars['v']->value['payment_country'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['shipping_method'] != '') {?>
                                    <td><h2><?php echo lang('shipping_address');?>
</h2>
                                        <b><?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_lastname'];?>
</b><br>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_address_1'];?>
<br>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_city'];?>
, <?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_zone'];?>
<br>
                                        <?php echo $_smarty_tpl->tpl_vars['v']->value['shipping_country'];?>
 </td>
                                    <?php }?>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h2><b><?php echo lang('order_products');?>
</b></h2>
                                    <table class="table table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <td><b><?php echo lang('product');?>
</b></td>
                                                <td><b><?php echo lang('quantity');?>
</b></td>
                                                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                                                    <td><b><?php echo lang('pair_value');?>
</b></td>
                                                <?php } else { ?>
                                                    <td><b><?php echo lang('bv');?>
</b></td>
                                                <?php }?>
                                                <td><b><?php echo lang('price');?>
</b></td>
                                                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                                                    <td><b><?php echo lang('total_pair_value');?>
</b></td>
                                                <?php } else { ?>
                                                    <td><b><?php echo lang('total_bv');?>
</b></td>
                                                <?php }?>
                                                <td><b><?php echo lang('total');?>
</b></td>    
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $_smarty_tpl->_assignInScope('root', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['products'], 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value) {
?>
                                                <tr>
                                                <tr>                                      
                                                    <td><?php echo $_smarty_tpl->tpl_vars['k']->value['name'];?>
</td>                           
                                                    <td><?php echo $_smarty_tpl->tpl_vars['k']->value['quantity'];?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['k']->value['pair_value'];?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['k']->value['price']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['k']->value['pair_value']*$_smarty_tpl->tpl_vars['k']->value['quantity'];?>
</td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['k']->value['total']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                                </tr>
                                                <tr> 
                                                    <td colspan="6"><hr></td>
                                                </tr>
                                            <hr>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
   
                                        </tbody>
                                    </table></td>
                            </tr>
                            <tr>
                                <td colspan="2"><table border="0" width="30%" height="100" align="right" class="tbl_bot ">
                                        <tbody>
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['order_total'], 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
                                                <tr>
                                                    <td width="60%"><h5><?php echo $_smarty_tpl->tpl_vars['m']->value['title'];?>
</h5></td>
                                                    <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['m']->value['value']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                                </tr>
                                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                        </tbody>
                                    </table></td>
                            </tr>
                            
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </tbody>
                </table><br> 
            </div> 
        </div>
       
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
