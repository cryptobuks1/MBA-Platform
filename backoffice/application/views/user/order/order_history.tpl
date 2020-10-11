{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th">
                    <th>{lang('order_id')}</th>
                    <th>{lang('user_name')}</th>
                    <th>{lang('customer')}</th>
                    <th>{lang('product')}</th>
                        {if $MLM_PLAN == 'Binary'}
                        <th>{lang('total_pair_value')}</th>
                        {else}
                        <th>{lang('total_bv')}</th>
                        {/if}
                    <th>{lang('total_price')}</th>
                    <th>{lang('shipping_method')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            {if $count>0} 
                <tbody>
                    {assign var="root" value="{$BASE_URL}user/"}
                    {foreach from=$order_details item=v}
                        <tr>
                            <td>{$v.order_id_with_prefix}</td>  
                            <td>{$v.user_name}</td>
                            <td>{$v.customer_name}</td>  
                            <td>{$v.model}</td>
                            <td>{$v.total_pair_value}</td>
                            <td>
                                {foreach from=$v.total_price item=k}
                                    {$DEFAULT_SYMBOL_LEFT}{round($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                                {/foreach}
                            </td>
                            <td>{$v.shipping_method}</td>
                            <td>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                            <td style="text-align: center;">
                                <a href="{$BASE_URL}user/order_details/{$v.order_id}" target="_blank"  >
                                    <button type="button" name="order_id" id="order_id" title="{lang('view_more')}" class="btn-link text-primary h4 new_btn" value="{$v.order_id}"><span class="fa fa-eye"></span></button>
                                </a>
                            </td>                                
                        </tr>
                    {/foreach}
                </tbody>
            {else}
                <tbody>
                    <tr><td colspan="13" align="center"><h4 align="center">{lang('invalid_order')}.</h4></td></tr>
                </tbody>
            {/if}
        </table>
    </div>
    {$result_per_page}
{/block}