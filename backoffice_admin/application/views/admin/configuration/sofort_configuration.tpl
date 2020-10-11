{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_project_id')}</span>
    <span id="validate_msg2">{lang('you_must_enter_customer_id')}</span>
    <span id="validate_msg3">{lang('you_must_enter_project_pass')}</span>
    <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
</div>

<legend>
    <span class="fieldset-legend">{lang('sofort_configuration')}</span>
    <a href="{$BASE_URL}admin/configuration/{if $link_origin == 0}payment_gateway_configuration{else}payout_setting{/if}" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        {form_open('', 'role="form" class="" method="post" name="sofort_status_form" id="sofort_status_form"')}
            {include file="layout/error_box.tpl"}
            <div class="form-group">
                <label class="required">{lang('customer_id')}</label>
                <input type="text" class="form-control" name="customer_id" id="customer_id" value="{$sofort_details['customer_id']}">
                {form_error('customer_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('project_id')}</label>
                <input type="text" class="form-control" name="project_id" id="project_id" value="{$sofort_details['project_id']}">
                {form_error('project_id')}
            </div>
            <div class="form-group">
                <label class="required">{lang('project_pass')}</label>
                <input type="password" class="form-control" name="project_pass" id="project_pass" value="{$sofort_details['project_pass']}">
                {form_error('project_pass')}
            </div>
            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="update_sofort" type="submit" value="update">{lang('update')}</button>
            </div>
        {form_close()}
    </div>
</div>

{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/bitgo_config.js" type="text/javascript" ></script>
{/block}