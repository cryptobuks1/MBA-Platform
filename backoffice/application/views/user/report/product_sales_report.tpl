{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK} {assign var="report_name" value="{lang('sales_report')}"} {assign var="excel_url" value="{$BASE_URL}user/excel/create_excel_product_sales_report/{$product_type}"} {assign var="csv_url" value="{$BASE_URL}user/excel/create_csv_product_sales_report/{$product_type}"}
{include file="admin/report/report_nav.tpl" name=""}
{$total=0}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('slno')}</th>
            <th>{lang('invoice_no')}</th>
            <th>{lang('prod_name')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('payment_method')}</th>
            <th>{lang('amount')}</th>
        </tr>
      </thead>
      {assign var="i" value=0}
        {foreach from=$sales_report_arr item=v name=sales}
            {$i=$i+1}
            <tr>
                <td>{counter}</td>
                <td>{$v.invoice_no}</td>
                <td>{$v.prod_id}</td>
                <td>{$v.user_id} {if $v.pending_id}<span>(pending)</span>{/if}</td>
                <td>{lang($v.payment_method)}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}{$total=$total+$v.amount}</td>
            </tr>
        {if $smarty.foreach.sales.last}
            <tr>
                <td colspan="5" class="text-right"><b>{lang('total_amount')}</b></td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($total*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}{$total=$total+$v.amount}</td>
            </tr>
        {/if}
        {/foreach}
        </tbody>
        {else}
        <h4 align="center">{lang('no_data')}</h4>
    {/if}
    </table>
  </div>
  </div>
</div>
{/block}