
{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="validate_msg15">{lang('Digit limit is five')}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="depth_ceiling_required">{lang('depth_ceiling_required')}</span>
    <span id="width_ceiling_required">{lang('width_ceiling_required')}</span>
    <span id="board1_name">{lang('board1_name')|strtolower}</span>
    <span id="board1_width">{lang('board1_width')|strtolower}</span>
    <span id="board1_depth">{lang('board1_depth')|strtolower}</span>
    <span id="table_name">{lang('table_name')|strtolower}</span>
    <span id="table_width">{lang('table_width')|strtolower}</span>
    <span id="table_depth">{lang('table_depth')|strtolower}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="pnt_val">{lang('point_value')}</span>
    <span id="pr_val">{lang('pair_value')}</span>
    <span id="fl_lmt">{lang('flush_out_limit')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            {form_open('','role="form" class="" name="plan_setting" id="plan_setting"')}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
            <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
                {include file="layout/error_box.tpl"}
                    {* {if $MLM_PLAN == "Binary"}
                        <legend><span class="fieldset-legend">{lang('binary_settings')}</span></legend>
                        <input type="hidden" id="product_status" value="{$MODULE_STATUS['product_status']}">
                        <div class="form-group">
                            <label class="required">{lang('calculation_criteria')}</label>
                            <select class="form-control" name="calculation_criteria" id="calculation_criteria">
                                {if $MODULE_STATUS['product_status']=='yes'}
                                <option value="sales_volume" {if $binary_bonus_config['calculation_criteria']=='sales_volume'} selected {/if}>{lang('binary_bonus_based_sales_volume')}</option>
                                <option value="sales_price" {if $binary_bonus_config['calculation_criteria']=='sales_price'} selected {/if}>{lang('binary_bonus_based_sales_price')}</option>
                                {else}
                                    <option value="fixed">{lang('binary_bonus_based_point_value')}</option>
                                {/if}
                            </select>
                            {form_error('calculation_criteria')}
                        </div>
                        {if $MODULE_STATUS['product_status']=='no'}
                        <div class="form-group">
                            <label class="required">{lang('point_value')}</label>
                            <input class="form-control" name="point_value" id="point_value" value="{$binary_bonus_config['point_value']}" maxlength="5">
                            {form_error('point_value')}
                        </div>
                        {/if}
                        <div class="form-group">
                            <label class="required">{lang('calculation_period')}</label>
                            <select class="form-control" name="calculation_period" id="calculation_period">
                                <option value="instant" {if $binary_bonus_config['calculation_period']=='instant'} selected {/if}>{lang('instant')}</option>
                                <option value="daily" {if $binary_bonus_config['calculation_period']=='daily'} selected {/if}>{lang('daily')}</option>
                                <option value="weekly" {if $binary_bonus_config['calculation_period']=='weekly'} selected {/if}>{lang('weekly')}</option>
                                <option value="monthly" {if $binary_bonus_config['calculation_period']=='monthly'} selected {/if}>{lang('monthly')}</option>
                            </select>
                            {form_error('calculation_period')}
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('pair_type')}</label>
                            <select class="form-control" name="pair_type" id="pair_type">
                                <option value="11" {if $binary_bonus_config['pair_type']=='11'} selected {/if}>{lang('pair_11')}</option>
                                <option value="21" {if $binary_bonus_config['pair_type']=='21'} selected {/if}>{lang('pair_21')}</option>
                            </select>
                            {form_error('pair_type')}
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('commission_type')}</label>
                            <select class="form-control" name="commission_type" id="commission_type">
                                <option value="flat" {if $binary_bonus_config['commission_type']=='flat'} selected {/if}>{lang('flat')}</option>
                                <option value="percentage" {if $binary_bonus_config['commission_type']=='percentage'} selected {/if}>{lang('percentage')}</option>
                            </select>
                            {form_error('commission_type')}
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('pair_value')}</label>
                            <input class="form-control" name="pair_value" id="pair_value" value="{$binary_bonus_config['pair_value']}" maxlength="5">
                            {form_error('pair_value')}
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                            <label class="i-checks">
                                <input type="checkbox" name="carry_forward" id="carry_forward" value="yes" {if $binary_bonus_config['carry_forward']=='yes'} checked {/if}><i></i> {lang('enable_carry_forward')}
                            </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                            <label class="i-checks">
                                <input type="checkbox" name="flush_out" id="flush_out" {if $binary_bonus_config['flush_out']=='yes'} checked {/if}><i></i> {lang('enable_flush_out')}
                            </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('max_pair_for_flush_out')}</label>
                            <input class="form-control" name="flush_out_limit" id="flush_out_limit" value="{$binary_bonus_config['flush_out_limit']}" maxlength="5">
                            {form_error('flush_out_limit')}
                        </div>
                        <div class="form-group">
                            <label class="required">{lang('flush_out_period')}</label>
                            <select class="form-control" name="flush_out_period" id="flush_out_period">
                                <option value="daily" {if $binary_bonus_config['flush_out_period']=='daily'} selected {/if}>{lang('daily')}</option>
                                <option value="weekly" {if $binary_bonus_config['flush_out_period']=='weekly'} selected {/if}>{lang('weekly')}</option>
                                <option value="monthly" {if $binary_bonus_config['flush_out_period']=='monthly'} selected {/if}>{lang('monthly')}</option>
                            </select>
                            {form_error('flush_out_period')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="binary_bonus_setting" id="binary_bonus_setting" >{lang('update')}</button>
                        </div>
                        <hr class="new_line">
                    {/if} *}
                    {if $MLM_PLAN != "Matrix"}
                        {* <legend><span class="fieldset-legend">{lang('sponsor_tree_settings')}</span></legend> *}
                    {else}
                        {* <legend><span class="fieldset-legend">{lang('genealogy_tree_settings')}</span></legend> *}
                    {/if}
                    {if $MLM_PLAN == "Matrix"}
                        <legend><span class="fieldset-legend">{lang('genealogy_tree_settings')}</span></legend>
                        <div class="form-group">
                            <label class="required">{lang('width_ceiling')}</label>
                            <input class="form-control" type="text" name="width_ceiling" id="width_ceiling" value="{$obj_arr["width_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["width_ceiling"]}, this.value);">
                            {form_error('width_ceiling')}
                        </div>
                        {* <div class="form-group">
                            <label class="required">{lang('max_depth_downlines')}</label>
                            <input class="form-control" type="text" name="depth_ceiling" id="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" >
                            {form_error('depth_ceiling')}
                        </div> *}
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matrix_setting" id="matrix_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                    {/if}

                    {* {if $MLM_PLAN !="Matrix" && ($MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes" || $MLM_PLAN == "Donation")}
                        <div class="form-group">
                            <label class="required">{lang('max_depth_downlines')}</label>
                            <input class="form-control" type="text" name="depth_ceiling" id="depth_ceiling" value="{$obj_arr["depth_ceiling"]}" maxlength="2" onblur="set_cleanup_flag({$obj_arr["depth_ceiling"]}, this.value);" >
                            {form_error('depth_ceiling')}
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_setting" id="level_setting" onclick="setHiddenValue('tab1');">{lang('update')}</button>
                        </div>
                    {/if} *}

                    {if $MLM_PLAN == "Board"}
                     {* <hr class="new_line"> *}
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
                            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="board_setting" id="board_setting" >{lang('update')}</button>
                        </div>

                    {/if}

                    {if $MLM_PLAN == 'Matrix'}
                        <p class="text-danger">
                            {lang('matrix_cleanup_msg')}
                        </p>
                    {elseif $MLM_PLAN == 'Board'}
                        {if $MODULE_STATUS['table_status'] == 'yes'}
                            <p class="text-danger">
                            {lang('table_cleanup_msg')}
                            </p>
                        {else}
                            <p class="text-danger">
                                {lang('board_cleanup_msg')}
                            </p>
                        {/if}
                    {/if}
            {form_close()}
        </div>
    </div>
</div>

<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name='script'}
     {$smarty.block.parent}
         <script src="{$PUBLIC_URL}javascript/plan_settings.js"></script>
         <script src="{$PUBLIC_URL}javascript/validate_binary_bonus.js"></script>
{/block}