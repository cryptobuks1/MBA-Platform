{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_epin_transfer_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_epin_transfer_report"}
{assign var="report_name" value="{lang('epin_transfer_report')}"}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('from_user')}</th>
            <th>{lang('to_user')}</th>
            <th>{lang('epin')}</th>
            <th>{lang('transfer_date')}</th>
        </tr>
        </thead>
        {assign var="i" value=0}
        {foreach from=$transfer_details item=v}
            {$i = $i+1}
            <tr >
                <td> {$i}</td>
                <td>{$v.from_user_name} </td>
                <td>{$v.to_user_name}</td>
                <td>{$v.epin}</td>
                <td>{$v.transfer_date}</td>
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