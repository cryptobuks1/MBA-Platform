{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;"> 
        <span id="err_msg1">{lang('you_must_enter_merchant_id')}</span>
        <span id="err_msg2">{lang('you_must_enter_merchant_key')}</span>
        <span id="err_msg3">{lang('you_must_enter_encryption_key')}</span>
        <span id="err_msg4">{lang('you_must_enter_account')}</span>
        <span id="err_msg5">{lang('only_alpha_numric')}</span>
        <span id="err_msg6">{lang('you_must_enter_api_id')}</span>
        <span id="err_msg7">{lang('only_numbers')}</span>
        <span id="err_msg8">{lang('you_must_enter_api_key')}</span>
        <span id="err_msg9">{lang('you_must_enter_tran_pass')}</span>
    </div>



    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">{lang('payeer_configuration')}</span>
              {*  <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
                    <i class="fa fa-backward"></i>
                    {lang('back')}
                </a>*}
                <a href="{$BASE_URL}admin/configuration/payment_view" class="btn btn-addon btn-sm btn-info pull-right">
                    <i class="fa fa-backward"></i>
                    {lang('back')}
                </a>
            </legend>
            {form_open('', 'role="form" class="" method="post" name="payeer_configuration_form" id="payeer_configuration_form"')}
            {include file="layout/error_box.tpl"}
            {*<!--<div class="form-group">
                <label class="required">{lang('merchant_id')}</label>
                <input type="text" class="form-control" name="merchant_id" id="merchant_id" value="{$payeer_details['merchant_id']}" maxlength="20" autocomplete="off">
                {form_error('merchant_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('merchant_key')}</label>
                <input type="text" class="form-control" name="merchant_key" id="merchant_key" value="{$payeer_details['merchant_key']}" maxlength="20" autocomplete="off">
                {form_error('merchant_key')}
            </div>
            <div class="form-group">
                <label class="required">{lang('encryption_key')}</label>
                <input type="text" class="form-control" name="encryption_key" id="encryption_key" value="{$payeer_details['encryption_key']}" maxlength="20" autocomplete="off">
                {form_error('encryption_key')}
            </div>
            <div class="form-group">
                <label class="required">{lang('account')}</label>
                <input type="text" class="form-control" name="account" id="account" value="{$payeer_details['account']}" maxlength="20" autocomplete="off">
                {form_error('account')}
            </div>-->*}
            
            <div class="form-group">
                <label class="required">{lang('account')}</label>
                <input type="text" class="form-control" name="account" id="account" value="{$payeer_details['acc_no']}" maxlength="20" autocomplete="off">
                {form_error('account')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_id')}</label>
                <input type="text" class="form-control" name="api_id" id="api_id" value="{$payeer_details['api_id']}" maxlength="20" autocomplete="off">
                {form_error('api_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_key')}</label>
                <input type="text" class="form-control" name="api_key" id="api_key" value="{$payeer_details['api_key']}" maxlength="20" autocomplete="off">
                {form_error('api_key')}
            </div>
            <div class="form-group">
                    <label class="required">{lang('transaction_password')}</label>
                    <input class="form-control" type="password" id="pswd1" name="pswd1" />
                    {form_error('pswd1')}
             </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_payeer" type="submit" value="update">{lang('update')}</button>
            </div>
            {form_close()}
        </div>
    </div>

{/block}
{block name='script'}
    <script src="{$PUBLIC_URL}javascript/validate_paypal_config.js" type="text/javascript" ></script>
{/block}