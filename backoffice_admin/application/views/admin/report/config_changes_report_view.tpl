{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="report_name" value="{lang('settings_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_config_changes_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_config_changes_report"}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
        <th>{lang('sl_no')}</th>
        <th>{lang('updated_by')}</th>
        <th>{lang('activity')}</th>
        <th>{lang('description')}</th>
        <th>{lang('date')}</th>
        <th>{lang('ip_address')}</th>
        </tr>
      </thead>
      {assign var="i" value=0}
        {foreach from=$config_details item=v}
            {$i = $i+1}
            <tr>
                <td> {$i}</td>
                <td>{$v.user_name} </td>
                <td>{$v.activity}</td>
                <td>{$v.desc}</td>
                <td>{$v.date}</td>
                <td>{$v.ip}</td>
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