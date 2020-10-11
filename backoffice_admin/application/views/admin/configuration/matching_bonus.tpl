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
     <script src="{$PUBLIC_URL}javascript/validate_matching_bonus.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg16">{lang('you_must_enter_commission')}</span>
    <span id="validate_msg25">{lang('bonus_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="validate_msg31">{lang('please_enter_max_ref')}</span>
    <span id="level_n_bonus">{lang('level_n_bonus')|strtolower}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="upto_level_matching">{lang('matching_level_less_than_100')}</span>
</div>

<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('','role="form" class="" name="form_setting1" id="form_setting1"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {include file="layout/error_box.tpl"}
        <div class="form-group">
            <label class="required control-label">{lang('matching_commission_criteria')}</label>
            <select class="form-control" name="commission_criteria"  id="commission_criteria">
                <option value="genealogy" {if $active_commission == 'genealogy'} selected="true"{/if}>{lang('matching_bonus_based_on_genealogy')|strtolower|ucfirst}</option>
                {if ($MODULE_STATUS['product_status'] == "yes")}
                    <option value="member_pck" {if $active_commission == 'member_pck'} selected="true"{/if}>{lang('bonus_based_on_member_pck')}</option>
                {/if}
            </select>
            {form_error("commission_criteria")}
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('matching_commission_upto_level')}</label>
            <input type="text" maxlength="5" class="form-control" name="commission_upto_level" data-lang="{lang('you_must_enter')} {lang('matching_commission_upto_level')|strtolower|ucfirst}" id="commission_upto_level" min="0" value="{$active_level}">
            {form_error("commission_upto_level")}
        </div>
        <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matching_commission_common" id="matching_commission">{lang('update')}</button>
        </div>
        {form_close()}
        <hr class="new_line">
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
            <input type="hidden" name="active_tab" id="active_tab" value="">
            <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
            <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
            {include file="layout/error_box.tpl"}
            {if $active_commission == "genealogy"}
                <legend>
                    <span class="fieldset-legend">
                        {lang('matching_bonus_based_on_genealogy')}
                    </span>
                </legend>

                {$level_count = count($arr_level)}
                {assign var=level value="0"}
                {foreach from=$arr_level item=v}
                    {if $level < $obj_arr['depth_ceiling']}
                        {$level = $level + 1}
                        {$levl_perc = $v}
                        <div class="form-group">
                            <label class="required">
                                {lang('level')} {$level} {lang('bonus_')}
                                <span class="span_level_commission">%</span>
                            </label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                                <input type="text" maxlength="5" class="level_percentage form-control" name="level_percentage{$level}" data-lang="{lang('you_must_enter')} {lang('level')|strtolower} {$level} {lang('bonus_')|strtolower}" id="level_per{$level}" min="0" value="{number_format($levl_perc)}">
                                {$right_symbol}
                            </div>
                            {form_error("level_percentage{$level}")}
                        </div>
                    {/if}
                {/foreach}
                <input type='hidden' name='level_count' id='level_count' value='{$level_count}'>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matching_commission" id="matching_commission" >{lang('update')}</button>
                </div>
            {/if}
            {if (($MODULE_STATUS['product_status'] == "yes") || ($MODULE_STATUS['opencart_status'] == "yes" && $MODULE_STATUS['opencart_status_demo'] == "yes")) && $active_commission == "member_pck" }
                <legend>
                    <span class="fieldset-legend">
                        {lang('matching_commission_sponsor_package')}
                    </span>
                </legend>
                {$level_count = count($arr_pck)}
                {assign var=level value="0"}
                {if $level_count <=3 }
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{lang('level')}</th>
                                    {foreach from=$arr_pck item=v}
                                        <th>{$v['product_name']} <span class="span_level_commission">(%)</span></th>
                                    {/foreach}
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$arr_level_pck item=u}
                                    <tr>
                                        <td>
                                            {lang('level')} - {$u['level']}
                                        </td>
                                        {foreach from=$arr_pck item=v}
                                            <td>
                                                <div class="input-group {$input_group_hide}">
                                                    {$left_symbol}
                                                    <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_member" data-lang="{lang('you_must_enter')} {lang('level')|strtolower} {$u['level']} {$v['prod_id']} {lang('bonus_')|strtolower}" id="level_{$u['level']}_{$v['prod_id']}_member" min="0" value="{number_format($u[{"{$v['prod_id']}member"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                                    {$right_symbol}
                                                </div>
                                                {form_error("level_{$u['level']}_{$v['prod_id']}_member")}
                                            </td>
                                        {/foreach}
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                {else}
                    {foreach from=$arr_level_pck item=u}
                        <legend>
                            <span class="fieldset-legend">
                                {lang('level')}{$u['level']}
                            </span>
                        </legend>
                        {foreach from=$arr_pck item=v}
                            <div class="form-group">
                                <label class="required">
                                    {$v['product_name']}
                                    <span class="span_level_commission">(%)</span>
                                </label>
                                <div class="input-group {$input_group_hide}">
                                    {$left_symbol}
                                    <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_member" data-lang="{lang('you_must_enter')|strtolower} {lang('level')} {$u['level']} {$v['prod_id']} {lang('bonus_')|strtolower}" id="level_{$u['level']}_{$v['prod_id']}_member" min="0" value="{number_format($u[{"{$v['prod_id']}member"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                    {$right_symbol}
                                </div>
                                {form_error("level_{$u['level']}_{$v['prod_id']}_member")}
                            </div>
                        {/foreach}
                    {/foreach}
                {/if}
                <input type="hidden" name="level_count" id="level_count" value="{$level_count}">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="matching_commission" id="matching_commission">{lang('update')}</button>
                </div>
            {/if}

        {form_close()}
    </div>
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}