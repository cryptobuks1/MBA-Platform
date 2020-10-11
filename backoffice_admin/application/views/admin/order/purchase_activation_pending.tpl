{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('order_activation')}<b>{if $user_name!="admin"} {$user_name}{/if}</b>
            </div>
            <div class="panel-body">

                <table class="table table-striped table-hover table-full-width table-bordered" id="sample_1">
                    <thead>
                        <tr class="th">
                            <th><b>{lang('sl_no')}</b></th>
                            <th><b>{lang('user_name')}</b></th> 
                            <th><b>{lang('fullname')}</b></th> 
                            <th><b>{lang('product')}</b></th> 
                             <th><b>{lang('total_price')}</b></th> 
                            <th><b>{lang('date')}</b></th>
                            <th>{lang('activate')}</th>
                        </tr>
                    </thead>
                    {if $count>0}
                    {$tabindexvalue = 3}
                    <tbody>
                        {assign var="root" value="{$BASE_URL}admin/"} 
                        {$i = 1}
                        {foreach from=$reg_details item=v}
                        <tr>
                            <td>{$i + $page}</td>                                  
                            <td><b>{$v.user_name}</b></td> 
                            <td>{$v.full_name}</td>
                            <td>{foreach from=$v.products item=k}
                                {$k.name}
                            {/foreach}
                        </td>
                        <td>
                            {foreach from=$v.total_price item=k}
                                {$DEFAULT_SYMBOL_LEFT}{round($k*$DEFAULT_CURRENCY_VALUE)}{$DEFAULT_SYMBOL_RIGHT}
                            {/foreach}
                        </td>
                            <td>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                            <td>
                           
                            {form_open('admin/order/purchase_activation', 'role="form" class="smart-wizard form-horizontal" method="post"  name="form" id="form"')} 
                                    <button tabindex="{$tabindexvalue++}" type="submit" name="order_id" id="order_id" class="btn btn-info top-btn" value="{$v.order_id}">{lang('activate')}</button>
                                {form_close()}
                           
                            </td>                                
                        </tr>
                        {$i = $i + 1}
                        {/foreach}
                    </tbody>

                </table> {$result_per_page}
                {else}
                <tbody>
                    <tr><td colspan="13" align="center" ><h4 align="center">{lang('no_data')}</h4></td></tr>
                </tbody>
            </table> 
            {/if}
        </div>
    </div>
</div>
</div>
{/block}
