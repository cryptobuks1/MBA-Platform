{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" class="no-display">
    <span id="error_msg">{lang('select_user_id')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="username_msg">{lang('you_must_enter_username')}</span>
</div>

<input type="hidden" id="filter_submit_url" value="{$BASE_URL}admin/income_details/income">
<div id="page_path" style="display:none;">{$PATH_TO_ROOT_DOMAIN}admin/</div>

{include file="layout/search_member.tpl"}

{if isset($user_name) && $is_valid_username}
    {if $overview_disp}
        <div id="user_account"></div>
    {/if}
    <div id="username_val" style="display:none;">{$user_name}</div>

    <legend>
        <span class="fieldset-legend">{lang('income_details')}: {$user_name}</span>
    </legend>

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/income', 'role="form" class="" method="post" name="feedback_form"
        id="feedback_form"')}
                <input type="hidden" value='{$from_page}' name="from_page" id="from_page">
                <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <select name="amount_type" id="amount_type" class="form-control">
                        <option value="all">{lang('all')} </option>
                        {foreach from=$all_amount_type item=v}
                            <option value="{$v.db_amount_type}" {if $amount_type==$v.db_amount_type} selected {/if}>{lang($v.db_amount_type)}</option>
                        {/foreach} 
                    </select>
                    </div>
                </div> 
                <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary btn_height" type="submit" id="search_amountype_submit" value="search_amountype_submit" name="search_amountype_submit">{lang('search')}</button>
                </div>
                </div>
            {form_close()}
        </div>
    </div>
    <div class="panel panel-default table-responsive">
 
    <div class="panel-body">
        
        <div class = "panel-tools-filter pull-left" style="text-align: right;margin: 5px;">
         {$date_text = lang('overall')}
         {if $date == 'month'}
            {$date_text = lang('this_month')}
        {elseif $date == 'year'}
            {$date_text = lang('this_year')}
        {/if}
         <div class="btn-group dropdown filter_date" style = "display: inline-block;vertical-align: middle;">
            <button class="btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-calendar"></i>
                <b>{$date_text} ({lang('date')})</b>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li class="{if !$date}active{/if}">
                    <a class="" data-value="">
                        <span class="">{lang('overall')}</span>
                    </a>
                </li>
                <li class="{if $date == 'month'}active{/if}">
                    <a class="" data-value="month">
                        <span class="">{lang('this_month')}</span>
                    </a>
                </li>
                <li class="{if $date == 'year'}active{/if}">
                    <a class="" data-value="year">
                        <span class="">{lang('this_year')}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="btn-group dropdown filter_clear">
            <button class="btn btn-sm btn-default" aria-expanded="false">
                <i class="fa fa-circle-o-notch"></i>
                <b>{lang('clear')}</b>
            </button>
        </div>
            
     </div>   
        
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('from')}</th>
                    <th>{lang('level')}</th>
                    <th>{lang('amount_type')}</th>
                    <th>{lang('amount')}</th>
                </tr>
            </thead>
            {if count($amount)>0}
            <div class="button_back pull-righ">
                <a href="{$BASE_URL}admin/excel/create_excel_earnings_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i>{lang('create_excel')}</button></a>
                <a href="{$BASE_URL}admin/excel/create_csv_earnings_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i>{lang('create_csv')}</button></a>
            </div>
                <tbody>
                    {assign var=i value="0"}
                    {assign var=total_amount value=0}
                    {foreach from=$amount item=v}
                        {$total_amount = $total_amount + $v.amount_payable}
                        {$i = $i+1}
                        <tr>
                            <td>{$i+$page_id}</td>
                            <td>
                                {if $v.from_user && in_array($v.amount_type, $from_user_amount_types)}
                                {$v.from_user}
                                {else}
                                NA
                                {/if}
                            </td>
                            <td>
                                {if in_array($v.amount_type, $level_based_amount_type)}
                                {$v.user_level}
                                {else}
                                NA
                                {/if}
                            </td>
                            <td>
                                {if $v.amount_type == 'board_commission' && $MODULE_STATUS['table_status'] == 'yes'}
                                {lang('table_commission')}
                                {else}
                                {lang($v.amount_type)}
                                {/if}
                            </td>
                            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                        </tr>
                    {/foreach}
                    <tr>
                        <td colspan="4" class="text-right"><b>{lang('amount_total')}</b></td>
                        
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</b></td>
                    </tr>
                </tbody>
            {else}
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4>{lang('no_income_details_were_found')}</h4>
                        </td>
                    </tr>
                </tbody>
            {/if}
        </table>
        </div>
    </div>
    {$result_per_page}
{/if}


{/block}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/income_details_filter.js" type="text/javascript" ></script>
{/block}