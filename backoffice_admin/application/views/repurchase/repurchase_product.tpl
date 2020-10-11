{extends file=$BASE_TEMPLATE} {block name=script} {$smarty.block.parent}
<script type="text/javascript" src="{$PUBLIC_URL}javascript/ui-elements.js"></script>
<script type="text/javascript" src="{$PUBLIC_URL}javascript/repurchase_product.js"></script>
{/block} {block name=$CONTENT_BLOCK} {if $cart_count>0}
<div class="panel panel-default  ng-scope">
<div class="panel-body">
<div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('sl_no')}</th>
                <th>{lang('product_name')}</th>
                <th>{lang('product_price')}</th>
                <th>{lang('Quantity')}</th>
                <th>{lang('Sub_Total')}</th>
            </tr>
        </thead>
        <tbody>
            {assign var="tot_tot_amount" value="0"} {assign var="tot_tot_cv" value="0"} {assign var="i" value="1"} {foreach from=$cart_content item=v}
            <tr>
                <td>{counter}</td>
                <td>{$v.name}</td>
                <td>{$DEFAULT_SYMBOL_LEFT} {number_format($v.price * $DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$v.qty}</td>
                <td>{$DEFAULT_SYMBOL_LEFT} {number_format($v.subtotal * $DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>

            </tr>
            {/foreach}
            <tr>
                <td class="text-right" colspan="4"><b>{lang('Total')}</b></td>
                <td><b>{$DEFAULT_SYMBOL_LEFT} {number_format($cart_total_amount * $DEFAULT_CURRENCY_VALUE,$PRECISION)}
            {$DEFAULT_SYMBOL_RIGHT}</b></td>
            </tr>
        </tbody>
    </table>
    </div>
  
    <a href="{$BASE_URL}checkout_product"><button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-shopping-cart"></i>{lang('checkout')}</button></a>
 
</div>
</div>

{/if} {if count($repurchase_detail)>0}
<input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}" /> {assign var=i value=0} {assign var=active value=""} {assign var=key_count value=1}
<div class="row">
    {foreach from=$repurchase_detail item=v} {assign var=j value=1}
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="clearfix text-center">
                    <div class="inline"> {if $v.prod_img != ''}
                        <img src="{$SITE_URL}/uploads/images/product_img/{$v.prod_img}" alt="a"  /> {else}
                        <img src="{$SITE_URL}/uploads/images/product_img/cart.jpg" alt="a"  /> {/if}
                    </div>
                    <div class="h4 m-t m-b-xs">{$v.product_name}</div>
                    <div class=""><span class="label bg-light m-l-sm ">{$v.category_name}</span></div>
                    <small class="text-muted m-b">{$DEFAULT_SYMBOL_LEFT}
                    {number_format($v.product_value * $DEFAULT_CURRENCY_VALUE,$PRECISION)}
                    {$DEFAULT_SYMBOL_RIGHT}</small> </div>
            </div>
            <footer class="panel-footer text-center no-padder">
                <div class="row no-gutter">
                    <div class="col-xs-6 dk">
                        <div class="wrapper b-r "> <a href="javascript:add_cart({$v.product_id},{$i})" class="btn btn-info btn-addon" id="add_to_cart_{$i}"><i class="fa fa-shopping-cart"></i>{lang('add_to_cart')}</a> </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="wrapper"> <a href="product_details/{$v.prod_enc_id}" class="btn btn-success btn-addon"><i class="fa fa-eye"></i>{lang('more_details')}</a> </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    {$i=$i+1} {/foreach}
</div>
{else}
        <h4 align="center">{lang('no_product_available')}</h4>
{/if} {/block}
