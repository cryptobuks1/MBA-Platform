{extends file=$BASE_TEMPLATE}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_paypal_config.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_api_username">{lang('you_must_enter_api_username')}</span>
    <span id="validate_api_password">{lang('you_must_enter_api_password')}</span>
    <span id="validate_api_signature">{lang('you_must_enter_api_signature')}</span>
    <span id="validate_mode">{lang('you_must_choose_type_of_mode')}</span>
    <span id="validate_currency1">{lang('you_must_enter_the_currency_code')}</span>
    <span id="validate_currency2">{lang('currency_code_should_be_in_proper_format')}</span>
    <span id="validate_currency3">{lang('currency_code_should_be_in_proper_format')}</span>
    <span id="validate_currency4">{lang('currency_code_should_be_in_proper_format')}</span>
    <span id="validate_return_url">{lang('you_must_enter_return_url')}</span>
    <span id="validate_cancel_url">{lang('you_must_enter_cancel_url')}</span>
</div>


<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">{lang('paypal_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

        {form_open('', 'role="form" class="" method="post" name="payment_status_form" id="payment_status_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('api_username')}</label>
                <input type="text" class="form-control" name="api_username" id="api_username" value="{$paypal_details['api_username']}">
                {form_error('api_username')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_password')}</label>
                <input type="password" class="form-control" name="api_password" id="api_password" value="{$paypal_details['api_password']}">
                {form_error('password')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_signature')}</label>
                <input type="text" class="form-control" name="api_signature" id="api_signature" value="{$paypal_details['api_signature']}">
                {form_error('api_signature')}
            </div>
            <div class="form-group">
                <label class="required">{lang('mode')}</label>
                <select type="text" class="form-control" name="mode" id="mode" value="{$paypal_details['mode']}">
                    <option value="test">{lang('Test')}</option>
                    <option value="production">{lang('Production')}</option>
                </select>
                {form_error('mode')}
            </div>
            <div class="form-group">
                <label class="required">{lang('currency')}</label>
                <input type="text" class="form-control" name="currency" id="currency" value="{$paypal_details['currency']}">
                {form_error('currency')}
            </div>
            <div class="form-group">
                <label class="required">{lang('return_url')}</label>
                <input type="text" class="form-control" name="return_url" id="return_url" value="{$paypal_details['return_url']}">
                {form_error('return_url')}
            </div>
            <div class="form-group">
                <label class="required">{lang('cancel_url')}</label>
                <input type="text" class="form-control" name="cancel_url" id="cancel_url" value="{$paypal_details['cancel_url']}">
                {form_error('cancel_url')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_paypal" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}