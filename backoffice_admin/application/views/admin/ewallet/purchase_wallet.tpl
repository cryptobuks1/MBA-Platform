{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('select_user_name')}</span>
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg">{lang('You_must_enter_user_name')}</span>
</div>

<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

        {include file="layout/search_member.tpl"}


{if $valid_user}
    {if $overview_disp}
        <div id="user_account"></div>
    {/if}
    <div id="username_val" style="display:none;">{$user_name}</div>
    <div class="form-group form-group-right">
        <span class="h4">{lang('purchase_wallet_balance')} {$DEFAULT_SYMBOL_LEFT}{number_format($ewallet_balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</span>
        {if $page_id}
            <br>
            <span class="h4">{lang('previous_balance')}: {$DEFAULT_SYMBOL_LEFT}{number_format($previous_ewallet_balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</span>
        {/if}
        <br>
    </div>
    <div class="panel panel-default">
    <div class="panel-body">
     <legend>
        <span class="fieldset-legend">{lang('purchase_wallet_details')}: {$user_name}</span>
        {if $from_report}
            <a href="{BASE_URL}/admin/select_report/top_earners_report" class="btn btn-addon btn-sm btn-info pull-right"><i class="fa fa-backward"></i>{lang('back')}</a>
        {/if}
    </legend>
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
                            <td>
                                {$description} 
                            </td>
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
                            <b>{lang('no_transfer_details')}</b>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
        </div>
    </div>
    {$result_per_page}
{/if}

{/block}

{block name='script'}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/user_summary_header.js" type="text/javascript" ></script>
{/block}