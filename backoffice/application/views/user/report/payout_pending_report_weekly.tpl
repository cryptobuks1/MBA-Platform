{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}user/excel/create_excel_payout_pending_report"} {assign var="csv_url" value="{$BASE_URL}user/excel/create_csv_payout_pending_report"}
{assign var="report_name" value="{lang('member_wise_payout_report')}"}{include file="user/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="user/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{assign var="j" value="0"}
      {if $count >=1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('name')}</th>
            <th>{lang('total_amount')}</th>
            <th>{lang('Date')}</th>
        </tr>
      </thead>
      {foreach from=$binary_details item=v}
        {$j=$j+1}
        <tr>
            <td> {$j} </td>
            <td>{$v.paid_user_id}</td>
            <td>{$v.full_name}</td>
            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.paid_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
            <td>{$v.paid_date}</td>
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