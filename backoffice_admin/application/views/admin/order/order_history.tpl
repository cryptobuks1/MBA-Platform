{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    {*{include file="layout/search_member.tpl"}*}
     <div class="panel panel-default">
    <div class="panel-body">
        {form_open({$SHORT_URL},'role="form" class="" name="search_member" id="search_member"
        action="" method="post"')}
        <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
        <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
         {include file="layout/error_box.tpl"} 

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="user_name">{lang('user_name')}</label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="" for="week_date1">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value="">{* {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}*}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="">{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {*{if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}*}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                    name="search_member_submit">
                    {lang('search')}
                </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>{lang('sl_no')}</b></th>
                    <th><b>{lang('order_id')}</b></th>
                    <th><b>{lang('user_name')}</b></th>
                    <th><b>{lang('customer')}</b></th>
                    <th><b>{lang('product')}</b></th>
                            {if $MLM_PLAN == 'Binary'}
                        <th><b>{lang('pair_value')}</b></th>
                            {else}
                        <th><b>{lang('bv')}</b></th>
                            {/if}
                            {if $MLM_PLAN == 'Binary'}
                        <th><b>{lang('total_pair_value')}</b></th>
                            {else}
                        <th><b>{lang('total_bv')}</b></th>
                            {/if}
                    <th><b>{lang('total_price')}</b></th>
                    <th><b>{lang('shipping_method')}</b></th>
                    <th><b>{lang('date')}</b></th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            {if $count>0}
                {$tabindexvalue = 3}
                {assign var="root" value="{$BASE_URL}admin/"}
                <tbody>
                    {$i = 1}
                     {assign var=pv_sum value="0"}
                    {assign var=price_sum value="0"}
                    {foreach from=$order_details item=v}
                     {$pv_sum = $pv_sum + $v.total_pair_value}
                    
                        <tr>
                            <td>{$i + $page_id}</td>
                            <td>{$v.order_id_with_prefix}</td>                                  
                            <td>{$v.user_name}</td> 
                            <td>{$v.customer_name}</td>                                 
                            <td>{foreach from=$v.products item=k}
                                {$k.name}
                            {/foreach}
                        </td>
                        <td>{$v.pair_value}</td>
                        <td>{$v.total_pair_value}</td>
                        <td>
                            {foreach from=$v.total_price item=k}{$price_sum = $price_sum + $k}
                                {$DEFAULT_SYMBOL_LEFT}{round($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                            {/foreach}
                        </td>
                        <td>{$v.shipping_method}</td>
                        <td>{$v.date_added|date_format:'%d-%m-%Y'}</td>
                        <td style="text-align: center;">
                            <a href="{$BASE_URL}admin/order_details/{$v.order_id}" target="_blank" >
                                <button tabindex="{$tabindexvalue++}" type="button" name="order_id" id="order_id" title="{lang('view')}" value="{$v.order_id}" class="btn-link text-primary h4"><span class="fa fa-eye"></span></button>
                            </a>
                        </td>
                    </tr>
                    {$i = $i + 1}
                    {/foreach}
                     <tr>
                        <td colspan="6"><b>{lang('total_pv')}</b></td>
                        <td colspan="1"><b>{$pv_sum}</b>
                        </td>
                         <td><b>{lang('total_price')}</b></td>
                        <td><b>{$DEFAULT_SYMBOL_LEFT}{round($price_sum*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}</b>
                        </td>
                    </tr>
                    </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_data')}</h4></td></tr>
                        </tbody>
                    {/if}
            </table>
        </div>
    {$result_per_page}                   
{/block}