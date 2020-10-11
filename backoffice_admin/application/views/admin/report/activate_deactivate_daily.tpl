{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK} {assign var="report_name" value="{lang('activate_deactivate_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_activate_deactivate_report_view_daily"} {assign var="csv_url" value=""}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('status')}</th>
            <th>{lang('activate_deactivate_date')}</th>
        </tr>
        {assign var="i" value=0}
        {foreach from=$todays_active_deactive item=v}
            {$i=$i+1}
            <tr class>
                <td>{$i}</td>
                <td>{$v.user_name}</td>
                <td>{$v.full_name}</td>
                <td>{$v.status}</td>
                <td>{$v.date}</td>
            </tr>
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