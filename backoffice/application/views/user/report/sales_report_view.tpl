{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}user/excel/create_excel_sales_report/{$product_type}"} {assign var="csv_url" value="{$BASE_URL}user/excel/create_csv_sales_report/{$product_type}"}
{assign var="report_name" value="{lang('sales_report')}"}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="user/report/header.tpl" name=""}
  <div class="panel panel-defaultng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
            <th>{lang('sl_no')}</th>
            <th>{lang('invoice_no')}</th>
            <th>{lang('prod_name')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('payment_method')}</th>
            <th>{lang('amount')}</th>
        </tr>
        </thead>
        {assign var="i" value=0}
        {foreach from=$report_arr item=v}
        {$i=$i+1}
        <tr class="">
            <td>{counter}</td>
            <td>{$v.invoice_no}</td>
            <td>{$v.prod_id}</td>
            <td>{$v.user_id} {if $v.pending_id}<span>(pending)</span>{/if}</td>

            <td>{lang($v.payment_method)}</td>
            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
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