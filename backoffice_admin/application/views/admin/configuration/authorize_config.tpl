{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_merchant_id')}</span>
    <span id="validate_msg2">{lang('you_must_enter_transaction_key')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<legend>
    <span class="fieldset-legend">{lang('authorize_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open('', 'role="form" class="" method="post" name="authorize_status_form" id="authorize_status_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('merchant_log_id')}</label>
                <input type="text" class="form-control" name="merchant_log_id" id="merchant_log_id" value="{$authorize_details['merchant_id']}">
                {form_error('merchant_log_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('transaction_key')}</label>
                <input type="password" class="form-control" name="transaction_key" id="transaction_key" value="{$authorize_details['transaction_key']}">
                {form_error('transaction_key')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_authorize" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/bitgo_config.js" type="text/javascript" ></script>
{/block}