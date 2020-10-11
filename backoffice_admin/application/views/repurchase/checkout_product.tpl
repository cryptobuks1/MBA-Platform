{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg_remove">{lang('sure_you_want_to_remove_this_item')}</span>
    <span id="confirm_msg_update">{lang('sure_you_want_to_update_this_item')}</span>
    <span id="error_msg1">{lang('name_is_required')}</span>
    <span id="error_msg2">{lang('address_is_required')}</span>
    <span id="error_msg3">{lang('pin_is_required')}</span>
    <span id="error_msg4">{lang('pin_must_number')}</span>
    <span id="error_msg5">{lang('city_is_required')}</span>
    <span id="error_msg6">{lang('phone_required')}</span>
    <span id="error_msg7">{lang('phone_must_number')}</span>
    <span id="error_alpha_spec">{lang('alpha_space_only')}</span>
    <span id="error_alpha_city">{lang('alpha_city_only')}</span>
    <span id="err_qnt">{lang('Quantity_Is_required')}</span>
    <span id="error_msg8">{lang('please_enter_no_more_than_10_digits')}</span>
    <span id="confirm_msg_remove_address">{lang('sure_you_want_to_remove_this_address')}</span>
</div>
<input type="hidden" value="{$PATH_TO_ROOT}" id="path_root">
<legend><span class="fieldset-legend">{lang('checkout_Steps')}</span></legend>
{if !$cart_empty}
<section class="form-box">

    <div class="form-wizard">

        <!-- Form Wizard -->
        {form_open('repurchase/repurchase_submit', 'role="form" class="forml" method="post" name="form" id="form"')} {assign var=active_tab_val value="free_purchase"}

        <!-- Form progress -->
        <div class="form-wizard-steps form-wizard-tolal-steps-4">
            <div class="form-wizard-progress">
                <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
            </div>
            <!-- Step 1 -->
            <div class="form-wizard-step active">
                <p>{lang('Packages')}</p>
            </div>
            <!-- Step 1 -->

            <!-- Step 2 -->
            <div class="form-wizard-step">
                <p>{lang('contact_information')}</p>
            </div>
            <!-- Step 2 -->

            <!-- Step 3 -->
            <div class="form-wizard-step">
                <p>{lang('order_summery')}</p>
            </div>
            <!-- Step 3 -->

            <!-- Step 4 -->
            <div class="form-wizard-step">
                <p>{lang('payment_method')}</p>
            </div>
            <!-- Step 4 -->
        </div>
        <!-- Form progress -->

        <!-- Form Step 1 -->
        <fieldset>

                <div class="panel panel-default  ng-scope">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="2">{lang('Items')}</th>
                                <th>{lang('Quantity')}</th>
                                <th>{lang('Price')}</th>
                                <th>{lang('Total')}</th>
                                <th>{lang('Action')}&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value=0 } {foreach from=$cart_products item=product}
                            <tr>
                                <td>
                                    <div class="checkout-image">
                                        {if $product['prod_img'] != '' && $product['prod_img']!="no"}
                                        <img src="{$SITE_URL}/uploads/images/product_img/{$product['prod_img']}"   alt="a"   /> {else}
                                        <img src="{$SITE_URL}/uploads/images/product_img/cart.jpg"  /> {/if}
                                    </div>
                                </td>
                                <td>{$product['name']}</td>
                                <td class="input_width_cart">

                                        <input class="form-control quantity" size="100" type="number" name="quantity{$i}" id="quantity{$i}" min="1" max="100" value='{$product["qty"]}'>
                                         <span id="quantity_err{$i}" style="color:#b94a48;"></span>

                                </td>
                                <td>{$DEFAULT_SYMBOL_LEFT} {number_format($product['price']*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                                </td>
                                <td>{$DEFAULT_SYMBOL_LEFT} {number_format($product['subtotal']*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                                </td>
                                <td class="ipad_button_table">

                                        <button type="button" class="btn btn-primary btn-xs" onClick="update_cart_item('{$product['rowid']}',this)"><i
                                                class="fa fa-refresh"> {lang('Refresh')}</i></button>


                                        <button class="btn btn-info btn-xs" type="button" onClick="remove_cart_item('{$product['rowid']}')"><i
                                                class="fa fa-trash-o"></i> {lang('Remove')}</button>

                                    </a>
                                </td>
                            </tr>
                            {$i = $i+1} {/foreach}
                            <tr>
                                <td class="text-right" colspan="5" class="bold-text-center">
                                    <b>{lang('Total')}</b>
                                </td>
                                <td colspan="2"><b>{$DEFAULT_SYMBOL_LEFT}
                                        {number_format($cart_total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}
                                        {$DEFAULT_SYMBOL_RIGHT}</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
                <button class="btn m-b-xs pull-left btn-sm btn-primary btn-addon" type="button" onClick="remove_cart_item('all')"><i
                        class="fa fa-shopping-cart"></i>{lang('remove_all')}</button>

            <div class="form-wizard-buttons">
                <button type="button" class="btn btn-next btn-primary" name="Continue" value="{lang('continue')}">{lang('continue')}</button>
            </div>
        </fieldset>
        <!-- Form Step 1 -->

        <!-- Form Step 2 -->
        <fieldset>
            <div class="row" id="pricing_table_example1">
                <input type="hidden" name="default_address_id" id="default_address_id" value="{$default_address}"> {foreach from=$user_address item=v}
                <div class="col-sm-3 addr" id="address_{$v.id}">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="clearfix">
                                <div class="clear">
                                    <div class="h3 m-t-xs m-b-xs address_height">{$v.name}
                                         <a class="close" href="javascript:delete_addres('{$v.id}')" data-dismiss="modal"><span
                                                aria-hidden="true">×</span><span class="sr-only">{lang('close')}</span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="list-group no-radius alt">
                            <div class="list-group-item address_height"> {$v.address} </div>
                            <div class="list-group-item"> {$v.town} </div>
                            <div class="list-group-item"> {$v.pin} </div>
                            <div class="list-group-item"> {$v.mobile} </div>
                            <div class="clear text-center">
                                <button type="button" class="btn btn-addon btn-sm btn-info m-t-xs m-b-xs make_default" value="{$v.id}" {if $v.id==$default_address} disabled {/if}> <i class="fa fa-eye"></i>{lang('default')}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {/foreach}
            </div>
            <button type="button" data-toggle="modal" data-target="#add-new-address" class="btn m-b-xs btn-sm btn-primary pull-left btn-addon m-b-sm"><i
                    class="fa fa-plus"></i>{lang('Add_New_Address')}</button>
            <div class="form-wizard-buttons">
                <button type="button" class="btn btn-previous btn-info" name='Remove' value="{lang('back')}">{lang('back')}</button>
                <button type="button" id="continue_address" class="btn btn-next btn-primary " name='Continue' value="{lang('continue')}">{lang('continue')}</button>
            </div>
        </fieldset>
        <!-- Form Step 2 -->

        <!-- Form Step 3 -->
        <fieldset>
            <div class="panel panel-default ng-scope">
            <div class=" table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{lang('sl_no')}</th>
                            <th>{lang('product_name')}</th>
                            <th>{lang('Quantity')}</th>
                            <th>{lang('Total')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var="i" value=1 } {assign var="total_quantity" value=0} {foreach from=$cart_products item=product}
                        <tr>
                            <td>{$i}</td>
                            <td>{$product['name']}</td>
                            <td>{$product["qty"]}</td>
                            <td>{$DEFAULT_SYMBOL_LEFT} {number_format($product['subtotal']*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}
                            </td>
                            {$i = $i+1} {$total_quantity = $total_quantity + $product['qty']}
                        </tr>
                        {/foreach}
                        <tr>
                            <td class="text-right" colspan="3"><strong><b>{lang('Total')}</b></strong></td>
                            <td><strong><b>{$DEFAULT_SYMBOL_LEFT}
                                    {number_format($cart_total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}
                                    {$DEFAULT_SYMBOL_RIGHT}</b></strong></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="form-wizard-buttons">
                <button type="button" class="btn btn-previous btn-info" name='Remove' value="{lang('back')}">{lang('back')}</button>
                <button type="button" class="btn btn-next btn-primary" name='Continue' value="{lang('continue')}">{lang('continue')}</button>
            </div>
        </fieldset>
        <!-- Form Step 3 -->

        <!-- Form Step 4 -->
        <fieldset>
            {include file="repurchase/payment_tab.tpl"}
            <div class="form-wizard-buttons">
                <button type="button" class="btn btn-previous btn-info" name='Remove' value="{lang('back')}">{lang('back')}</button>
                <button type="submit" class="btn btn-submit btn-primary sw-btn-finish" disabled name='finish' value='{lang("finish")}'>{lang("finish")}</button>
            </div>
        </fieldset>
        <!-- Form Step 4 -->

        {form_close()}
        <!-- Form Wizard -->
    </div>
</section>
{else}
<div class="row">
    <div class="col-sm-12">
        <h4 class="text-center">{lang('no_item_added_to_cart')}</h4>
        <div class="col-lg-2-4 pull-right">
            <a href="repurchase_product"><button class="btn m-b-xs btn-primary btn-finish chkt-cntn"><i class="fa fa-shopping-cart"></i>&nbsp;{lang('continue_shopping')}</button></a>
        </div>
    </div>
</div>
{/if}
<input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
<input type="hidden" id="logged_user_name" value="{$logged_user_name}">
<input type="hidden" id="address_count" value="{count($user_address)}">
<span id="digits_only" style="display: none">{lang('digits_only')}</span>
<div id="add-new-address" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
        </button>
        <h4 class="modal-title">{lang('enter_new_shipping_address')}</h4>
    </div>
    <div class="modal-body">
        {form_open('','role="form" class="" method="post" name="add_address" id="add_address"')}
        <div class="form-group">
            <label for="form-field-1">
                {lang('name')}<span class="symbol required"></span>
            </label>

            <input type="text" id="full_name" name="full_name" class="form-control">

        </div>
        <div class="form-group">
            <label for="form-field-1">
                {lang('address')}<span class="symbol required"></span>
            </label>

            <textarea id="address" name="address" class="form-control textfixed"></textarea>

        </div>
        <div class="form-group">
            <label for="form-field-1">
                {lang('pin_number')}<span class="symbol required"></span>
            </label>

            <input type="text" id="pin_no" name="pin_no" class="form-control">

        </div>
        <div class="form-group">
            <label for="form-field-1">
                {lang('city')}<span class="symbol required"></span>
            </label>

            <input type="text" id="city" name="city" class="form-control">

        </div>
        <div class="form-group">
            <label for="form-field-1">
                {lang('phone_number')}<span class="symbol required"></span>
            </label>

            <input type="text" id="phone" name="phone" class="form-control">

        </div>
        <!-- <div class="modal-footer"> -->
        <!-- <button type="button" data-dismiss="modal">
                Close
            </button> -->
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-right" id="add_address_button">
                {lang('save_changes')}
            </button>
        </div>
        <!-- </div> -->
        {form_close()}
    </div>
</div>
<div id="address_div">
    <div class="col-sm-3 addr">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="clearfix">
                    <div class="clear">
                        <div class="h3 m-t-xs m-b-xs address_height name"><span class="text"></span>
                            <a class="close" href="#" id="delete" data-dismiss="modal"><span
                                    aria-hidden="true">×</span><span class="sr-only">{lang('close')}</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group no-radius alt">
                <div class="list-group-item address_details1 address_height"></div>
                <div class="list-group-item address_details2"></div>
                <div class="list-group-item address_details3"></div>
                <div class="list-group-item phone_no_field"></div>
                <div class="clear text-center">
                    <button type="button" id="default_field" class="btn btn-addon btn-sm btn-info m-t-xs m-b-xs make_default" value=""> <i class="fa fa-eye"></i>{lang('default')} </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="epin_row" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td></td>
                <td>
                    <input class="form-control epin_input" type="text" name="epin[]" onblur="loadEpinBlur();" autocompleautote="Off" />
                </td>
                <td>
                    <input class="form-control" type="text" name="pin_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="remaining_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="balance_amount[]" readonly/>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div id="alert_div" style="display: none;">
    <div id="err_reciept" class="alert alert-dismissable text-left">
        <a href="#" style="display:block !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
</div>
{/block}

{block name=script}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}theme/js/cart-js.js"></script>
    <script src="{$PUBLIC_URL}theme/js/tabs_new.js"></script>
    <script src="{$PUBLIC_URL}javascript/repurchase.js"></script>
{/block}

{block name=style}
    {$smarty.block.parent}
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/cart-wizard.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}theme/css/user_tab.css" type="text/css" />
    <link rel="stylesheet" href="{$PUBLIC_URL}plugins/bootstrap-fileupload/bootstrap-fileupload.min.css" type="text/css" />
{/block}
