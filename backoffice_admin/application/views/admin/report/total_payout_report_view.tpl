{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="report_name" value="{lang('user_payout_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_total_payout_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_total_payout_report"}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
    {include file="admin/report/header.tpl" name=""}
    <div class="panel panel-default ng-scope">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
            <tbody>
                <thead>
                    <tr>
                        <th>{lang('sl_no')}</th>
                        <th>{lang('full_name')}</th>
                        <th>{lang('user_name')}</th>
                        <th>{lang('address')}</th>
                        <th>{lang('bank')}</th>
                        <th>{lang('account_number')}</th>
                        <th>{lang('total_amount')}</th>
                        <th>{lang('tds')}</th>
                        <th>{lang('service_charge')}</th>
                        <th>{lang('amount_payable')}</th>
                    </tr>
                </thead>
                {assign var="i" value=0} {foreach from=$total_payout item=v} {$i = $i+1}
                <tr>
                    <td> {$i}</td>
                    <td>{$v.full_name}</td>
                    <td>{$v.user_name}</td>
                    <td>{$v.user_address}</td>
                    <td>{$v.user_bank}</td>
                    <td>{$v.acc_number}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.tds*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.service_charge*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                {/foreach}
            </tbody>
            {else}
            <h4 align="center">
                <font>{lang('no_data')}</font>
            </h4>
            {/if}
        </table>
        </div>
    </div>
</div>
{/block}