{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="xpub_required">{lang('xpub_required')}</span>
    <span id="api_key_required">{lang('you_must_enter_api_key')}</span>
    <span id="secret_required">{lang('secret_required')}</span>
    <span id="main_password_required">{lang('main_password_required')}</span>
    <span id="second_password_required">{lang('second_password_required')}</span>
    <span id="fee_required">{lang('fee_required')}</span>
</div>



<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">{lang('blockchain_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>
        {form_open('', 'role="form" class="" method="post" name="blockchain_configuration_form" id="blockchain_configuration_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('xpub')}</label>
                <input type="text" class="form-control" name="my_xpub" id="my_xpub" value="{$blockchain_details['my_xpub']}">
                {form_error('my_xpub')}
            </div>
            <div class="form-group">
                <label class="required">{lang('api_key')}</label>
                <input type="text" class="form-control" name="my_api_key" id="my_api_key" value="{$blockchain_details['my_api_key']}">
                {form_error('my_api_key')}
            </div>
            <div class="form-group">
                <label class="required">{lang('secret')}</label>
                <input type="text" class="form-control" name="secret" id="secret" value="{$blockchain_details['secret']}">
                {form_error('secret')}
            </div>
            <div class="form-group">
                <label class="required">{lang('main_password')}</label>
                <input type="password" class="form-control" name="main_password" id="main_password" value="{$blockchain_details['main_password']}">
                {form_error('main_password')}
            </div>
            <div class="form-group">
                <label class="required">{lang('second_password')}</label>
                <input type="password" class="form-control" name="second_password" id="second_password" value="{$blockchain_details['second_password']}">
                {form_error('second_password')}
            </div>
            <div class="form-group">
                <label class="required">{lang('fee')}</label>
                <input type="text" class="form-control" name="fee" id="fee" value="{$blockchain_details['fee']}">
                {form_error('fee')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_blockchain" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/bitgo_config.js" type="text/javascript" ></script>
{/block}