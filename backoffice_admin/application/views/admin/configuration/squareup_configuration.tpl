{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_access_token')}</span>
    <span id="validate_msg2">{lang('you_must_enter_location_id')}</span>
    <span id="validate_msg3">{lang('you_must_enter_application_id')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<legend>
    <span class="fieldset-legend">{lang('squareup_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open('', 'role="form" class="" method="post" name="squareup_status_form" id="squareup_status_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('access_token')}</label>
                <input type="text" class="form-control" name="access_token" id="access_token" value="{$squareup_details['access_token']}">
                {form_error('access_token')}
            </div>
            <div class="form-group">
                <label class="required">{lang('application_id')}</label>
                <input type="text" class="form-control" name="application_id" id="application_id" value="{$squareup_details['application_id']}">
                {form_error('application_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('location_id')}</label>
                <input type="text" class="form-control" name="location_id" id="location_id" value="{$squareup_details['location_id']}">
                {form_error('location_id')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_squareup" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/bitgo_config.js" type="text/javascript" ></script>
{/block}