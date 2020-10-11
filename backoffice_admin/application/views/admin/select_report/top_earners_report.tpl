{extends file=$BASE_TEMPLATE} {block name=script} {$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/misc.js" type="text/javascript"></script>
{/block}{block name=$CONTENT_BLOCK} {if count($top_earners) > 0 }
<div class="button_back">
    <a href="{$BASE_URL}admin/excel/create_excel_top_earners_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>
    <a href="{$BASE_URL}admin/excel/create_csv_top_earners_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>
</div>
<div class="panel panel-default table-responsive">
<div class="panel-body">

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('full_name')}</th>
                <th>{lang('username')}</th>
                <th>{lang('current_balance')}</th>
                <th>{lang('total_earnings')}</th>
                <th>{lang('action')}</th>
            </tr>
        </thead>
        <tbody>
            {assign var="root" value="{$BASE_URL}admin/"} {assign var="i" value=0} {foreach from=$top_earners item=v} {$i=$i+1}
            <tr>
                <td>{$i + $page_id}</td>
                <td>{$v.name}</td>
                <td>{$v.user_name}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.current_balance*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_earnings*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>
                    <a href="#" onclick="javascript:view_earnings('{$v.user_name}', 'top_earners','{$root}')">
                        <div class="field1">
                            <button class="btn-link h4 has-tooltip text-info"><i class="fa fa-info"></i></button>
                            <span class="tooltip green">
            <p>{lang('details')}</p>
            </span> </div>
                    </a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
    </div>
   
</div>
{else}
<div class="panel-body">
    <br/>
    <p align="center">{lang('no_top_earners')}</p>
</div>
 {$result_per_page}
{/if} {/block}