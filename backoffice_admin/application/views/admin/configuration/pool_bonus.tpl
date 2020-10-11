{extends file=$BASE_TEMPLATE}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}plugins/jquery-validation/dist/additional-methods.min.js" type="text/javascript" ></script>
     <script src="{$PUBLIC_URL}javascript/validate_pool_config.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg16">{lang('you_must_enter_commission')}</span>
    <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="error_msg6">{lang('please_enter_max_ref')}</span>
    <span id="error_msg7">{sprintf(lang('field_must_be_greater_than_equal_0'), ucfirst(strtolower(lang('pool_bonus'))))}</span>
    <span id="error_msg8">{lang('sum_of_pool_perc_eligible_rank')}</span>
    <span id="error_msg9">{lang('select_atleast_one_rank')}</span>
</div>
<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {include file="layout/error_box.tpl"}
        {* <legend>
            <span class="fieldset-legend">
                {lang('pool_bonus')}
            </span>
        </legend> *}
        <div class="form-group">
            <label class="required">{lang('bonus')} (%)</label>
            <input class="form-control" type="text" name="pool_bonus" data-lang="{lang('you_must_enter')} {strtolower(lang('bonus'))}" id="pool_bonus" value="{$pool_bonus_percent}">
            {form_error("pool_bonus")}
        </div>
        <div class="form-group">
            <label class="required">{lang('eligible_ranks_for_bonus')}</label>
            {foreach from=$pool_bonus_config item=v key=level_no}
            <div class="checkbox m-b-sm">
                <label class="i-checks i-checks-sm">
                    <input type="checkbox" class="select_rank" name="pool_rank{$v.rank_id}" id="{$v.rank_id}" {if $v.pool_status=='yes'} checked {/if}  value="{$v.rank_id}" ><i></i>
                </label>
                {$v.rank_name}
            </div>
            {/foreach}
        </div>
        {foreach from=$pool_bonus_config item=v key=level_no}
            <div class="form-group {if $v.pool_status=='no'}none{/if}" id="perc_div{$v.rank_id}">
                <label class="required">{lang('pool_percentage_for')} {$v.rank_name} (%)</label>
                <input class="form-control level_percentage" type="text" name="pool_level{$v.rank_id}" id="pool_level{$v.rank_id}" data-lang="{lang('you_must_enter')} {strtolower(lang('pool_percentage_for'))} {$v.rank_name}" value="{$v.pool_bonus_perc}">
                {form_error("pool_level{$v.rank_id}")}
            </div>
        {/foreach}
        <div class="form-group">
            <label class="required control-label">{lang('calculation_period')}</label>
            <select class="form-control" name="pool_bonus_period"  id="pool_bonus_period">
                <option value="monthly" {if $obj_arr["pool_bonus_period"]=='monthly'} selected="true"{/if}>{lang('monthly')}</option>
                <option value="quarterly" {if $obj_arr["pool_bonus_period"]=='quarterly'} selected="true"{/if}>{lang('quarterly')}</option>
                <option value="half_yearly" {if $obj_arr["pool_bonus_period"]=='half_yearly'} selected="true"{/if}>{lang('half_yearly')}</option>
                <option value="yearly" {if $obj_arr["pool_bonus_period"]=='yearly'} selected="true"{/if}>{lang('yearly')}</option>
            </select>
            {form_error("pool_bonus_period")}
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('pool_bonus_calculation_criteria')}</label>
            <select class="form-control" name="pool_bonus_criteria"  id="pool_bonus_criteria">
                <option value="sales" {if $obj_arr["pool_bonus_criteria"]=='sales'} selected="true"{/if}>{lang('sales')}</option>
                <option value="sales_volume" {if $obj_arr["pool_bonus_criteria"]=='sales_volume'} selected="true"{/if}>{lang('sales_volume')}</option>
            </select>
            {form_error("pool_bonus_criteria")}
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('pool_bonus_distribution_criteria')}</label>
            <select class="form-control" name="pool_distribution_criteria"  id="pool_distribution_criteria">
                <option value="equally" {if $obj_arr["pool_distribution_criteria"]=='equally'} selected="true"{/if}>{lang('equally')}</option>
            </select>
            {form_error("pool_distribution_criteria")}
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="pool_bonus_setting" id="pool_bonus_setting">{lang('update')}</button>
        </div>
        {form_close()}
    </div>
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}