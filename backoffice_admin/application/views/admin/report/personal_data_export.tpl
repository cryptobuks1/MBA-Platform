{extends file=$BASE_TEMPLATE}{block name="script"}{$smarty.block.parent}
<script>
    $(function() {
        if ({$page_id} != 0) {
            $(document).scrollTop($('#activity').offset().top);
        }
    });
</script>{/block} {block name=$CONTENT_BLOCK} {assign var="excel_url" value="{$BASE_URL}admin/excel/exelPersonalDtaExport"} {assign var="csv_url" value="{$BASE_URL}admin/excel/personalDtaExport"} {assign var="report_name" value="{lang('personal_data_report')}"}{include
file="admin/report/report_nav.tpl" name=""}
<div class="panel">
    <div id="print_area" class="img panel-body">
        {include file="admin/report/header.tpl" name=""}
        <div class="panel panel-default">
            <div class="panel-body">
                <legend><span class="fieldset-legend">{lang('about')}</span></legend>
                <div class="table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <tbody>
                            {foreach from=$details['about'] key=k item=v}
                            <tr class="text">
                                <td class="col-md-2"><strong>{lang({$k})}</strong></td>
                                <td>{$v}</td>
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                {if count($details['commission']) > 0 }
                <legend><span class="fieldset-legend">{lang('commission_details')}</span></legend>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width table-bordered" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th>{lang('sl_no')}</th>
                                <th>{lang('amount_type')}</th>
                                <th>{lang('total_amount')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value=1} {$total=0} {foreach from=$details['commission'] item=v}
                            <tr>
                                <td>{$i}</td>
                                <td>
                                    {if $v.view_amt == "Board Commission"} {if {$MODULE_STATUS['table_status']} eq 'yes' && {$MODULE_STATUS['mlm_plan']} eq 'Board'} {lang('table_commission')} {else} {$v.view_amt} {/if} {elseif $v.amount_type == 'daily_investment'} {lang('daily_investment')}
                                    {elseif $v.amount_type == 'purchase_donation'} {lang('purchase_donation')} {else} {$v.view_amt} {/if}
                                </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}{$total=$total+$v.total_amount}</td>
                            </tr>
                            {$i=$i+1} {/foreach}
                            <tr>
                                <td colspan="2" class="font-size-td" align="right"><b>{lang('total')}</b></td>
                                <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {/if}
                <legend><span class="fieldset-legend" id="activity">{lang('activities')}</span></legend>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width table-bordered" id="sample_1">
                        <thead>
                            <tr class="th">
                                <th>{lang('sl_no')}</th>
                                <th>{lang('date')}</th>
                                <th>{lang('ip_address')}</th>
                                <th>{lang('activity')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="root" value="{$BASE_URL}admin/"} {$i = 0} {foreach from=$details["activity"] item=v}
                            <tr>
                                <td>{$i + $page_id + 1}</td>
                                <td>{$v.date}</td>
                                <td>{$v.ip}</td>
                                {if lang($v.activity)}
                                <td>{lang($v.activity)}</td>
                                {else}
                                <td>{$v.activity}</td>
                                {/if}
                            </tr>
                            {$i = $i + 1} {/foreach}
                        </tbody>
                    </table>
                    {$result_per_page}
                </div>
            </div>
        </div>
    </div>
</div>
{/block}