{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>{lang('sl_no')}</b></th>
                    <th><b>{lang('user_name')}</b></th> 
                    <th><b>{lang('fullname')}</b></th> 
                    <th><b>{lang('email')}</b></th> 
                    <th><b>{lang('product')}</b></th> 
                    <th><b>{lang('reg_amount')}</b></th>  
                    <th><b>{lang('address')}</b></th>
                    <th><b>{lang('date')}</b></th>
                    <th>{lang('action')}</th>
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
                            <td><b>{$v.user_name_entry}</b></td> 
                            <td>{$v.first_name} {$v.last_name}</td>                                 
                            <td>{$v.email}</td>
                            <td>{$v.product_name}</td>
                            <td> 
                                {$DEFAULT_SYMBOL_LEFT}{round($v.reg_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT} 
                            </td>    
                            {if $v.address_1 !="NA"}                                    
                                <td>{$v.address_1}</td>
                            {else}
                                <td>NA</td>
                            {/if}
                            <td>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                            <td>

                                {form_open('admin/order_activation', 'role="form" class="" method="post"  name="form" id="form"')} 
                                <button tabindex="{$tabindexvalue++}" type="submit" name="order_id" id="order_id" class="btn m-b-xs w-xs btn-primary" value="{$v.row_id}" onclick="$(this).button('loading');">{lang('activate')}</button>
                                {form_close()}
                            </td>                                
                        </tr>
                        {$i = $i + 1}
                    {/foreach}
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