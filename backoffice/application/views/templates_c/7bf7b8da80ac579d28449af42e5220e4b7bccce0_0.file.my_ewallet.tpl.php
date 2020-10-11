<?php
/* Smarty version 3.1.30, created on 2020-09-25 16:25:13
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/my_ewallet.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d8d49118d10_51919699',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7bf7b8da80ac579d28449af42e5220e4b7bccce0' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/ewallet/my_ewallet.tpl',
      1 => 1572951825,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d8d49118d10_51919699 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18419025435f6d8d49117ac7_28992399', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_18419025435f6d8d49117ac7_28992399 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="panel panel-default  ng-scope">
    <div class="panel-body">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo lang('slno');?>
</th>
                    <th><?php echo lang('date');?>
</th>
                    <th><?php echo lang('description');?>
</th>
                    <th><?php echo lang('transaction_fee');?>
</th>
                    <th><?php echo lang('debit');?>
</th>
                    <th><?php echo lang('credit');?>
</th>
                    <th><?php echo lang('balance');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['ewallet_details']->value) > 0) {?>
                <?php $_smarty_tpl->_assignInScope('debit', 0);
?>
                <?php $_smarty_tpl->_assignInScope('credit', 0);
?>
                <?php $_smarty_tpl->_assignInScope('balance', $_smarty_tpl->tpl_vars['previous_ewallet_balance']->value);
?>
                <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                <tbody>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ewallet_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>

                        <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'debit' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] != 'payout_release') {?>
                            <?php $_smarty_tpl->_assignInScope('balance', $_smarty_tpl->tpl_vars['balance']->value-$_smarty_tpl->tpl_vars['v']->value['amount']-$_smarty_tpl->tpl_vars['v']->value['transaction_fee']);
?>
                            <?php $_smarty_tpl->_assignInScope('debit', $_smarty_tpl->tpl_vars['debit']->value+$_smarty_tpl->tpl_vars['v']->value['amount']);
?>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'credit') {?>
                            <?php $_smarty_tpl->_assignInScope('balance', $_smarty_tpl->tpl_vars['balance']->value+$_smarty_tpl->tpl_vars['v']->value['amount']-$_smarty_tpl->tpl_vars['v']->value['purchase_wallet']);
?>
                            <?php $_smarty_tpl->_assignInScope('credit', $_smarty_tpl->tpl_vars['credit']->value+$_smarty_tpl->tpl_vars['v']->value['amount']-$_smarty_tpl->tpl_vars['v']->value['purchase_wallet']);
?>
                        <?php }?>

                        <?php if ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "fund_transfer") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_credit") {?>
                                <?php ob_start();
echo lang('transfer_from');
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable1." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_debit") {?>
                                <?php ob_start();
echo lang('fund_transfer_to');
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable2." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_credit") {?>
                                <?php ob_start();
echo lang('credited_by');
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable3." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_debit") {?>
                                <?php ob_start();
echo lang('deducted_by');
$_prefixVariable4=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable4." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php }?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "commission") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "donation") {?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == "debit") {?>
                                    <?php ob_start();
echo lang('donation_debit');
$_prefixVariable5=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable5." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                                <?php } else { ?>
                                    <?php ob_start();
echo lang('donation_credit');
$_prefixVariable6=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable6." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                                <?php }?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'board_commission' && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'yes') {?>
                                <?php ob_start();
echo lang('table_commission');
$_prefixVariable7=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable7);
?>
                            <?php } else { ?>
                                <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['amount_type'],$_smarty_tpl->tpl_vars['from_user_amount_types']->value)) {?>
                                <?php ob_start();
echo $_smarty_tpl->tpl_vars['v']->value['amount_type'];
$_prefixVariable8=ob_get_clean();
ob_start();
echo lang($_prefixVariable8);
$_prefixVariable9=ob_get_clean();
ob_start();
echo lang('from');
$_prefixVariable10=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable9." ".$_prefixVariable10." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                                <?php } else { ?>
                                <?php ob_start();
echo $_smarty_tpl->tpl_vars['v']->value['amount_type'];
$_prefixVariable11=ob_get_clean();
ob_start();
echo lang($_prefixVariable11);
$_prefixVariable12=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable12);
?>
                                <?php }?>
                            <?php }?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "monthly_payment") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_credit") {?>
                                <?php ob_start();
echo lang('transfer_from');
$_prefixVariable13=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable13." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_debit") {?>
                                <?php ob_start();
echo lang('monthly_payment');
$_prefixVariable14=ob_get_clean();
ob_start();
echo lang('by');
$_prefixVariable15=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable14." ".$_prefixVariable15." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_credit") {?>
                                <?php ob_start();
echo lang('credited_by');
$_prefixVariable16=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable16." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_debit") {?>
                                <?php ob_start();
echo lang('deducted_by');
$_prefixVariable17=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable17." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php }?>
                            
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "customer_upgrade") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_credit") {?>
                                <?php ob_start();
echo lang('transfer_from');
$_prefixVariable18=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable18." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "user_debit") {?>
                                <?php ob_start();
echo lang('customer_upgrade');
$_prefixVariable19=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable19);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_credit") {?>
                                <?php ob_start();
echo lang('credited_by');
$_prefixVariable20=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable20." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "admin_debit") {?>
                                <?php ob_start();
echo lang('deducted_by');
$_prefixVariable21=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable21." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php }?>
                            
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "ewallet_payment") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "registration") {?>
                                <?php ob_start();
echo lang('deducted_for_registration_of');
$_prefixVariable22=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable22." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "repurchase") {?>
                                <?php ob_start();
echo lang('deducted_for_repurchased_by');
$_prefixVariable23=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable23." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "package_validity") {?>
                                <?php ob_start();
echo lang('deducted_for_membership_renewal_of');
$_prefixVariable24=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable24." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "upgrade") {?>
                                <?php ob_start();
echo lang('deducted_for_upgrade');
$_prefixVariable25=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable25);
?>
                            <?php }?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "payout") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "payout_request") {?>
                                <?php ob_start();
echo lang('deducted_for_payout_request');
$_prefixVariable26=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable26);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "payout_release") {?>
                                <?php ob_start();
echo lang('payout_released_for_request');
$_prefixVariable27=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable27);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "payout_delete") {?>
                                <?php ob_start();
echo lang('credited_for_payout_request_delete');
$_prefixVariable28=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable28);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "payout_release_manual") {?>
                                <?php ob_start();
echo lang('payout_released_by_manual');
$_prefixVariable29=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable29);
?>
                                <!--edited for cancel waiting withrawal-->
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "withdrawal_cancel") {?>
                                <?php ob_start();
echo lang('credited_for_waiting_withdrawal_cancel');
$_prefixVariable30=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable30);
?>
                            <?php }?>
                            <!--edited for cancel waiting withrawal ends-->
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "pin_purchase") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "pin_purchase") {?>
                                <?php ob_start();
echo lang('deducted_for_pin_purchase');
$_prefixVariable31=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable31);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "pin_purchase_delete") {?>
                                <?php ob_start();
echo lang('credited_for_pin_purchase_delete');
$_prefixVariable32=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable32);
?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "pin_purchase_refund") {?>
                                <?php ob_start();
echo lang('credited_for_pin_purchase_refund');
$_prefixVariable33=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable33);
?>
                            <?php }?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == "package_purchase") {?>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == "purchase_donation") {?>
                                <?php ob_start();
echo lang('purchase_donation');
$_prefixVariable34=ob_get_clean();
ob_start();
echo lang('from');
$_prefixVariable35=ob_get_clean();
$_smarty_tpl->_assignInScope('description', $_prefixVariable34." ".$_prefixVariable35." ".((string)$_smarty_tpl->tpl_vars['v']->value['from_user']));
?>
                            <?php }?>
                        <?php }?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['page_id']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date_added'];?>
</td>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['description']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['pending_id']) {?><span>(pending)</span><?php }?>
                                <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['ewallet_type'],array('fund_transfer','pin_purchase','ewallet_payment'))) {?>
                                    <br/>
                                    <?php echo lang('transaction_id');?>
: <font color="#169ac3"><?php echo $_smarty_tpl->tpl_vars['v']->value['transaction_id'];?>
</font>
                                <?php }?>
                                <br/>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'fund_transfer') {?>
                                    <font color="#169ac3"><?php echo stripslashes($_smarty_tpl->tpl_vars['v']->value['transaction_note']);?>
</font>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'payout' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] != 'payout_release_manual' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] != 'withdrawal_cancel') {?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'payout_release') {?>
                                        <?php echo lang('released_amount');?>
: <font color="#169ac3"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</font>
                                    <?php }?>
                                <?php }?>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['ewallet_type'] == 'fund_transfer') {?>
                                    <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['transaction_fee']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

                                <?php } else { ?>
                                    NA
                                <?php }?>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'debit' && $_smarty_tpl->tpl_vars['v']->value['amount_type'] != 'payout_release') {?>
                                    <font color="#f16164"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</font>
                                <?php } else { ?>
                                    NA
                                <?php }?>
                            </td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'credit') {?>
                                    <font color="#00581E"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format(($_smarty_tpl->tpl_vars['v']->value['amount']-$_smarty_tpl->tpl_vars['v']->value['purchase_wallet'])*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</font>
                                <?php } else { ?>
                                    NA
                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['balance']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
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
                        <td colspan="6" class="text-right"><b><?php echo lang('available_amount');?>
</b></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['balance']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                    </tr>
                </tbody>
            <?php } else { ?>
                <tbody><tr><td align="center" colspan="8"><font size="1.125rem"><?php echo lang('no_transfer_details');?>
</font></td></tr></tbody> 
                        <?php }?>
        </table>
        </div>
    </div>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
