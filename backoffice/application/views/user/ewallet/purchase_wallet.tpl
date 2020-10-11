{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="label_field_is_required">{lang('field_is_required')}</span>
        <span id="label_enter_valid_field">{lang('enter_valid_field')}</span>
        <span id="label_field_greater_than_zero">{lang('field_greater_than_zero')}</span>
        <span id="label_amount">{lang('amount')|strtolower}</span>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('add_fund')}</span></legend>
            {form_open('user/add_purchase_wallet_amount','role="form" id="purchase_wallet" name="purchase_wallet" method="post"')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required">{lang('amount')}</label>
                    <input type="text" class="form-control" name="amount" id="amount" maxlength="10" value="">
                    {form_error('amount')}
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button class="btn btn-sm btn-primary btn-addon" type="submit" id="add_fund" value="add_fund" name="add_fund">
                        <i class="fa fa-paypal"></i>
                        {lang('pay_with_paypal')}
                    </button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend">{lang('wallet_history')}</span></legend>
            <div class="form-group form-group-right">
                <span class="h4">
                    {lang('wallet_balance')}:
                    {$DEFAULT_SYMBOL_LEFT}{number_format($ewallet_balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                </span>
                {if $page_id}
                    <br/>
                    <span class="h4">{lang('previous_balance')}:
                        {$DEFAULT_SYMBOL_LEFT}{number_format($previous_ewallet_balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                    </span>
                {/if}
            </div>
            <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead class="table-bordered">
                        <tr class="th">
                            <th>{lang('slno')}</th>
                            <th>{lang('date')}</th>
                            <th>{lang('description')}</th>
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
                                {if $v.type == 'debit'}
                                    {$balance = $balance - $v.amount}
                                    {$debit = $debit + $v.amount}
                                {/if}
                                {if $v.type == 'credit'}
                                    {$balance = $balance + $v.amount}
                                    {$credit = $credit + $v.amount}
                                {/if}
                                {if $v.amount_type == "donation"}
                                    {if $v.type == "debit"}
                                        {$description = "{lang('donation_debit')} {$v.from_user}"}
                                    {else}
                                        {$description = "{lang('donation_credit')} {$v.from_user}"}
                                    {/if}
                                {elseif $v.amount_type == 'board_commission' && $MODULE_STATUS['table_status'] == 'yes'}
                                    {$description = "{lang('table_commission')}"}
                                {elseif $v.amount_type == "repurchase"}
                                    {$description = "{lang('deducted_for_repurchase_by')} {$v.from_user}"}
                                {elseif $v.amount_type == "purchase_donation"}
                                    {$description = "{lang('purchase_donation')} {lang('from')} {$v.from_user}"}
                                {elseif in_array($v.amount_type, $from_user_amount_types)}
                                    {$description = "{lang({$v.amount_type})} {lang('from')} {$v.from_user}"}
                                {else}
                                    {$description = "{lang({$v.amount_type})}"}
                                {/if}
                                <tr>
                                    <td>{$page_id + $i + 1}</td>
                                    <td>{$v.date}</td>
                                    <td>{$description}</td>
                                    <td>
                                        {if $v.type == 'debit'}
                                            <font color="#f16164">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</font>
                                        {else}
                                            NA
                                        {/if}
                                    </td>
                                    <td>
                                        {if $v.type == 'credit'}
                                            <font color="#00581E">{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</font>
                                        {else}
                                            NA
                                        {/if}
                                    </td>
                                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                </tr>
                                {$i = $i + 1}
                            {/foreach}
                            <tr>
                                <td colspan="5" class="text-right"><b>{lang('available_amount')}</b></td>
                                <td>
                                    <b>{$DEFAULT_SYMBOL_LEFT}{number_format($balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                                </td>
                            </tr>
                        </tbody>
                    {else}
                        <tbody>
                            <tr>
                                <td align="center" colspan="7">
                                    <b>{lang('no_data')}</b>
                                </td>
                            </tr>
                        </tbody>
                    {/if}
                </table>
            </div>
            {$result_per_page}
        </div>
    </div>
    

{/block}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/purchase_wallet.js"></script>
{/block}