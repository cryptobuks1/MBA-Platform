{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
            <div class="button_back">
                <a href="{$BASE_URL}admin/excel/create_excel_summary_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>
                <a href="{$BASE_URL}admin/excel/create_csv_summary_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>
                  </div>
<div class="panel panel-default">
        <div class="panel-body">
            {form_open('','role="form" class="" method="post" name="commision_form" id="commision_form"')}
          
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label  for="week_date1">{lang('from_date')}</label>
                    <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">{* {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}*}
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('to_date')}</label>
                    <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {*{if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}*}
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button class="btn btn-primary" name="submit" type="submit" value="{lang('submit')}">
                        {lang('submit')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
    <div id="print_area" class="img panel-body panel">
<div class="panel panel-default table-responsive">
    <div class="panel-body">
        <!--{*<div class="section-dropdown-filter">
            <select class="dropdown_filter" name="date" data-title="{lang('date')}" data-value=""
                data-icon="fa fa-calendar">
                <option value="" target-id="overall">{lang('overall')}</option>
                <option value="month" target-id="this_month">{lang('this_month')}</option>
                <option value="year" target-id="this_year">{lang('this_year')}</option>
            </select>
        </div>*}-->
        <div id="overall" class="table-responsive hide show">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('transaction_category')}</th>
                        <th>{lang('credited_amount')}</th>
                        <th>{lang('debited_amount')}</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var=credited_sum value="0"}
                    {assign var=debited_sum value="0"}
                    {foreach from=$details item=v key=amount_type}
                    {if $v.type == 'credit'}
                    {$credited_sum = $credited_sum + $v.amount}
                    {elseif $v.type == 'debit'}
                    {$debited_sum = $debited_sum + $v.amount}
                    {/if}
                    <tr>
                        {if $amount_type == 'board_commission' && $MLM_PLAN == 'Board' && $MODULE_STATUS['table_status']
                        == 'yes'}
                        <td>{lang("bw_table_commission")}</td>

                        {else}
                        <td>{lang("bw_`$amount_type`")}</td>
                        {/if}
                        {if $v.type == 'credit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                        {if $v.type == 'debit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                    </tr>
                    {/foreach}
                    <tr>
                        <td><b>{lang('total')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($credited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($debited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>{lang('profit')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format(($credited_sum - $debited_sum)*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="this_month" class="table-responsive hide">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('transaction_category')}</th>
                        <th>{lang('credited_amount')}</th>
                        <th>{lang('debited_amount')}</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var=credited_sum value="0"}
                    {assign var=debited_sum value="0"}
                    {foreach from=$month_details item=v key=amount_type}
                    {if $v.type == 'credit'}
                    {$credited_sum = $credited_sum + $v.amount}
                    {elseif $v.type == 'debit'}
                    {$debited_sum = $debited_sum + $v.amount}
                    {/if}
                    <tr>
                        {if $amount_type == 'board_commission' && $MLM_PLAN == 'Board' && $MODULE_STATUS['table_status']
                        == 'yes'}
                        <td>{lang("bw_table_commission")}</td>

                        {else}
                        <td>{lang("bw_`$amount_type`")}</td>
                        {/if}
                        {if $v.type == 'credit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                        {if $v.type == 'debit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                    </tr>
                    {/foreach}
                    <tr>
                        <td><b>{lang('total')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($credited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($debited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>{lang('profit')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format(($credited_sum - $debited_sum)*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="this_year" class="table-responsive hide">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{lang('transaction_category')}</th>
                        <th>{lang('credited_amount')}</th>
                        <th>{lang('debited_amount')}</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var=credited_sum value="0"}
                    {assign var=debited_sum value="0"}
                    {foreach from=$year_details item=v key=amount_type}
                    {if $v.type == 'credit'}
                    {$credited_sum = $credited_sum + $v.amount}
                    {elseif $v.type == 'debit'}
                    {$debited_sum = $debited_sum + $v.amount}
                    {/if}
                    <tr>
                        {if $amount_type == 'board_commission' && $MLM_PLAN == 'Board' && $MODULE_STATUS['table_status']
                        == 'yes'}
                        <td>{lang("bw_table_commission")}</td>

                        {else}
                        <td>{lang("bw_`$amount_type`")}</td>
                        {/if}
                        {if $v.type == 'credit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                        {if $v.type == 'debit'}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                        </td>
                        {else}
                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format(0,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        {/if}
                    </tr>
                    {/foreach}
                    <tr>
                        <td><b>{lang('total')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($credited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($debited_sum*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><b>{lang('profit')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format(($credited_sum - $debited_sum)*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
{/block}

{block name=script}
{$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/dropdown_filter.js" type="text/javascript"></script>
<script>
    $(function () {
        $('.dropdown_filter').dropdownFilter({
            remote: false,
            clear: false
        });
    });
</script>
{/block}