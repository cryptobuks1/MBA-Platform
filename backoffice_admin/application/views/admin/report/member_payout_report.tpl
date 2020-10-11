{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="report_name" value="{lang('member_wise_payout_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_member_wise_payout_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_member_wise_payout_report"}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
    {assign var="user_name" value=$member_payout["user_name"]}
    {assign var="full_name" value=$member_payout["full_name"]}
    {assign var="total_amount" value=$member_payout["total_amount"]}
    {assign var="amount_payable" value=$member_payout["amount_payable"]}
    {assign var="tds" value=$member_payout["tds"]}
    {assign var="service_charge" value=$member_payout["service_charge"]}
    {assign var="user_pan" value=$member_payout["user_pan"]}
    {assign var="acc_number" value=$member_payout["acc_number"]}
    {assign var="user_bank" value=$member_payout["user_bank"]}
    {assign var="user_address" value=$member_payout["user_address"]}
      <tbody>
                <tr>
                    <td><strong>{lang('user_name')}</strong></td>
                    <td>{$user_name}</td>
                </tr>
                <tr>
                    <td><strong>{lang('full_name')}</strong></td>
                    <td>{$full_name}</td>
                </tr>
                <tr>
                    <td><strong>{lang('address')}</strong></td>
                    <td>{$user_address}</td>
                </tr>
                <tr>
                    <td><strong>{lang('bank')}</strong></td>
                    <td>{$user_bank}</td>
                </tr>
                <tr>
                    <td><strong>{lang('total_amount')}</strong></td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td><strong>{lang('tds')}</strong></td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($tds*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td><strong>{lang('service_charge')}</strong></td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($service_charge*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td><strong>{lang('amount_payable')}</strong></td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
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