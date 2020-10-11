{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}{assign var="report_name" value="{lang('user_joining_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_joining_report_daily"} {assign var="csv_url"
value="{$BASE_URL}admin/excel/create_csv_joining_report_daily"} {include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default ng-scope">{if $count >= 1}
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <tbody>
      <thead>
        <tr class="th">
          <th>{lang('sl_no')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('upline_name')}</th>
            <th>{lang('sponser_name')}</th>
            <th>{lang('join_type')}</th>
            <th>{lang('status')}</th>
            <th>{lang('date_of_joining')}</th>
        </tr>
        </thead>
        {assign var="i" value=0}
        {foreach from=$todays_join item=v}
        {if $v.active=="yes"}
            {assign var="stat" value="ACTIVE"}
        {else}
            {assign var="stat" value="BLOCKED"}
        {/if}
        {$i=$i+1}
        <tr>
            <td>{$i}</td>
            <td>{$v.user_name}</td>
            <td>{$v.user_full_name}</td>
            <td>{if $v.father_user}{$v.father_user}{else}NA{/if}</td>
            <td>{if $v.sponsor_name}{$v.sponsor_name}{else}NA{/if}</td>
            <td>
                {if $v.join_type=='customer'}
                    {lang('customer')}
                 {elseif $v.join_type=='affiliate'}
                    {lang('affiliate')}
                {else}
                    NA
                {/if}</td>
            <td>{$stat}</td>
            <td>{date('Y/m/d', strtotime($v.date_of_joining))}</td>
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