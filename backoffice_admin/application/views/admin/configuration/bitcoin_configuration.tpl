{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_api_key">{lang('you_must_enter_api_key')}</span>
    <span id="validate_api_secret_key">{lang('you_must_enter_api_secret_key')}</span>
    <span id="validate_mode">{lang('you_must_choose_type_of_mode')}</span>
    <span id="validate_live_wallet_name">{lang('you_must_enter_live_wallet_name')}</span>
    <span id="validate_live_wallet_password">{lang('you_must_enter_live_wallet_password')}</span>
    <span id="validate_test_wallet_name">{lang('you_must_enter_test_wallet_name')}</span>
    <span id="validate_test_wallet_password">{lang('you_must_enter_test_wallet_password')}</span>
</div>



<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">{lang('blocktrail_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>
        {form_open('', 'role="form" class="" method="post" name="bitcoin_configuration_form" id="bitcoin_configuration_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('api_key')}</label>
                <input type="text" class="form-control" name="api_key" id="api_key" value="{$bitcoin_details['api_key']}">
                {form_error('api_key')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_secret_key')}</label>
                <input type="text" class="form-control" name="api_secret_key" id="api_secret_key" value="{$bitcoin_details['api_secret_key']}">
                {form_error('api_secret_key')}
            </div>
            <div class="form-group">
                <label class="required">{lang('mode')}</label>
                <select type="text" class="form-control" name="mode" id="mode" value="">
                    <option value="0"{if $bitcoin_details['mode'] == 0}selected{/if}>{lang('test')}</option>
                    <option value="1"{if $bitcoin_details['mode'] == 1}selected{/if}>{lang('live')}</option>
                </select>
                {form_error('mode')}
            </div>
            <div class="form-group">
                <label class="required">{lang('live_wallet_name')}</label>
                <input type="text" class="form-control" name="live_wallet_name" id="live_wallet_name" value="{$bitcoin_details['live_wallet_name']}">
                {form_error('live_wallet_name')}
            </div>
            <div class="form-group">
                <label class="required">{lang('live_wallet_password')}</label>
                <input type="password" class="form-control" name="live_wallet_password" id="live_wallet_password" value="{$bitcoin_details['live_wallet_password']}">
                {form_error('live_wallet_password')}
            </div>
            <div class="form-group">
                <label class="required">{lang('test_wallet_name')}</label>
                <input type="text" class="form-control" name="test_wallet_name" id="test_wallet_name" value="{$bitcoin_details['test_wallet_name']}">
                {form_error('test_wallet_name')}
            </div>
            <div class="form-group">
                <label class="required">{lang('test_wallet_password')}</label>
                <input type="password" class="form-control" name="test_wallet_password" id="test_wallet_password" value="{$bitcoin_details['test_wallet_password']}">
                {form_error('test_wallet_password')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_bitcoin" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/bitgo_config.js" type="text/javascript" ></script>
{/block}