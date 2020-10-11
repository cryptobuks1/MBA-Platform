{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_rank_achievers_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_rank_achievers_report"}
{assign var="report_name" value="{lang('rank_achieve_report')}"}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default  ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
            <th>{lang('slno')}</th>
            <th>{lang('new_rank')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('rank_achieved_date')}</th>
        </tr>
      </thead>
      {assign var="i" value=0}
        {foreach from=$report_arr item=v}
        {$i=$i+1}
      <tr>
            <td>{$i}</td>
            <td>{$v.rank_name}</td>
            <td>{$v.user_name}</td>
            <td>{$v.user_detail_name}</td>
            <td>{$v.date}</td>
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