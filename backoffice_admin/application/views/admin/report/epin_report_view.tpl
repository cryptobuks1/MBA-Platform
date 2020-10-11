{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_epin_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_epin_report"}
{assign var="report_name" value="{lang('epin_report')}"}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
   <div class="panel panel-default ng-scope">
   <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('used_user')}</th>
            <th>{lang('epin')}</th>
            <th>{lang('pin_uploaded_date')}</th>
            <th>{lang('epin_amount')}</th>
            <th>{lang('pin_balance_amount')}</th>
        </tr>
        {assign var="i" value=0}
        {foreach from=$pin_details item=v}
            {$i = $i+1}
            <tr >
                <td> {$i}</td>
                <td>{$v.used_user} {if $v.pending_id}<span>(pending)</span>{/if}</td>
                <td>{$v.pin_number}</td>
                <td>{$v.pin_alloc_date}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.pin_balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
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