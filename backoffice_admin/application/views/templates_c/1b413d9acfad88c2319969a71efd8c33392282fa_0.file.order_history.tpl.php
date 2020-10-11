<?php
/* Smarty version 3.1.30, created on 2020-08-17 15:00:54
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/order/order_history.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3a0f06913df8_07208609',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b413d9acfad88c2319969a71efd8c33392282fa' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/order/order_history.tpl',
      1 => 1573208495,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f3a0f06913df8_07208609 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/modifier.date_format.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21082925045f3a0f06913317_80603135', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_21082925045f3a0f06913317_80603135 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    
     <div class="panel panel-default">
    <div class="panel-body">
        <?php ob_start();
echo $_smarty_tpl->tpl_vars['SHORT_URL']->value;
$_prefixVariable1=ob_get_clean();
echo form_open($_prefixVariable1,'role="form" class="" name="search_member" id="search_member"
        action="" method="post"');?>

        <input type="hidden" id="search_member_error" value="<?php echo lang('search_member_error');?>
" />
        <input type="hidden" id="search_member_error2" value="<?php echo lang('invalid_user_name');?>
" />
         <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="user_name"><?php echo lang('user_name');?>
</label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="" for="week_date1"><?php echo lang('from_date');?>
</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class=""><?php echo lang('to_date');?>
</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> 
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                    name="search_member_submit">
                    <?php echo lang('search');?>

                </button>
            </div>
        </div>
        <?php echo form_close();?>

    </div>
</div>

    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b><?php echo lang('sl_no');?>
</b></th>
                    <th><b><?php echo lang('order_id');?>
</b></th>
                    <th><b><?php echo lang('user_name');?>
</b></th>
                    <th><b><?php echo lang('customer');?>
</b></th>
                    <th><b><?php echo lang('product');?>
</b></th>
                            <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                        <th><b><?php echo lang('pair_value');?>
</b></th>
                            <?php } else { ?>
                        <th><b><?php echo lang('bv');?>
</b></th>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                        <th><b><?php echo lang('total_pair_value');?>
</b></th>
                            <?php } else { ?>
                        <th><b><?php echo lang('total_bv');?>
</b></th>
                            <?php }?>
                    <th><b><?php echo lang('total_price');?>
</b></th>
                    <th><b><?php echo lang('shipping_method');?>
</b></th>
                    <th><b><?php echo lang('date');?>
</b></th>
                    <th><?php echo lang('action');?>
</th>
                </tr>
            </thead>
            <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <?php $_smarty_tpl->_assignInScope('tabindexvalue', 3);
?>
                <?php $_smarty_tpl->_assignInScope('root', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', 1);
?>
                     <?php $_smarty_tpl->_assignInScope('pv_sum', "0");
?>
                    <?php $_smarty_tpl->_assignInScope('price_sum', "0");
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['order_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                     <?php $_smarty_tpl->_assignInScope('pv_sum', $_smarty_tpl->tpl_vars['pv_sum']->value+$_smarty_tpl->tpl_vars['v']->value['total_pair_value']);
?>
                    
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['order_id_with_prefix'];?>
</td>                                  
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td> 
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['customer_name'];?>
</td>                                 
                            <td><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['products'], 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value) {
?>
                                <?php echo $_smarty_tpl->tpl_vars['k']->value['name'];?>

                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['pair_value'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['total_pair_value'];?>
</td>
                        <td>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['v']->value['total_price'], 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value) {
$_smarty_tpl->_assignInScope('price_sum', $_smarty_tpl->tpl_vars['price_sum']->value+$_smarty_tpl->tpl_vars['k']->value);
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
                        <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['v']->value['date_added'],'%d-%m-%Y');?>
</td>
                        <td style="text-align: center;">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/order_details/<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
" target="_blank" >
                                <button tabindex="<?php echo $_smarty_tpl->tpl_vars['tabindexvalue']->value++;?>
" type="button" name="order_id" id="order_id" title="<?php echo lang('view');?>
" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['order_id'];?>
" class="btn-link text-primary h4"><span class="fa fa-eye"></span></button>
                            </a>
                        </td>
                    </tr>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                     <tr>
                        <td colspan="6"><b><?php echo lang('total_pv');?>
</b></td>
                        <td colspan="1"><b><?php echo $_smarty_tpl->tpl_vars['pv_sum']->value;?>
</b>
                        </td>
                         <td><b><?php echo lang('total_price');?>
</b></td>
                        <td><b><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round($_smarty_tpl->tpl_vars['price_sum']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b>
                        </td>
                    </tr>
                    </tbody>
                    <?php } else { ?>
                        <tbody>
                            <tr><td colspan="13" align="center" ><h4 align="center"><?php echo lang('no_data');?>
</h4></td></tr>
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
