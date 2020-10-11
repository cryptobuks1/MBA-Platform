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
     <script src="{$PUBLIC_URL}javascript/validate_referal_configuration.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
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
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="lang_referral_comm">{lang('referal_commission')|strtolower}</span>
</div>
<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        <input type="hidden" id="referal_commission_type" name="referal_commission_type" value="flat" />
        {include file="layout/error_box.tpl"}
        {if $MODULE_STATUS['referal_status'] == "yes"}
            {if $MODULE_STATUS['rank_status'] == 'yes' || $MODULE_STATUS['product_status'] == 'yes'}
                <div class="form-group">
                    <label class="required">{lang('referral_commission_criteria')}</label>
                    <select class="form-control" name="sponsor_commission_type" id="sponsor_commission_type">

                    {if $MODULE_STATUS['product_status'] == "yes"}
                        {if $MODULE_STATUS['opencart_status'] == "no" && $MODULE_STATUS['opencart_status_demo'] == "no"}
                            <option value="joinee_package" {if $active == 'joinee_package'}selected{/if}>{lang('based_on_join_pack')} </option>
                        {/if}
                        <option value="sponsor_package" {if $active == 'sponsor_package'}selected{/if}>{lang('based_on_sponsor_pack')} </option>
                    {/if}
                    {if $MODULE_STATUS['rank_status'] == "yes"}
                    <option value="rank" {if $active == 'rank'}selected{/if}>{lang('based_on_sponsor_rank')} </option>
                    {/if}
                    </select>
                    {form_error('sponsor_commission_type')}
                </div>
                <div id="referal_rank_div">
                    {if $MODULE_STATUS['rank_status'] == 'yes'}
                    {foreach from=$rank_details item=u}
                        <div class="form-group">
                            <label class="required">
                                {lang('referal_commission')} - {$u['rank_name']}
                                <span class="span_level_commission">{if $obj_arr["referal_commission_type"] == "percentage"}%{/if}</span>
                            </label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                                <input type="text" maxlength="5" class="level_percentage form-control" name="rank_referal{$u['rank_id']}" data-lang="{lang('you_must_enter')} {$u['rank_name']} {lang('referal_commission')}" id="rank_referal{$u['rank_id']}" min="0" {if $obj_arr["referal_commission_type"] != "percentage"} value="{number_format({$u['referal_commission']}*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u['referal_commission']}"{/if}>
                                {$right_symbol}
                            </div>
                            {form_error("rank_referal{$u['rank_id']}")}
                        </div>
                    {/foreach}
                    {/if}
                </div>
                <div id="referal_package_div">
                    {if $MODULE_STATUS['product_status'] == 'yes'}
                    {foreach from=$product_details item=u}
                        <div class="form-group">
                            <label class="required">
                                {lang('referal_commission')} - {$u['product_name']}
                                <span class="span_level_commission">{if $obj_arr["referal_commission_type"] == "percentage"}%{/if}</span>
                            </label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                                <input type="text" maxlength="5" class="level_percentage form-control" name="pck_referal{$u['product_id']}" data-lang="{lang('you_must_enter')} {$u['product_name']} {lang('referal_commission')}" id="pck_referal{$u['product_id']}" min="0" {if $obj_arr["referal_commission_type"] != "percentage"} value="{number_format({$u['referral_commission']}*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u['referral_commission']}"{/if}>
                                {$right_symbol}
                            </div>
                            {form_error("pck_referal{$u['product_id']}")}
                        </div>
                    {/foreach}
                    {/if}
                </div>

            {else}
                <div class="form-group">
                    <label class="required">
                        {lang('referal_commission')}
                    </label>
                    <div class="input-group {$input_group_hide}">
                        {$left_symbol}
                        <input type="text" maxlength="5" class="form-control" name="referal_amount" id="referal_amount" min="0" value="{round({$obj_arr['referal_amount']}*$DEFAULT_CURRENCY_VALUE,2)}">
                        {$right_symbol}
                    </div>
                    {form_error("referal_amount")}
                </div>
            {/if}
            <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="referral_setting" id="referral_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
            </div>
        {/if}
        {form_close()}
        {* {if $MODULE_STATUS['rank_status'] == 'yes' || $MODULE_STATUS['product_status'] == 'yes'}
            {$link = ''}
            {if $active == 'joinee_package'}
                {$link = 'membership_package'}
                {$link_text = lang('configure_pack_based_referal_bonus')}
            {elseif $active == 'sponsor_package'}
                {$link = 'membership_package'}
                {$link_text = lang('configure_pack_based_referal_bonus')}
            {elseif $active == 'rank'}
                {$link = 'rank_configuration'}
                {$link_text = lang('configure_rank_based_referal_bonus')}
            {/if}
            <div class="col-sm-12 padding_both_small">
                <p>
                    <u>
                        <a href="{$BASE_URL}admin/{$link}" class="text-info">{$link_text}</a>
                    </u>
                </p>
            </div>
        {/if} *}
    </div>
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}