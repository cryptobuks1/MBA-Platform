{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
{assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_stripe_monhtly_recurring_report/{$user_name}"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_stripe_monhtly_recurring_report/{$user_name}"}
{assign var="report_name" value="{lang('stripe_monhtly_recurring_report')}"}{$total=0}{$tot_pay=0}{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default  ng-scope">
  <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if $count >= 1}
      <tbody>
      <thead>
        <tr>
          <th>{lang('sl_no')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('email')}</th>
             <th>{lang('text')}</th>
            <th>{lang('date')}</th>
        </tr>
        </thead>
        {assign var="i" value=1}
        {foreach from=$details item=v}
            <tr>
                <td>{$i}</td>
                <td>{$v.user_name}</td>
                <td>{$v.full_name}</td>
                <td>{$v.email}</td>
                <td>{$v.text}</td>
                <td>{date('Y/m/d', strtotime($v.date))}</td>
            </tr>

            {$i=$i+1}
        {/foreach}
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
