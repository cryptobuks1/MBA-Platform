{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg1">{lang('you_must_enter_pay_out_pair_price')}</span>
    <span id="validate_msg2">{lang('tran_you_must_enter_celing_amount')}</span>
    <span id="validate_msg3">{lang('you_must_enter_service_charge')}</span>
    <span id="validate_msg4">{lang('you_must_enter_tds_value')}</span>
    <span id="validate_msg5">{lang('you_must_enter_product_point_value')}</span>
    <span id="validate_msg6">{lang('you_must_enter_referal_amount')}</span>
    <span id="validate_msg7">{lang('you_must_enter_a_valid_pay_out_price')}</span>
    <span id="validate_msg11">{lang('need_rank_days')}</span>
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="validate_msg15">{lang('Digit limit is five')}</span>
    <span id="pair_ceiling_pv_span">{lang('pair_cieling_pv')}</span>
    <span id="pair_ceiling_count_span">{lang('pair_cieling_count')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg16">{lang('you_must_enter_commission')}</span>
    <span id="validate_msg17">{lang('please_enter_max_count')}</span>
    <span id="validate_msg18">{lang('value_must_be_1_2_3')}</span>
    <span id="validate_msg19">{lang('x_up_required')}</span>
    <span id="validate_msg20">{lang('service_charge_required')}</span>
    <span id="validate_msg21">{lang('service_charge_must_between_0_to_100')}</span>
    <span id="validate_msg22">{lang('tds_required')}</span>
    <span id="validate_msg23">{lang('tds_must_between_0_to_100')}</span>
    <span id="validate_msg24">{lang('sum_of_tds_and_service_charge_should_be_less_equal_to_100')}</span>
    <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="validate_msg31">{lang('field1_greater_than_equal_field2')}</span>
    <span id="level_n_bonus">{lang('level_n_bonus')|strtolower}</span>
    <span id="lang_bonus">{lang('bonus')|strtolower}</span>
    <span id="lang_personal_pv">{lang('personal_pv')|strtolower}</span>
    <span id="lang_group_pv">{lang('group_pv')|strtolower}</span>
    <span id="lang_bonus_amount">{lang('bonus_amount')|strtolower}</span>
    <span id="lang_referral_count">{lang('referral_count1')|strtolower}</span>
    <span id="lang_days">{lang('days')|strtolower}</span>
    <span id="pair_ceiling_count_required">{lang('pair_ceiling_count_required')}</span>
    <span id="pair_value_required">{lang('pair_value_required')}</span>
    <span id="depth_ceiling_required">{lang('depth_ceiling_required')}</span>
    <span id="registration_amount_required">{lang('registration_amount_required')}</span>
    <span id="trans_fee_required">{lang('trans_fee_required')}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="lang_pair_ceiling_pv">{lang('pair_ceiling_pv')}</span>
    <span id="lang_pair_ceiling_daily_pv">{lang('pair_ceiling_daily_pv')}</span>
    <span id="lang_pair_ceiling_monthly_pv">{lang('pair_ceiling_monthly_pv')}</span>
    <span id="lang_pair_ceiling_count">{lang('pair_ceiling_count')}</span>
    <span id="lang_pair_ceiling_daily_count">{lang('pair_ceiling_daily_count')}</span>
    <span id="lang_pair_ceiling_monthly_count">{lang('pair_ceiling_monthly_count')}</span>
    <span id="board1_name">{lang('board1_name')|strtolower}</span>
    <span id="board1_width">{lang('board1_width')|strtolower}</span>
    <span id="board1_depth">{lang('board1_depth')|strtolower}</span>
    <span id="table_name">{lang('table_name')|strtolower}</span>
    <span id="table_width">{lang('table_width')|strtolower}</span>
    <span id="table_depth">{lang('table_depth')|strtolower}</span>
    <span id="board1_commission">{lang('board1_commission')|strtolower}</span>
    <span id="table_commission">{lang('table_commission')|strtolower}</span>
     <span id="max_5">{lang('please_enter_max_ref')}</span>
     <span id="override_required">{lang('override_commission')|strtolower}</span>
     <span id="purchase_income_perc_required">{lang('purchase_wallet_commission')|strtolower}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}
<div class="row">
    <div class="col-md-12">

        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {assign var=tab_status value=0}
        {if ($MLM_PLAN =="Party" && $MODULE_STATUS['sponsor_commission_status'] == "yes" ) || ($MLM_PLAN !="Party")}
            {$tab_status =1}
        {/if}
        <div class="tabsy">
            {if $tab_status}
                <input type="radio" id="panel_plan_setting" name="tab" {if $tab1} checked {/if}>
                <label class="tabButton" for="panel_plan_setting">{lang('compensation')}</label>
                <div class="tab">
                    <div class="content">
                        {include file="layout/error_box.tpl"}
                        {if $MLM_PLAN == "Binary"}
                        <legend>
                            <span class="fieldset-legend">
                                {lang('binary_settings')}
                            </span>
                        </legend>
                        <div class="form-group">
                            <label class="required">{lang('pair_ceiling_type')}</label>
                            <select class="form-control" onchange="change_pair_ceiling_visibility(this.value);" name="pair_ceiling_type"  id="pair_ceiling_type">
                                <option value="none" {if $obj_arr["pair_ceiling_type"]=='none'} selected="true"{/if}>{lang('none')}</option>
                                <option value="daily" {if $obj_arr["pair_ceiling_type"]=='daily'} selected="true"{/if}>{lang('daily')}</option>
                                <option value="weekly" {if $obj_arr["pair_ceiling_type"]=='weekly'} selected="true"{/if}>{lang('weekly')}</option>
                                <option value="monthly" {if $obj_arr["pair_ceiling_type"]=='monthly'} selected="true"{/if}>{lang('monthly')}</option>
                                <option value="monthly_with_daily" {if $obj_arr["pair_ceiling_type"]=='monthly_with_daily'} selected="true"{/if}>{lang('monthly_with_daily')}</option>
                            </select>
                            {form_error('pair_ceiling_type')}
                        </div>
                        <input type="hidden" id="db_pair_commission_type" value="{$obj_arr["pair_commission_type"]}">
                        <div class="form-group" id='pair_ceiling_div' {if $obj_arr["pair_ceiling_type"] == 'none'} style="display: none;" {/if}>
                            <label class="required" id="pair_ceiling_pv_label" {if $obj_arr["pair_commission_type"] == "flat"} style="display:none;"{/if}>
                            {if $obj_arr["pair_ceiling_type"] == 'monthly_with_daily'}
                                {lang('pair_ceiling_daily_pv')}
                            {else}
                                {lang('pair_ceiling_pv')}
                            {/if}
                            </label>
                            <label class="required" id="pair_ceiling_count_label" {if $obj_arr["pair_commission_type"] == "percentage"} style="display:none;"{/if}>
                            {if $obj_arr["pair_ceiling_type"] == 'monthly_with_daily'}
                                {lang('pair_ceiling_daily_count')}
                            {else}
                                {lang('pair_ceiling_count')}
                            {/if}
                            </label>
                            <input class="form-control" type="text" name="pair_ceiling" id="pair_ceiling" value="{$obj_arr["pair_ceiling"]}" min="1">
                            {form_error('pair_ceiling')}
                        </div>
                        <div class="form-group" id='pair_ceiling_month_div' {if $obj_arr["pair_ceiling_type"] != 'monthly_with_daily'} style="display: none;" {/if}>
                            <label class="required" id="pair_ceiling_month_pv_label" {if $obj_arr["pair_commission_type"] == "flat"} style="display:none;"{/if}>
                            {lang('pair_ceiling_monthly_pv')}
                            </label>
                            <label class="required" id="pair_ceiling_month_count_label" {if $obj_arr["pair_commission_type"] == "percentage"} style="display:none;"{/if}>
                            {lang('pair_ceiling_monthly_count')}
                            </label>
                            <input class="form-control" type="text" name="pair_ceiling_monthly" id="pair_ceiling_monthly" value="{$obj_arr["pair_ceiling_monthly"]}" min="1">
                            {form_error('pair_ceiling_monthly')}
                        </div>
                        <div class="form-group" id='pair_value_div' {if $obj_arr["pair_commission_type"] == 'percentage'} style="display: none" {/if}>
                            <label class="required">{lang('pair_value')}</label>
                            <input class="form-control" type="text" name="pair_value" id="pair_value" value="{$obj_arr["pair_value"]}" maxlength="5">
                            {form_error('pair_value')}
                        </div>
                        <div class="form-group" style="display:{if $MODULE_STATUS['product_status'] == "no"} block{else} none{/if};">
                            <label class="required">{lang('product_point_value')}</label>
                            <input class="form-control" type="text" name="product_point_value" id="product_point_value" value="{$obj_arr["product_point_value"]}" min="1">
                            {form_error('product_point_value')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="binary_setting" id="binary_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                        <hr class="new_line">
                    {/if}
                    {if $MLM_PLAN == "Board"}
                        <legend>
                            <span class="fieldset-legend">
                                {if {$MODULE_STATUS['table_status']} eq 'yes'}
                                {lang('table_settings')}
                                {else}
                                {lang('board_settings')}
                                {/if}
                            </span>
                        </legend>
                        <input type="hidden" id="board_count" name="board_count" value="{$board_count}">
                        {assign var="display_status" value="block"}
                        {assign var="i" value="0"}
                        {foreach from=$obj_arr_board item=v name=boards} 
                            <div id="board{$i}" name="board{$i}" style="display: {$display_status};">
                                <div class="form-group">
                                    <label class="required">
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {sprintf(lang('board1_name'), $i + 1)}
                                        {else}
                                            {sprintf(lang('table_name'), $i + 1)}
                                        {/if}
                                    </label>
                                    <input type="text" class="no-special form-control {if {$MODULE_STATUS['table_status']} eq 'no'}board_name{else}table_name{/if}" name="board{$i}_name" id="board{$i}_name" value="{$obj_arr_board[$i]["board_name"]}" data-level="{$i+1}">
                                    {form_error("board{$i}_name")}
                                </div>
                                <div class="form-group">
                                    <label class="required">
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {sprintf(lang('board1_width'), $i + 1)}
                                        {else}
                                            {sprintf(lang('table_width'), $i + 1)}
                                        {/if}
                                    </label>
                                    <input type="text" class="no-text form-control {if {$MODULE_STATUS['table_status']} eq 'no'}board_width{else}table_width{/if}" name="board{$i}_width" id="board{$i}_width" value="{$obj_arr_board[$i]["board_width"]}" maxlength="1" onblur="set_cleanup_flag({$obj_arr_board[$i]["board_width"]}, this.value);"data-level="{$i+1}" >
                                    {form_error("board{$i}_width")}
                                </div>
                                <div class="form-group">
                                    <label class="required">
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {sprintf(lang('board1_depth'), $i + 1)}
                                        {else}
                                            {sprintf(lang('table_depth'), $i + 1)}
                                        {/if}
                                    </label>
                                    <input type="text" class="no-text form-control {if {$MODULE_STATUS['table_status']} eq 'no'}board_depth{else}table_depth{/if}" name="board{$i}_depth" id="board{$i}_depth" value="{$obj_arr_board[$i]["board_depth"]}" maxlength="1" onblur="set_cleanup_flag({$obj_arr_board[$i]["board_depth"]}, this.value);" data-level="{$i+1}">
                                    {form_error("board{$i}_depth")}
                                </div>
                                <div class="form-group">
                                    <label class="required">
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {sprintf(lang('board1_sponsor_follow_status'), $i + 1)}
                                        {else}
                                            {sprintf(lang('table_sponsor_follow_status'), $i + 1)}
                                        {/if}
                                    </label>
                                    <select class="form-control" name="board{$i}_sponsor_follow_status"  id="board{$i}_sponsor_follow_status">
                                        <option value="yes" {if $obj_arr_board[$i]["sponser_follow_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                        <option value="no" {if $obj_arr_board[$i]["sponser_follow_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required">
                                        {if {$MODULE_STATUS['table_status']} eq 'no'}
                                            {sprintf(lang('board1_reentry_status'), $i + 1)}
                                        {else}
                                            {sprintf(lang('table_reentry_status'), $i + 1)}
                                        {/if}
                                    </label>
                                    <select class="form-control" name="board{$i}_reentry_status"  id="board{$i}_reentry_status" onchange="set_cleanup_flag('{$obj_arr_board[$i]["re_entry_status"]}', this.value);">
                                        <option value="yes" {if $obj_arr_board[$i]["re_entry_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                        <option value="no" {if $obj_arr_board[$i]["re_entry_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                    </select>
                                </div>

                                {if !$smarty.foreach.boards.last}
                                    <div class="form-group">
                                        <label class="required">
                                            {if {$MODULE_STATUS['table_status']} eq 'no'}
                                                {sprintf(lang('board1_reentry_to_next_status'), $i + 1)}
                                            {else}
                                                {sprintf(lang('table_reentry_to_next_status'), $i + 1)}
                                            {/if}
                                        </label>
                                        <select class="form-control" name="board{$i}_reentry_to_next_status"  id="board{$i}_reentry_to_next_status" onchange="changeBoardVisibility(this.value, {$i});set_cleanup_flag('{$obj_arr_board[$i]["re_entry_to_next_status"]}', this.value);">
                                            <option value="yes" {if $obj_arr_board[$i]["re_entry_to_next_status"]=='yes'} selected="true"{/if}>{lang('yes')}</option>
                                            <option value="no" {if $obj_arr_board[$i]["re_entry_to_next_status"]=='no'} selected="true"{/if}>{lang('no')}</option>
                                        </select>
                                    </div>
                                {else}
                                    <input type="hidden" name="board{$i}_reentry_to_next_status" id="board{$i}_reentry_to_next_status" value="{$obj_arr_board[$i]["re_entry_to_next_status"]}">
                                {/if}

                            </div>
                            {if $obj_arr_board[$i]["re_entry_to_next_status"] eq 'no'}
                                {$display_status = 'none'}
                            {/if}
                            {$i = $i + 1}
                        {/foreach}
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="board_setting" id="board_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                        <hr class="new_line">
                    {/if}
                    {if $MLM_PLAN == "Matrix"}
                        <div class="form-group">
                            <label class="required">{lang('width_ceiling')}</label>
                            <input class="form-control" type="text" name="width_ceiling" id="width_ceiling" value="{$obj_arr["width_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["width_ceiling"]}, this.value);">
                            {form_error('width_ceiling')}
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('depth_ceiling')}</label>
                            <input class="form-control" type="text" name="depth_ceiling" id="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" >
                            {form_error('depth_ceiling')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matrix_setting" id="matrix_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                        <hr class="new_line">
                    {/if}
                    {if $MLM_PLAN !="Matrix" && ($MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes" || $MLM_PLAN == "Donation")}
                        <legend>
                            <span class="fieldset-legend">
                                {lang('level_settings')}
                            </span>
                        </legend>
                        <div class="form-group">                        
                            <label class="required">{if $MLM_PLAN=="Board"} {lang('depth_ceiling_board')} {else} {lang('depth_ceiling')} {/if}</label>
                            <input class="form-control" type="text" name="depth_ceiling" id="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" >
                            {form_error('depth_ceiling')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_setting" id="level_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                        <hr class="new_line">
                    {/if}
                    {if $MODULE_STATUS['referal_status'] == "yes" && ($MODULE_STATUS['rank_status'] == "yes" || $MODULE_STATUS['product_status'] == "yes") }
                    <legend>
                        <span class="fieldset-legend">
                            {lang('referal_income_settings')}
                        </span>
                    </legend>
                    <div class="form-group">
                        <label class="required">{lang('commission_type')}</label>
                        <select class="form-control" name="sponsor_commission_type" id="sponsor_commission_type">
                        
                        {if $MODULE_STATUS['product_status'] == "yes"}
                        {if $MODULE_STATUS['opencart_status'] == "no" && $MODULE_STATUS['opencart_status_demo'] == "no"}
                            <option value="joinee_package" {if $obj_arr["sponsor_commission_type"]=="joinee_package"}selected{/if}>{lang('joinee_package')} </option>
                        {/if}
                            <option value="sponsor_package" {if $obj_arr["sponsor_commission_type"]=="sponsor_package"}selected{/if}>{lang('sponsor_package')} </option>
                            {/if}
                            {if $MODULE_STATUS['rank_status'] == "yes"}
                            <option value="rank" {if $obj_arr["sponsor_commission_type"]=="rank"}selected{/if}>{lang('rank')} </option>
                            {/if}
                            </select> 
                            {form_error('sponsor_commission_type')} 
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="referral_setting" id="referral_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                    </div>
                    {/if}
                    {if $MLM_PLAN == 'Matrix' || $MLM_PLAN == 'Board'}
                        <p class="text-danger">
                            {lang('update_plan_confirm_msg')}
                        </p>
                    {elseif $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes" || $MLM_PLAN == "Donation"}
                        <p class="text-danger">
                            {lang('update_plan_depth_confirm_msg')}
                        </p>
                    {/if}
                    
                    {assign var="config_desc" value="_commission_plan_desc"}
                    {if $MODULE_STATUS['referal_status'] == "yes"}
                        {$const1 = lang("$MLM_PLAN$config_desc")}
                        {$const2 = lang("sponsor_commission_desc")}
                        {$const3 = "<p>{$const1}</p>{$const2}"}
                        {include file="common/notes.tpl" notes=$const3}
                    {else}                        
                        {include file="common/notes.tpl" notes=lang("$MLM_PLAN$config_desc")}
                    {/if}
                    </div>
                </div>
                <input type="radio" id="panel_commission_setting" name="tab" {if $tab2} checked {/if}> 
                <label class="tabButton" for="panel_commission_setting">{lang('commission')}</label>
                <div class="tab">
                    <div class="content">
                        {include file="layout/error_box.tpl"}
                        {if $MLM_PLAN=="Binary"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('binary_commission')}
                                </span>
                            </legend>
                            {if $obj_arr["pair_commission_type"] == "flat"}
                                {$flat = 'checked="true"'}
                                {$percent = ""}
                            {else}
                                {$flat = ""}
                                {$percent = 'checked="true"'}
                            {/if}
                            <div class="form-group">
                                <label class="required">{lang('type_of_commission')}</label>
                                <div class="radio radio-inline">
                                    <label class="i-checks i-checks-sm">
                                        <input type="radio" name="pair_commission_type" id="pair_commission_type1" value="percentage" {$percent} onchange="change_pair_value_visibility(this.value);">
                                        <i></i>
                                        {lang('percentage')}
                                    </label>
                                    <label class="i-checks i-checks-sm m-l-xs">
                                        <input type="radio" name="pair_commission_type" id="pair_commission_type2" value="flat" {$flat} onchange="change_pair_value_visibility(this.value);">
                                        <i></i>
                                        {lang('flat')}
                                    </label>
                                </div>
                            </div>
                            {if $MODULE_STATUS['product_status'] == 'no'}
                                <div class="form-group">
                                    <label class="required">{lang('pair_price')}</label>
                                    <div class="input-group {$input_group_hide}">
                                        {$left_symbol}
                                        <input class="form-control" type="text" name="pair_price" id="pair_price" value="{round($obj_arr["pair_price"],$PRECISION)}">
                                        {$right_symbol}
                                    </div>
                                    {form_error('pair_price')}
                                </div>
                            {/if}
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="binary_commission" id="binary_commission" onclick="setHiddenValue('tab2');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}

                        {if $MLM_PLAN =="Stair_Step"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('step_commission')}
                                </span>
                            </legend>
                            <div class="form-group">
                                <label class="required">{lang('override_commission')} (%)</label>
                                <input class="form-control" type="text" name="override_commission" id="override_commission" value="{round($obj_arr["override_commission"],$PRECISION)}">
                                {form_error('override_commission')}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="step_commission" id="step_commission" onclick="setHiddenValue('tab2');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        {if ($MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes") && $MLM_PLAN !="Donation"}
                            <legend>
                                <span class="fieldset-legend">
                                    {if $MODULE_STATUS['xup_status'] == "yes"} {lang('X-UP')} {/if}{lang('level_commission')}
                                </span>
                            </legend>
                            {if $obj_arr["level_commission_type"] == "flat"}
                                {$flat = 'checked="true"'}
                                {$percent = ""}
                            {else}
                                {$flat = ""}
                                {$percent = 'checked="true"'}
                            {/if}
                            <div class="form-group">
                                <label class="required control-label">{lang('type_of_commission')}</label>
                                <div class="radio radio-inline">
                                    <label class="i-checks i-checks-sm ">
                                        <input type="radio" name="level_commission_type" id="level_commission_type1" value="percentage" {$percent} onchange="change_level_commission_type(this.value);">
                                        <i></i>
                                        {lang('percentage')}
                                    </label>
                                    <label class="i-checks i-checks-sm m-l-xs">
                                        <input type="radio" name="level_commission_type" id="level_commission_type2" value="flat" {$flat} onchange="change_level_commission_type(this.value);">
                                        <i></i>
                                        {lang('flat')}
                                    </label>
                                </div>
                            </div>
                            {$level_count = count($arr_level)}
                            {assign var=level value="0"}
                            {foreach from=$arr_level item=v}  
                                {if $level < $obj_arr['depth_ceiling']}
                                    {$level = $level + 1}
                                    {$levl_perc = $v} 
                                    <div class="form-group">
                                        <label class="required">    
                                            {if $MODULE_STATUS['xup_status'] == "yes"}  {lang('X-UP')} {/if} {lang('level')} {$level} {lang('commission')}
                                            <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span>
                                        </label>
                                        <div class="input-group {$input_group_hide}">
                                            {$left_symbol}
                                            <input type="text" maxlength="5" class="level_percentage form-control" name="level_percentage{$level}" data-lang="{lang('you_must_enter')} {if $MODULE_STATUS['xup_status'] == "yes"} {lang('X-UP')} {/if} {lang('level')} {$level} {lang('commission_')}" id="level_per{$level}" min="0" {if $obj_arr["level_commission_type"] != "percentage"} value="{number_format($levl_perc*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$levl_perc}"{/if}>
                                            {$right_symbol}
                                        </div>
                                        {form_error("level_percentage{$level}")}
                                    </div>
                                {/if}
                            {/foreach}
                            <input type='hidden' name='level_count' id='level_count' value='{$level_count}'>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_commission" id="level_commission" onclick="setHiddenValue('tab2');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        {if $MLM_PLAN=="Donation"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('level_commission')}
                                </span>
                            </legend>
                            {if $obj_arr["level_commission_type"] == "flat"}
                                {$flat = 'checked="true"'}
                                {$percent = ""}
                            {else}
                                {$flat = ""}
                                {$percent = 'checked="true"'}
                            {/if}
                            <div class="form-group">
                                <label class="required">{lang('type_of_commission')}</label>
                                <div class="radio radio-inline">
                                    <label class="i-checks i-checks-sm">
                                        <input type="radio" name="level_commission_type" id="level_commission_type1" value="percentage" {$percent}>
                                        <i></i>
                                        {lang('percentage')}
                                    </label>
                                    <label class="i-checks i-checks-sm m-l-xs">
                                        <input type="radio" name="level_commission_type" id="level_commission_type2" value="flat" {$flat}>
                                        <i></i>
                                        {lang('flat')}
                                    </label>
                                </div>
                            </div>
                            {assign var=i value="0"}
                            {assign var=class value=""}
                            <table class="table table-bordered table-striped table-hover table-full-width form-horizontal" id="donation_commission">
                                <thead>
                                    <tr class="th">
                                        <th>{lang('level')}</th>
                                        {foreach from=$arr_donation_level item=v}
                                            <th>{$v.level_name}</th>
                                        {/foreach}
                                    </tr>
                                </thead>
                                <tbody>
                                {$donation_count = count($arr_donation_level)}
                                {assign var="path" value="{$BASE_URL}admin/"}
                                {foreach from=$arr_donation item=k}
                                    {if $i%2 == 0}
                                        {$class="tr2"}
                                    {else}
                                        {$class="tr1"}
                                    {/if}       
                                    {$i = $i+1}
                                    <tr class="{$class}">
                                        <td>
                                            {$k.level_no}
                                            <input type="hidden" name="level_{$k.level_no}" id="level_{$k.id}" value="{$k.level_no}" autocomplete="off" class="donation_percentage">
                                        </td>
                                        <td>
                                            <div class="input-group {$input_group_hide}">
                                                {$left_symbol}
                                                <input type="text" name="level_{$k.level_no}_donation_1" id="donation{$k.id}" value="{$k.donation_1}" autocomplete="off" class="donation_percentage form-control">
                                                {$right_symbol}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group {$input_group_hide}">
                                                {$left_symbol}
                                                <input type="text" name="level_{$k.level_no}_donation_2" id="level_{$k.level_no}_donation_2" value="{$k.donation_2}" autocomplete="off" class="donation_percentage form-control">
                                                {$right_symbol}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group {$input_group_hide}">
                                                {$left_symbol}
                                                <input type="text" name="level_{$k.level_no}_donation_3" id="level_{$k.level_no}_donation_3" value="{$k.donation_3}" autocomplete="off" class="donation_percentage form-control">
                                                {$right_symbol}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group {$input_group_hide}">
                                                {$left_symbol}
                                                <input type="text" name="level_{$k.level_no}_donation_4" id="level_{$k.level_no}_donation_4" value="{$k.donation_4}" autocomplete="off" class="donation_percentage form-control">
                                                {$right_symbol}
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                            <input type='hidden' name='donation_count' id='donation_count' value='{$donation_count}'>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="donation_level_commission" id="donation_level_commission" onclick="setHiddenValue('tab2');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        
                        {assign var="config_flat" value="_commission_commission_flat"}
                        {assign var="config_perc" value="_commission_commission_percentage"}
                        {assign var="desc" value="_commission_commission_desc3"}
                        {assign var="notes" value=""}
                        {if $MLM_PLAN!="Board" && $MLM_PLAN!="Table"}
                        {$notes="$notes<i>{lang("commission_commission_desc")}</i><br>"}
                        {$notes="$notes<b style=\"margin-left:50px;\">{lang("$MLM_PLAN$config_flat")}</b><br>"}
                        {$notes="$notes<i>{lang("commission_commission_desc2")}</i><br>"}
                        {$notes="$notes<b style=\"margin-left:50px;\">{lang("$MLM_PLAN$config_perc")}</b><br>"}
                        {/if}
                        {$notes="$notes<i>{lang("$MLM_PLAN$desc")}</i>"}
                        {include file="common/notes.tpl" notes="$notes"}
                    </div>
                </div>
            {/if}
            <!--<input type="radio" id="panel_additional_setting" name="tab" {if $tab3} checked {/if}> 
            <label class="tabButton" for="panel_additional_setting">{lang('additional')}</label>
            <div class="tab">
                <div class="content">
                    {include file="layout/error_box.tpl"}
                    {if $MODULE_STATUS['opencart_status'] == "no"}
                        <div class="form-group">
                            <label class="required">{lang('registration_amount')}</label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                                <input class="form-control" type="text" name="reg_amount" id="reg_amount" value="{round($obj_arr["reg_amount"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" maxlength="5">
                                {$right_symbol}
                            </div>
                            {form_error('reg_amount')}
                        </div>
                    {/if}
                    {if $MODULE_STATUS['referal_status']=="yes" && $MODULE_STATUS['product_status']=="no" && $MODULE_STATUS['rank_status']=="no"}
                        <div class="form-group">
                            <label class="required">{lang('referral_income')}</label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                                <input class="form-control" type="text" name="referal_amount" id="referal_amount" value="{round($obj_arr["referal_amount"],$PRECISION)}">
                                {$right_symbol}
                            </div>
                            {form_error('referal_amount')}
                        </div>
                    {/if}
                    <div class="form-group">
                        <label class="required">{lang('service_charge')} (%)</label>
                        <input class="form-control" type="text" name="service_charge" id="service" value="{round($obj_arr["service_charge"],$PRECISION)}">
                        {form_error('service_charge')}
                    </div>
                    
                    {if $MODULE_STATUS['purchase_wallet']=="yes"}
                    <div class="form-group">
                        <label class="required">{lang('purchase_wallet_commission')} (%)</label>
                        <input class="form-control" type="text" name="purchase_income_perc" id="purchase_income_perc" value="{$obj_arr["purchase_income_perc"]}">
                        {form_error('purchase_income_perc')}
                    </div>
                    {/if}

                    <div class="form-group">
                        <label class="required">{lang('transaction_fee')}</label>
                        <div class="input-group {$input_group_hide}">
                            {$left_symbol}
                            <input class="form-control" type="text" name="trans_fee"  id="trans_fee" value="{round($obj_arr["trans_fee"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" autocomplete="off" maxlength="5">
                            {$right_symbol}
                        </div>
                        {form_error('trans_fee')}
                    </div>
                    <div class="form-group">
                        <label class="required"> {lang('tds')} (%)</label>
                        <input class="form-control" type="text" name="tds" id="tds" value="{round($obj_arr["tds"],$PRECISION)}">
                        {form_error('tds')}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="setting" id="setting" onclick="setHiddenValue('tab3');">{lang('update')}</button>
                    </div>
                    {include file="common/notes.tpl" notes=lang('note_tax_transaction_fee')}
                </div>
            </div>-->
            {if $MODULE_STATUS['xup_status'] == "yes"}
            <input type="radio" id="x_up_setting" name="tab" {if $tab4} checked {/if}> 
            <label class="tabButton" for="x_up_setting">{lang('xup_level')}</label>
                <div class="tab">
                    <div class="content">
                        {include file="layout/error_box.tpl"}
                        <div class="form-group">
                            <label class="required">{lang('xup_level')}</label>
                            <input class="form-control" type="text" name="xup_level" id="xup_level" value="{$obj_arr["xup_level"]}" autocomplete="off">
                            {form_error('xup_level')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="setting" id="setting" onclick="setHiddenValue('tab4');">{lang('update')}</button>
                        </div>
                    </div>
                </div>
            {/if}
            {if DEMO_STATUS == 'yes' && $MODULE_STATUS['basic_demo_status'] == 'yes' && $is_preset_demo}
            {else}
                <input type="radio" id="panel_additional_bonus" name="tab" {if $tab5} checked {/if}> 
                <label class="tabButton" for="panel_additional_bonus">{lang('additional_bonus')}</label>
                <div class="tab">
                    <div class="content">
                        {include file="layout/error_box.tpl"}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{lang('sl_no')}</th>
                                        <th>{lang('bonus_name')}</th>
                                        <th>{lang('action')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {$i = 1}
                                        <td>{$i}</td>
                                        <td>{lang('matching_bonus')}</td>
                                        <td>
                                            <div class="form-group-button">
                                                <label class="i-switch bg-primary">
                                                    <input type="checkbox" class="additional_bonus" data-name="matching_bonus" name="matching_bonus_status" {if $matching_bonus_status == 'yes'} checked {/if}>
                                                    <i></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        {$i = $i + 1}
                                        <td>{$i}</td>
                                        <td>{lang('pool_bonus')}</td>
                                        <td>
                                            <div class="form-group-button">
                                                <label class="i-switch bg-primary">
                                                    <input type="checkbox" class="additional_bonus" data-name="pool_bonus" name="pool_bonus_status" {if $pool_bonus_status == 'yes'} checked {/if}>
                                                    <i></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        {$i = $i + 1}
                                        <td>{$i}</td>
                                        <td>{lang('fast_start_bonus')}</td>
                                        <td>
                                            <div class="form-group-button">
                                                <label class="i-switch bg-primary">
                                                    <input type="checkbox" class="additional_bonus" data-name="fast_start_bonus" name="fast_start_bonus_status" {if $fast_start_bonus_status == 'yes'} checked {/if}>
                                                    <i></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        {$i = $i + 1}
                                        <td>{$i}</td>
                                        <td>{lang('performance_bonus')}</td>
                                        <td>
                                            <div class="form-group-button">
                                                <label class="i-switch bg-primary">
                                                    <input type="checkbox" class="additional_bonus" data-name="performance_bonus" name="performance_bonus_status" {if $performance_bonus_status == 'yes'} checked {/if}>
                                                    <i></i>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {if $matching_bonus_status == "yes"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('matching_bonus')}
                                </span>
                            </legend>
                            {foreach from=$matching_bonus_config item=v key=level_no}
                                <div class="form-group">
                                    <label class="required">{lang('level_n_bonus')|sprintf:$level_no:'%s'} (%)</label>
                                    <input class="form-control matching_level" type="text" name="matching_level{$level_no}" id="matching_level{$level_no}" data-level="{$level_no}" value="{$v}">
                                    {form_error("matching_level{$level_no}")}
                                </div>
                            {/foreach}
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matching_bonus_setting" id="matching_bonus_setting" onclick="setHiddenValue('tab5');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        {if $pool_bonus_status == "yes"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('pool_bonus')}
                                </span>
                            </legend>
                            <div class="form-group">
                                <label class="required">{lang('bonus')} (%)</label>
                                <input class="form-control" type="text" name="pool_bonus" id="pool_bonus" value="{$pool_bonus_percent}">
                                {form_error("pool_bonus")}
                            </div>
                            {foreach from=$pool_bonus_config item=v key=level_no}
                                <div class="form-group">
                                    <label class="required">{lang('level_n_bonus')|sprintf:$level_no:'%s'} (%)</label>
                                    <input class="form-control pool_level" type="text" name="pool_level{$level_no}" id="pool_level{$level_no}" data-level="{$level_no}" value="{$v}">
                                    {form_error("pool_level{$level_no}")}
                                </div>
                            {/foreach}
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="pool_bonus_setting" id="pool_bonus_setting" onclick="setHiddenValue('tab5');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        {if $fast_start_bonus_status == "yes"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('fast_start_bonus')}
                                </span>
                            </legend>
                            <div class="form-group">
                                <label class="required">{lang('referral_count1')}</label>
                                <input class="form-control" type="text" name="fast_start_referral_count" id="fast_start_referral_count" value="{$fast_start_bonus_config['referral_count']}">
                                {form_error("fast_start_referral_count")}
                            </div>
                            <div class="form-group">
                                <label class="required">{lang('days_count')}</label>
                                <input class="form-control" type="text" name="fast_start_days" id="fast_start_days" value="{$fast_start_bonus_config['days_count']}">
                                {form_error("fast_start_days")}
                            </div>
                            <div class="form-group">
                                <label class="required">{lang('bonus_amount')}</label>
                                <div class="input-group {$input_group_hide}">
                                    {$left_symbol}
                                    <input class="form-control" type="text" name="fast_start_bonus" id="fast_start_bonus" value="{round($fast_start_bonus_config['bonus_amount']*$DEFAULT_CURRENCY_VALUE,$PRECISION)}">
                                    {$right_symbol}
                                </div>
                                {form_error("fast_start_bonus")}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="fast_start_bonus_setting" id="fast_start_bonus_setting" onclick="setHiddenValue('tab5');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                        {if $performance_bonus_status == "yes"}
                            <legend>
                                <span class="fieldset-legend">
                                    {lang('performance_bonus')}
                                </span>
                            </legend>
                            <div class="panel panel-default table-responsive">
                               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                                 
                                <thead>
                                    <tr class="th">
                                        <th>#</th>
                                        <th>{lang('bonus_name')}</th>
                                        <th>{lang('personal_pv')}</th>
                                        <th>{lang('group_pv')}</th>
                                        <th>{lang('bonus_percent')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {$i = 0}
                                    {foreach from=$performance_bonus_config item=v key=bonus_name}
                                        {$i = $i + 1}
                                        <tr>
                                            <td>{$i}</td>
                                            <td>{lang($bonus_name)}</td>
                                            <td>
                                                <input type="text" name="performance{$i}_personal_pv" value="{$v.personal_pv}" class="form-control performance_personal_pv">
                                                {form_error("performance{$i}_personal_pv")}
                                            </td>
                                            <td>
                                                <input type="text" name="performance{$i}_group_pv" value="{$v.group_pv}" class="form-control performance_group_pv">
                                                {form_error("performance{$i}_group_pv")}
                                            </td>
                                            <td>
                                                <input type="text" name="performance{$i}_bonus_percent" value="{$v.bonus_percent}" class="form-control performance_bonus_percent">
                                                {form_error("performance{$i}_bonus_percent")}
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="performance_bonus_setting" id="performance_bonus_setting" onclick="setHiddenValue('tab5');">{lang('update')}</button>
                            </div>
                            <hr class="new_line">
                        {/if}
                    </div>
                </div>
            {/if}
        </div>
        {form_close()}
    </div>
</div>

<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}