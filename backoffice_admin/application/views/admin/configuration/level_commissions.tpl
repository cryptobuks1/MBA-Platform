{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
     <style>
        table.table thead {
         background-color: white;
        }
        table > tbody > tr > td {
            border: none !important;
            text-align: left !important;
            }
     </style>
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_level_configuration.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg18">{lang('value_must_be_1_2_3')}</span>
    <span id="validate_msg19">{lang('x_up_required')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg16">{lang('you_must_enter_commission')}</span>
    <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="validate_msg31">{lang('please_enter_max_ref')}</span>
    <span id="level_n_bonus">{lang('level_n_bonus')|strtolower}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="upto_level">{lang('commission_level_less_than_100')}</span>
</div>

<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {assign var=tab_status value=0}
        {if ($MLM_PLAN =="Party" && $MODULE_STATUS['sponsor_commission_status'] == "yes" ) || ($MLM_PLAN !="Party")}
            {$tab_status =1}
        {/if}
        {form_open('','role="form" class="" name="form_setting1" id="form_setting1"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {if $tab_status}
            {include file="layout/error_box.tpl"}

            {if $MODULE_STATUS['xup_status'] == 'yes'}
                <div class="form-group">
                    <label class="required">{lang('xup_level')}</label>
                    <input class="form-control" type="text" name="xup_level" id="xup_level" value="{$xup_level}" autocomplete="off">
                    {form_error('xup_level')}
                </div>
            {/if}
            <div class="form-group">
                <label class="required control-label">{lang('type_of_commission')}</label>
                <select class="form-control" name="level_commission_type"  id="level_commission_type" onchange="change_level_commission_type(this.value);">
                    <option value="percentage" {if $obj_arr["level_commission_type"]=='percentage'} selected="true"{/if}>{lang('percentage')}</option>
                    <option value="flat" {if $obj_arr["level_commission_type"]=='flat'} selected="true"{/if}>{lang('flat')}</option>
                </select>
                {form_error("level_commission_type")}
            </div>
            <div class="form-group">
                <label class="required control-label">{lang('commission_criteria')}</label>
                <select class="form-control" name="level_commission_criteria"  id="level_commission_criteria">
                    <option value="genealogy" {if $active_commission == 'genealogy'} selected="true"{/if}>{lang('commission_based_on_genealogy')}</option>
                    {if (($MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes") && $MODULE_STATUS['product_status'] == "yes")}
                        <option value="reg_pck" {if $active_commission == 'reg_pck'} selected="true"{/if}>{lang('commission_based_on_reg_pack')}</option>
                        <option value="member_pck" {if $active_commission == 'member_pck'} selected="true"{/if}>{lang('commission_based_on_member_pck')}</option>
                    {/if}
                </select>
                {form_error("level_commission_criteria")}
            </div>
            <div class="form-group">
                <label class="required control-label">{lang('level_commission_upto_level')}</label>
                <input type="text" maxlength="5" class="form-control" name="commission_upto_level" data-lang="{lang('you_must_enter')} {lang('level_commission_upto_level')}" id="commission_upto_level" min="0" value="{$active_level}">
                {form_error("commission_upto_level")}
            </div>
            <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_commission_common" id="level_commission">{lang('update')}</button>
            </div>
        {form_close()}
        {/if}
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
            <input type="hidden" name="active_tab" id="active_tab" value="">
            <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
            <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
            {if $tab_status}
                <div id="level_div"></div>
            {/if}
         {form_close()}
    </div>
     <input id="view_url" value="{$BASE_URL}admin/configuration/level_commissions_view" type="hidden">
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}