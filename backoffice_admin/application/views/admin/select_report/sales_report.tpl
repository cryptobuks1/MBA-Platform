{extends file=$BASE_TEMPLATE}{block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
{/block}{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_select_from_date')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg2">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg3">{lang('you_must_select_product')}</span>
    <span id="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>

</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('sales_report')}</span></legend>
        {form_open('admin/sales_report_view','role="form" class="" method="post" name="sales_report" id="weekly_payout" target="_blank" onsubmit = "return dateValidation()"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label>{lang('from_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> {if $error_count && isset($error_array['week_date1'])}{$error_array['week_date1']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label>{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {if $error_count && isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label>{lang('select_package')}</label>
                <select name="product_id" id="product_id" class="form-control">
                <option value='register'>{lang('register')}</option>
                {if $MODULE_STATUS['opencart_status'] == "yes" || $MODULE_STATUS['repurchase_status'] == "yes"}
                <option value='repurchase'>{lang('repurchase')}</option>
                {/if}
        </select>
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="weekdate" id="weekdate" type="submit" value="{lang('submit')}">
            {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('product_wise_sales_report')} : {lang('register')}</span></legend>
        {form_open('admin/product_sales_report','role="form" class="" method="post" name="user" id="user" target="_blank"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="product_id">{lang('select_package')}</label>
                <select name="product_id" id="product_id" onChange="change_product(this);" class="form-control">
                    {$products}
                    <option value='all'>All</option>
                </select> {if $error_sales_count && isset($error_array['product_id'])}{$error_array_sales['product_id']}{/if}
                <input type='hidden' value='yes' name='pro_status' class="form-control">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="user_submit" id="user_submit" type="submit" value="{lang('view')}">
                    {lang('view')} </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

{if $MODULE_STATUS['opencart_status'] == "yes" || $MODULE_STATUS['repurchase_status'] == "yes"}
<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('product_wise_sales_report')} : {lang('repurchase')}</span></legend>
        {form_open('admin/product_sales_report','role="form" class="" method="post" name="user" id="rp_user" target="_blank"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="product_id">{lang('select_package')}</label>
                <select name="product_id" id="product_id" onChange="change_product(this);" class="form-control">
                {$repurchase_products}
                <option value='all'>All</option>
            </select> {if $error_sales_count && isset($error_array['rp_product_id'])}{$error_array_sales['rp_product_id']}{/if}
                <input type='hidden' value='yes' name='pro_status' class="form-control">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="user_submit_repurchase" id="user_submit_repurchase" type="submit" value="{lang('view')}"> {lang('view')} </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
{/if}
{/block}