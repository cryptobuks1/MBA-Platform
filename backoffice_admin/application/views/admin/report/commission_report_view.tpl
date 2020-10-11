{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_commission_report/{$user_name}"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_commission_report/{$user_name}"}
{assign var="report_name" value="{lang('commission_report')}"}{$total=0}{$tot_pay=0}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default  ng-scope">
  <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('from_user')}</th>
            <th>{lang('amount_type')}</th>
            <th>{lang('date')}</th>
            <th>{lang('total_amount')}</th>
            <th>{lang('amount_payable')}</th>
        </tr>
        </thead>
        {assign var="i" value=1}
        {foreach from=$details item=v}
            <tr>
                <td>{$i}</td>
                <td>{$v.user_name}</td>
                <td>{$v.full_name}</td>
                <td>{$v.from_user}</td>
                <td>
                    {if $v.view_amt == "Board Commission"}
                        {if {$MODULE_STATUS['table_status']} eq 'yes' && {$MODULE_STATUS['mlm_plan']} eq 'Board'}
                            {lang('table_commission')}
                        {else}
                            {$v.view_amt}
                        {/if}
                        {elseif $v.amount_type == 'daily_investment'}
                            {lang('daily_investment')}
                    {elseif $v.amount_type == 'purchase_donation'}
                        {lang('purchase_donation')}
                    {else}
                        {$v.view_amt}
                    {/if}
                </td>
                <td>{date('Y/m/d', strtotime($v.date))}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}{$total=$total+$v.total_amount}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}{$tot_pay=$tot_pay+$v.amount_payable}</td>
            </tr>

            {$i=$i+1}
        {/foreach}
         <tr>
            <th colspan="6" style="text-align:right">Total</th>
            <th>{$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT}{$total_amount}</th>
            <th>{$DEFAULT_SYMBOL_LEFT}{$DEFAULT_SYMBOL_RIGHT}{$total_amount_payable}</th>
        </tr>
        </tr>
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
