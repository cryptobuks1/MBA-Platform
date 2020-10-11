{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default  ng-scope">
    <div class="panel-body">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('slno')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('description')}</th>
                    <th>{lang('transaction_fee')}</th>
                    <th>{lang('debit')}</th>
                    <th>{lang('credit')}</th>
                    <th>{lang('balance')}</th>
                </tr>
            </thead>
            {if count($ewallet_details) > 0}
                {$debit = 0}
                {$credit = 0}
                {$balance = $previous_ewallet_balance}
                {$i = 0}
                <tbody>
                    {foreach from=$ewallet_details item=v}

                        {if $v.type == 'debit' && $v.amount_type != 'payout_release'}
                            {$balance = $balance - $v.amount - $v.transaction_fee}
                            {$debit = $debit + $v.amount}
                        {/if}
                        {if $v.type == 'credit'}
                            {$balance = $balance + $v.amount - $v.purchase_wallet}
                            {$credit = $credit + $v.amount - $v.purchase_wallet}
                        {/if}

                        {if $v.ewallet_type == "fund_transfer"}
                            {if $v.amount_type == "user_credit"}
                                {$description = "{lang('transfer_from')} {$v.from_user}"}
                            {elseif $v.amount_type == "user_debit"}
                                {$description = "{lang('fund_transfer_to')} {$v.from_user}"}
                            {elseif $v.amount_type == "admin_credit"}
                                {$description = "{lang('credited_by')} {$v.from_user}"}
                            {elseif $v.amount_type == "admin_debit"}
                                {$description = "{lang('deducted_by')} {$v.from_user}"}
                            {/if}
                        {elseif $v.ewallet_type == "commission"}
                            {if $v.amount_type == "donation"}
                                {if $v.type == "debit"}
                                    {$description = "{lang('donation_debit')} {$v.from_user}"}
                                {else}
                                    {$description = "{lang('donation_credit')} {$v.from_user}"}
                                {/if}
                            {elseif $v.amount_type == 'board_commission' && $MODULE_STATUS['table_status'] == 'yes'}
                                {$description = "{lang('table_commission')}"}
                            {else}
                                {if in_array($v.amount_type, $from_user_amount_types)}
                                {$description = "{lang({$v.amount_type})} {lang('from')} {$v.from_user}"}
                                {else}
                                {$description = "{lang({$v.amount_type})}"}
                                {/if}
                            {/if}
                            {elseif $v.ewallet_type == "monthly_payment"}
                            {if $v.amount_type == "user_credit"}
                                {$description = "{lang('transfer_from')} {$v.from_user}"}
                            {elseif $v.amount_type == "user_debit"}
                                {$description = "{lang('monthly_payment')} {lang('by')} {$v.from_user}"}
                            {elseif $v.amount_type == "admin_credit"}
                                {$description = "{lang('credited_by')} {$v.from_user}"}
                            {elseif $v.amount_type == "admin_debit"}
                                {$description = "{lang('deducted_by')} {$v.from_user}"}
                            {/if}
                            
                            {elseif $v.ewallet_type == "customer_upgrade"}
                            {if $v.amount_type == "user_credit"}
                                {$description = "{lang('transfer_from')} {$v.from_user}"}
                            {elseif $v.amount_type == "user_debit"}
                                {$description = "{lang('customer_upgrade')}"}
                            {elseif $v.amount_type == "admin_credit"}
                                {$description = "{lang('credited_by')} {$v.from_user}"}
                            {elseif $v.amount_type == "admin_debit"}
                                {$description = "{lang('deducted_by')} {$v.from_user}"}
                            {/if}
                            
                        {elseif $v.ewallet_type == "ewallet_payment"}
                            {if $v.amount_type == "registration"}
                                {$description = "{lang('deducted_for_registration_of')} {$v.from_user}"}
                            {elseif $v.amount_type == "repurchase"}
                                {$description = "{lang('deducted_for_repurchased_by')} {$v.from_user}"}
                            {elseif $v.amount_type == "package_validity"}
                                {$description = "{lang('deducted_for_membership_renewal_of')} {$v.from_user}"}
                            {elseif $v.amount_type == "upgrade"}
                                {$description = "{lang('deducted_for_upgrade')}"}
                            {/if}
                        {elseif $v.ewallet_type == "payout"}
                            {if $v.amount_type == "payout_request"}
                                {$description = "{lang('deducted_for_payout_request')}"}
                            {elseif $v.amount_type == "payout_release"}
                                {$description = "{lang('payout_released_for_request')}"}
                            {elseif $v.amount_type == "payout_delete"}
                                {$description = "{lang('credited_for_payout_request_delete')}"}
                            {elseif $v.amount_type == "payout_release_manual"}
                                {$description = "{lang('payout_released_by_manual')}"}
                                <!--edited for cancel waiting withrawal-->
                            {elseif $v.amount_type == "withdrawal_cancel"}
                                {$description = "{lang('credited_for_waiting_withdrawal_cancel')}"}
                            {/if}
                            <!--edited for cancel waiting withrawal ends-->
                        {elseif $v.ewallet_type == "pin_purchase"}
                            {if $v.amount_type == "pin_purchase"}
                                {$description = "{lang('deducted_for_pin_purchase')}"}
                            {elseif $v.amount_type == "pin_purchase_delete"}
                                {$description = "{lang('credited_for_pin_purchase_delete')}"}
                            {elseif $v.amount_type == "pin_purchase_refund"}
                                {$description = "{lang('credited_for_pin_purchase_refund')}"}
                            {/if}
                        {elseif $v.ewallet_type == "package_purchase"}
                            {if $v.amount_type == "purchase_donation"}
                                {$description = "{lang('purchase_donation')} {lang('from')} {$v.from_user}"}
                            {/if}
                        {/if}
                        <tr>
                            <td>{$page_id + $i + 1}</td>
                            <td>{$v.date_added}</td>
                            <td>
                                {$description} {if $v.pending_id}<span>(pending)</span>{/if}
                                {if in_array($v.ewallet_type, array('fund_transfer', 'pin_purchase', 'ewallet_payment'))}
                                    <br/>
                                    {lang('transaction_id')}: <font color="#169ac3">{$v.transaction_id}</font>
                                {/if}
                                <br/>
                                {if $v.ewallet_type == 'fund_transfer'}
                                    <font color="#169ac3">{stripslashes($v.transaction_note)}</font>
                                {/if}
                                {if $v.ewallet_type == 'payout' && $v.amount_type != 'payout_release_manual' && $v.amount_type != 'withdrawal_cancel'}
                                    {*{lang('request_id')}: <font color="#169ac3">{$v.transaction_id}</font>
                                    <br/>*}
                                    {if $v.amount_type == 'payout_release'}
                                        {lang('released_amount')}: <font color="#169ac3">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</font>
                                    {/if}
                                {/if}
                            </td>
                            <td>
                                {if $v.ewallet_type == 'fund_transfer'}
                                    {$DEFAULT_SYMBOL_LEFT}{number_format($v.transaction_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                                {else}
                                    NA
                                {/if}
                            </td>
                            <td>
                                {if $v.type == 'debit' && $v.amount_type != 'payout_release'}
                                    <font color="#f16164">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</font>
                                {else}
                                    NA
                                {/if}
                            </td>
                            <td>
                                {if $v.type == 'credit'}
                                    <font color="#00581E">{$DEFAULT_SYMBOL_LEFT}{number_format(($v.amount - $v.purchase_wallet)*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</font>
                                {else}
                                    NA
                                {/if}
                            </td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                        {$i = $i + 1}
                    {/foreach}
                    <tr>
                        <td colspan="6" class="text-right"><b>{lang('available_amount')}</b></td>
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    </tr>
                </tbody>
            {else}
                <tbody><tr><td align="center" colspan="8"><font size="1.125rem">{lang('no_transfer_details')}</font></td></tr></tbody> 
                        {/if}
        </table>
        </div>
    </div>
    </div>
    {$result_per_page}
{/block}