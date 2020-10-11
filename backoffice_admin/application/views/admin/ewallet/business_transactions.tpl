{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    
</div>



{include file="layout/search_member.tpl"}

<div class="button_back">
                <a href="{$BASE_URL}admin/excel/create_excel_transaction_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>
                <a href="{$BASE_URL}admin/excel/create_csv_transaction_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>
 </div>

<div class="panel panel-default table-responsive">
<div class="panel-body">
    <legend>
        <span class="fieldset-legend">{lang('business_transactions')}{if $user_name}
            : {$user_name}
        {/if}</span>
    </legend>
    <div class="section-dropdown-filter" data-remote="{$BASE_URL}admin/ewallet/business_transactions" data-clear="{lang('clear')}">
        <select class="dropdown_filter" name="debit_credit" data-title="{lang('debit_credit')}" data-value="{$debit_credit}" data-icon="fa fa-exchange">
            <option value="">{lang('any')}</option>
            <option value="debit">{lang('debited')}</option>
            <option value="credit">{lang('credited')}</option>
        </select>
        <select class="dropdown_filter" name="category" data-title="{lang('category')}" data-value="{$category}" data-icon="fa fa-list">
            <option value="">{lang('any')}</option>
            {foreach from=$categories item=v}
                <option value="{$v}">{ucfirst(strtolower(lang($v)))}</option>
            {/foreach}
        </select>
        <select class="dropdown_filter" name="date" data-title="{lang('date')}" data-value="{$date}" data-icon="fa fa-calendar">
            <option value="">{lang('overall')}</option>
            <option value="month">{lang('this_month')}</option>
            <option value="year">{lang('this_year')}</option>
        </select>
    </div>
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead class="table-bordered">
            <tr class="th">
                <th>{lang('sl_no')}</th>
                <th>{lang('amount_type')}</th>
                <th>{lang('user_name')}</th>
                <th>{lang('amount')}</th>
                <th>{lang('date')}</th>
            </tr>
        </thead>
        {if count($all_transaction) > 0}
            <tbody>
                {assign var=i value="0"}
                {foreach from=$all_transaction item=v}
                    {$i = $i + 1}
                    <tr>
                        <td>{$i + $page_id}</td>
                        <td>
                            {if $v.amount_type == 'board_commission' && $MODULE_STATUS['table_status'] == 'yes'}
                                {ucfirst(strtolower(lang('table_commission')))}
                            {else}
                                {ucfirst(strtolower(lang($v.amount_type)))}
                            {/if}
                        </td>
                        <td>
                            {if $v.user_name} {$v.user_name} {else} NA {/if}
                        </td>
                        <td>
                            {$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                            
                            {$payout_cancel = array("withdrawal_cancel","payout_inactive","payout_delete")}
                            {$payout_request = array("payout_request","payout_release_manual")}
                            
                            {if ($v.ewallet_type == 'commission' || $v.amount_type == 'pin_purchase_refund') || ($v.ewallet_type == 'fund_transfer' && $v.amount_type == 'admin_credit') || ($v.ewallet_type == 'payout' && (in_array($v.amount_type, $payout_cancel)))}
                             
                             <span class="label bg-danger">{lang('debited')}</span>
                            {else if ($v.ewallet_type == 'pin_purchase' && $v.amount_type == 'pin_purchase') ||($v.ewallet_type == 'fund_transfer' && $v.amount_type == 'admin_debit') || ($v.ewallet_type == 'payout' && (in_array($v.amount_type,$payout_request))) || ($v.ewallet_type + ' ' + $v.amount_type == 'ewallet_payment_registration') }
                            
                            <span class="label bg-success">{lang('credited')}</span>
                            
                            {else}                             
                                
                            {/if}
                        </td>
                        <td>{$v.date_added}</td>
                    </tr>
                {/foreach}
            </tbody>
        {else}
            <tbody>
                <tr>
                    <td colspan="5">
                        <h4>{lang('No_Details_Found')}</h4>
                    </td>
                </tr>
            </tbody>
        {/if}
    </table>
    </div>
</div>
{$result_per_page}


{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/dropdown_filter.js" type="text/javascript" ></script>
     <script src="{$PUBLIC_URL}javascript/transactions_filter.js" type="text/javascript" ></script>
{/block}