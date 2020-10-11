{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}user/excel/create_excel_epin_transfer_report"} {assign var="csv_url" value="{$BASE_URL}user/excel/create_csv_epin_transfer_report"}
{assign var="report_name" value="{lang('epin_transfer_report')}"}{include file="user/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="user/report/header.tpl" name=""}
  <div class="panel panel-default table-responsive ng-scope">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('user')}</th>
            <th>{lang('epin')}</th>
            <th>{lang('transfer_date')}</th>
            <th>{lang('send')} / {lang('received')}</th>
        </tr>
      </thead>
      {assign var="i" value=0}
        {foreach from=$transfer_details item=v}
            {$i = $i+1}
            <tr>
                <td> {$i}</td>
                <td>{$v.user_full_name}</td>
                <td>{$v.epin}</td>
                <td>{$v.transfer_date}</td>
                <td>{$v.type}</td>
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
{/block}