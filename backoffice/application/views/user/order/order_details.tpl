{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="button_back">
                <a onClick="print_report();
            return false;"><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="icon-printer"></i>{lang('Print')}</button>
                </a></div>
            <div class="panel panel-default table-responsive"  id="print_area">
                <table border="0" width="700" height="100" align="center">
                    <tbody>
                        {foreach from=$order_details item=v}
                            <tr>
                                <td colspan="2"><h3><b>{lang('order_id')}:<font color="#7266ba ">#{$v.order_id_with_prefix} </font></b></h3></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>{lang('date_added')}: </b>{$v.date_added|date_format:'%m-%d-%Y'}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>{lang('shipping_method')}: </b>{$v.shipping_method}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td><h2>{lang('payment_address')}</h2>
                                    <b>{$v.payment_firstname} {$v.payment_lastname}</b><br>
                                    {$v.payment_address_1}<br>
                                    {$v.payment_city}, {$v.payment_zone}<br>
                                    {$v.payment_country}</td>
                                    {if $v.shipping_method !=''}
                                    <td><h2>{lang('shipping_address')}</h2>
                                        <b>{$v.shipping_firstname} {$v.shipping_lastname}</b><br>
                                        {$v.shipping_address_1}<br>
                                        {$v.shipping_city}, {$v.shipping_zone}<br>
                                        {$v.shipping_country} </td>
                                    {/if}
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td colspan="2"><h2><b>{lang('order_products')}</b></h2>
                                    <table class="table table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <td><b>{lang('product')}</b></td>
                                                <td><b>{lang('quantity')}</b></td>
                                                {if $MLM_PLAN == 'Binary'}
                                                    <td><b>{lang('pair_value')}</b></td>
                                                {else}
                                                    <td><b>{lang('bv')}</b></td>
                                                {/if}
                                                <td><b>{lang('price')}</b></td>
                                                {if $MLM_PLAN == 'Binary'}
                                                    <td><b>{lang('total_pair_value')}</b></td>
                                                {else}
                                                    <td><b>{lang('total_bv')}</b></td>
                                                {/if}
                                                <td><b>{lang('total')}</b></td>    
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {assign var="root" value="{$BASE_URL}admin/"}
                                            {foreach from=$v.products item=k}
                                                <tr>
                                                <tr>                                      
                                                    <td>{$k.name}</td>                           
                                                    <td>{$k.quantity}</td>
                                                    <td>{$k.pair_value}</td>
                                                    <td>{$DEFAULT_SYMBOL_LEFT}{round($k.price*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                    <td>{$k.pair_value*$k.quantity}</td>
                                                    <td>{$DEFAULT_SYMBOL_LEFT}{round($k.total*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                                <tr> 
                                                    <td colspan="6"><hr></td>
                                                </tr>
                                            <hr>
                                        {/foreach}   
                                        </tbody>
                                    </table></td>
                            </tr>
                            <tr>
                                <td colspan="2"><table border="0" width="30%" height="100" align="right" class="tbl_bot ">
                                        <tbody>
                                            {foreach from=$v.order_total item=m}
                                                <tr>
                                                    <td width="60%"><h5>{$m.title}</h5></td>
                                                    <td>{$DEFAULT_SYMBOL_LEFT}{round($m.value*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                                </tr>
                                            {/foreach}
                                        </tbody>
                                    </table></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{/block}