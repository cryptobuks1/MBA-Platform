{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_payout_released_report_daily"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_payout_released_report_daily"}
{assign var="report_name" value="{lang('payout_release_report')}"}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default  ng-scope">
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
            <!-- mark as paid -->
            <th>{lang('status')}</th>
            <!-- ends -->
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
                <!-- mark as paid -->
                <td>{if $v.paid_status == 'yes'}{lang('paid')}{else}{lang('not_paid')}{/if}</td>
                <!-- ends -->
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