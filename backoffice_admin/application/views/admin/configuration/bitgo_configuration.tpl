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
    <span class="fieldset-legend">{lang('bitgo_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>
        {form_open('', 'role="form" class="" method="post" name="bitgo_configuration_form" id="bitgo_configuration_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('wallet_id')}</label>
                <input type="text" class="form-control" name="wallet_id" id="wallet_id" value="{$bitgo_details['wallet_id']}">
                {form_error('wallet_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('token')}</label>
                <input type="text" class="form-control" name="token" id="token" value="{$bitgo_details['token']}">
                {form_error('token')}
            </div>
            <div class="form-group">  
                <label class="required">{lang('mode')}</label>
                <select class="form-control" name="mode" id="mode" value=''>
                    <option value="test"{if $bitgo_details['mode'] == 'test'}selected{/if}>{lang('test')}</option>
                    <option value="live"{if $bitgo_details['mode'] == 'live'}selected{/if}>{lang('live')}</option>
                </select>
                {form_error('mode')}
            </div>
            <div class="form-group">
                <label class="required">{lang('passphrase')}</label>
                <input type="text" class="form-control" name="passphrase" id="passphrase" value="{$bitgo_details['wallet_passphrase']}">
                {form_error('passphrase')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_bitgo" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}