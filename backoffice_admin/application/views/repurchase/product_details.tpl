{extends file=$BASE_TEMPLATE}{block name="script"}{$smarty.block.parent}
<script src="{$PUBLIC_URL}javascript/repurchase_product_detail.js"></script>
{/block} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('Quantity_Is_required')}</span>
    <span id="error_msg2">{lang('Quantity_bust_be_atleast_one')}</span>
    <span id="error_msg3">{lang('quantity_must_number')}</span>
    <span id="error_msg4">{lang('digits_only')}</span>
    <span id="confirm_msg_update">{lang('sure_you_want_to_update_this_item')}</span>
</div>
<div class="panel wrapper">
    <legend><span class="fieldset-legend">{$products['product_name']}</span></legend>
    {form_open("{$ACTION_URL}", 'role="form" class="" method="post" name="request" id="request"')}
    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
    <input type="hidden" value="{$PATH_TO_ROOT}" id="path_root"> {include file="layout/error_box.tpl"}
    <div class="row">
        <input type="hidden" name="product_name" id="product_name" value="{$products['product_name']}" />
        <div class="col-md-3 b-r b-light no-border-xs"> {if $products['prod_img'] != '' && $products['prod_img']!="no"}
            <img src="{$SITE_URL}/uploads/images/product_img/{$products['prod_img']}" alt="a" /> {else}
            <img src="{$SITE_URL}/uploads/images/product_img/cart.jpg" /> {/if}
            <input type="hidden" name="prod_img" id="prod_img" value="{$products['prod_img']}" />
        </div>
        <div class="col-md-9">
        
            <div class="m-b">
       <span>  {lang('product_id')} : </span>
        <div class="label text-base bg-info  pos-rlt m-r">{$products['prod_id']}
                    <input type="hidden" name="product_id" id="product_id" value="{$products['product_id']}" />
                </div>
        <span>  {lang('product_price')} :</span>
         <div class="label text-base bg-info  pos-rlt m-r">{$DEFAULT_SYMBOL_LEFT} {number_format({$products['product_value']*$DEFAULT_CURRENCY_VALUE},$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                    <input type="hidden" name="product_price" id="product_price" value="{$products['product_value']}" />
                </div>
        <span> {lang('pv')} :  </span> 
        <div class="label text-base bg-info  pos-rlt m-r">{$products['pair_value']}
                    <input type="hidden" name="pv" id="pv" value="{$products['pair_value']}" />
                </div>
        <span> {lang('category')} :  </span> 
        <div class="label text-base bg-info  pos-rlt m-r">{$products['category_name']}
                    <input type="hidden" name="category_id" id="category_id" value="{$products['category_id']}" />
                </div>
                </div>
        
           <!--- <div class="m-b">
            <div class="col-sm-3 padding_both">
             <div class="form-group">
                <span> {lang('product_id')} : </span>
                <div class="label text-base bg-info  pos-rlt m-r">{$products['prod_id']}
                    <input type="hidden" name="product_id" id="product_id" value="{$products['product_id']}" />
                </div>
                </div>
                </div>
                <div class="col-sm-4">
                 <div class="form-group">
                <span> {lang('product_price')} : </span>
                <div class="label text-base bg-info  pos-rlt m-r">{$DEFAULT_SYMBOL_LEFT} {number_format({$products['product_value']*$DEFAULT_CURRENCY_VALUE},$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                    <input type="hidden" name="product_price" id="product_price" value="{$products['product_value']}" />
                </div>
                </div>
                </div>
                <div class="col-sm-5">
                 <div class="form-group">
                <span>{lang('pv')} : </span>
                <div class="label text-base bg-info  pos-rlt m-r">{$products['pair_value']}
                    <input type="hidden" name="pv" id="pv" value="{$products['pair_value']}" />
                </div>
                </div>
                </div>
            </div>-->
             <div class="form-group">
                <label>{lang('Quantity')} </label>
                <input class="form-control" name="product_qty" id="product_qty" size="30" min="1" value="{$cart_details['quantity']}" onchange="getTotalAmount()" type="number" />
                <span id="errmsg1" style="display: none;"></span>
            </div>
                {if $MODULE_STATUS['multy_currency_status']=="no"} 
             <div class="form-group">
                 
                    <label>{lang('Total')}</label>
                    <input type="text" class="form-control" name="tot_price_converted" id="tot_price_converted" disabled size="30" />
            </div>
                {else}
            <div class="form-group">
                <label>{lang('Total')}</label>
                <div class="input-group"> {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                    <input type="text" class="form-control" name="tot_price_converted" id="tot_price_converted" readonly="true" size="30" /> {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
                </div>
            </div>
                {/if}
            <div class="form-group">
                <input type="hidden" name="tot_price" id="tot_price">
                <label>{lang('Total')} {lang('pv')}</label>
                <input type="text" class="form-control" name="tot_pv" id="tot_pv" readonly="true" size="30" />
            </div>

            <div class="form-group">
                <label>{lang("description")}</label>
                <textarea name="description" id="description" tabindex="7"  class="form-control" autocomplete="Off" rows="4" cols="50" readonly="true">{$products['description']}</textarea>
            </div>    
                
            <div class="form-group m-t-sm">
                {assign var=rowid value=$cart_details["rowid"]}
                <button class="btn btn-primary" type="{$button_type}" id="purchase_request" value="purchase_request" name="purchase_request" disabled="true" {if $button_type=="button" } onclick="update_cart_item_by_product('{$rowid}')" {/if}>
                        {$button_name}
                </button>
                <a href="../repurchase_product"><button  class="btn btn-primary" type="button" id="cancel" value="Cancel" name="cancel">
                                    {lang('cancel')}
                </button></a>
            </div>
        </div>
    </div>
</div>
{form_close()} {/block}