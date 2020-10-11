<?php
/* Smarty version 3.1.30, created on 2020-09-15 15:33:59
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/business_transactions.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f605247ea7929_90885387',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3c89d7fedc4e92391e9c5e2c6f3fb5c2f4151a99' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/business_transactions.tpl',
      1 => 1575952793,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f605247ea7929_90885387 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15660738015f605247ea5c87_87167192', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6485839775f605247ea75f2_00440308', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15660738015f605247ea5c87_87167192 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    
</div>



<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="button_back">
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_excel_transaction_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i><?php echo lang('create_excel');?>
</button></a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_csv_transaction_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i><?php echo lang('create_csv');?>
</button></a>
 </div>

<div class="panel panel-default table-responsive">
<div class="panel-body">
    <legend>
        <span class="fieldset-legend"><?php echo lang('business_transactions');
if ($_smarty_tpl->tpl_vars['user_name']->value) {?>
            : <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>

        <?php }?></span>
    </legend>
    <div class="section-dropdown-filter" data-remote="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/ewallet/business_transactions" data-clear="<?php echo lang('clear');?>
">
        <select class="dropdown_filter" name="debit_credit" data-title="<?php echo lang('debit_credit');?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['debit_credit']->value;?>
" data-icon="fa fa-exchange">
            <option value=""><?php echo lang('any');?>
</option>
            <option value="debit"><?php echo lang('debited');?>
</option>
            <option value="credit"><?php echo lang('credited');?>
</option>
        </select>
        <select class="dropdown_filter" name="category" data-title="<?php echo lang('category');?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" data-icon="fa fa-list">
            <option value=""><?php echo lang('any');?>
</option>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo ucfirst(strtolower(lang($_smarty_tpl->tpl_vars['v']->value)));?>
</option>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </select>
        <select class="dropdown_filter" name="date" data-title="<?php echo lang('date');?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['date']->value;?>
" data-icon="fa fa-calendar">
            <option value=""><?php echo lang('overall');?>
</option>
            <option value="month"><?php echo lang('this_month');?>
</option>
            <option value="year"><?php echo lang('this_year');?>
</option>
        </select>
    </div>
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead class="table-bordered">
            <tr class="th">
                <th><?php echo lang('sl_no');?>
</th>
                <th><?php echo lang('amount_type');?>
</th>
                <th><?php echo lang('user_name');?>
</th>
                <th><?php echo lang('amount');?>
</th>
                <th><?php echo lang('date');?>
</th>
            </tr>
        </thead>
        <?php if (count($_smarty_tpl->tpl_vars['all_transaction']->value) > 0) {?>
            <tbody>
                <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_transaction']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'board_commission' && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'yes') {?>
                                <?php echo ucfirst(strtolower(lang('table_commission')));?>

                            <?php } else { ?>
                                <?php echo ucfirst(strtolower(lang($_smarty_tpl->tpl_vars['v']->value['amount_type'])));?>

                            <?php }?>
                        </td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['user_name']) {?> <?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 <?php } else { ?> NA <?php }?>
                        </td>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                            
                            <?php $_smarty_tpl->_assignInScope('payout_cancel', array("withdrawal_cancel","payout_inactive","payout_delete"));
?>
                            <?php $_smarty_tpl->_assignInScope('payout_request', array("payout_request","payout_release_manual"));
?>
                            
                            <?php if (($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'commission' || $_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'pin_purchase_refund') || ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'fund_transfer' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'admin_credit') || ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'payout' && (in_array($_smarty_tpl->tpl_vars['v']->value['amount_type'],$_smarty_tpl->tpl_vars['payout_cancel']->value)))) {?>
                             
                             <span class="label bg-danger"><?php echo lang('debited');?>
</span>
                            <?php } elseif (($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'pin_purchase' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'pin_purchase') || ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'fund_transfer' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'admin_debit') || ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'payout' && (in_array($_smarty_tpl->tpl_vars['v']->value['amount_type'],$_smarty_tpl->tpl_vars['payout_request']->value))) || ($_smarty_tpl->tpl_vars['v']->value['ewallet_type']+' '+$_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'ewallet_payment_registration')) {?>
                            
                            <span class="label bg-success"><?php echo lang('credited');?>
</span>
                            
                            <?php } else { ?>                             
                                
                            <?php }?>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date_added'];?>
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
                <tr>
                    <td colspan="5">
                        <h4><?php echo lang('No_Details_Found');?>
</h4>
                    </td>
                </tr>
            </tbody>
        <?php }?>
    </table>
    </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>



<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_6485839775f605247ea75f2_00440308 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/dropdown_filter.js" type="text/javascript" ><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/transactions_filter.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
