{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
{include file="layout/search_member.tpl"}
<div class="panel panel-default table-responsive">
    <div class="panel-body">
        <legend>
            <span class="fieldset-legend">{lang('business_wallet')}{if $user_name}
                : {$user_name}
            {/if}</span>
        </legend>
        <div class="section-dropdown-filter">
            <select class="dropdown_filter" name="date" data-title="{lang('date')}" data-value=""
                data-icon="fa fa-calendar">
                <option value="" target-id="overall">{lang('overall')}</option>
                <option value="month" target-id="this_month">{lang('this_month')}</option>
                <option value="year" target-id="this_year">{lang('this_year')}</option>
            </select>
        </div>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
{/block}

{block name=script}
{$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/dropdown_filter.js" type="text/javascript"></script>
<script>
    $(function () {
        ValidateSearchMember.init();
        $('.dropdown_filter').dropdownFilter({
            remote: false,
            clear: false
        });
    });
</script>
{/block}