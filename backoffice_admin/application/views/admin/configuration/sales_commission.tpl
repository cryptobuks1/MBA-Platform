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
     <script src="{$PUBLIC_URL}javascript/validate_sales_config.js" type="text/javascript" ></script>
{/block}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;"
    <span id="validate_msg12">{lang('values_greater_than_0')}</span>
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg14">{lang('characters_only')}</span>
    <span id="update_plan_confirm_msg">{lang('update_plan_note')}</span>
    <span id="validate_msg16">{lang('you_must_enter_commission')}</span>
    <span id="validate_msg25">{lang('sales_perc_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg28">{lang('field_must_be_greater_than_0')}</span>
    <span id="validate_msg29">{lang('field_must_be_greater_than_equal_0')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="validate_msg31">{lang('please_enter_max_ref')}</span>
    <span id="level_n_bonus">{lang('level_n_bonus')|strtolower}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="upto_level_sales">{lang('distribution_level_less_than_100')}</span>
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
            <label class="required control-label">{lang('sales_commission_criteria')}</label>
            <select class="form-control" name="commission_criteria"  id="commission_criteria">
                <option value="cv" {if $active_criteria == 'cv'} selected="true"{/if}>{lang('sales_commission_cv')}</option>
                <option value="sp" {if $active_criteria == 'sp'} selected="true"{/if}>{lang('sales_commission_sales_price')}</option>
            </select>
            {form_error("commission_criteria")}
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('sales_commission_distribution')}</label>
            <select class="form-control" name="sales_type"  id="sales_type">
                <option value="genealogy" {if $active_type == 'genealogy'} selected="true"{/if}>{lang('distribution_genealogy_level')|strtolower|ucfirst}</option>
                <option value="package" {if $active_type == 'package'} selected="true"{/if}>{lang('distribution_upline_package')|strtolower|ucfirst}</option>
                <option value="rank" {if $active_type == 'rank'} selected="true"{/if}>{lang('distribution_rank')|strtolower|ucfirst}</option>
            </select>
            {form_error("sales_type")}
        </div>
        <div class="form-group">
            <label class="required control-label">{lang('distribution_upto_level')}</label>
            <input type="text" maxlength="5" class="form-control" name="commission_upto_level" data-lang="{lang('you_must_enter')} {lang('distribution_upto_level')|strtolower|ucfirst}" id="commission_upto_level" min="0" value="{$active_level}">
            {form_error("commission_upto_level")}
        </div>
        <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="sales_commission_common" id="sales_commission_common">{lang('update')}</button>
        </div>

        <hr class="new_line">
        {form_close()}
        {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
        <input type="hidden" name="project_default_symbol" id="project_default_symbol" value="{$project_default_currency['symbol_left']}">
        <input type="hidden" name="active_tab" id="active_tab" value="">
        <input type="hidden" name="cleanup_flag" id="cleanup_flag" value="0" />
        <input type="hidden" id="demo_status" value="{$DEMO_STATUS}" />
        {include file="layout/error_box.tpl"}
            {if $active_type == "genealogy"}
                <legend>
                    <span class="fieldset-legend">
                        {lang('distribution_genealogy_level')}
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
                                {lang('level')} {$level}
                                <span class="span_level_commission">%</span>
                            </label>
                            <div class="input-group {$input_group_hide}">
                                {$left_symbol}
                               <input type="text" maxlength="5" class="level_percentage form-control" name="level_percentage{$level}" data-lang="{lang('you_must_enter')} {lang('level')|strtolower} {$level} {lang('sales_perc')|strtolower}" id="level_per{$level}" min="0" value="{number_format($levl_perc)}">
                                {$right_symbol}
                            </div>
                            {form_error("level_percentage{$level}")}
                        </div>
                    {/if}
                {/foreach}
                <input type='hidden' name='level_count' id='level_count' value='{$level_count}'>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="sales_commission" id="sales_commission" >{lang('update')}</button>
                </div>
            {/if}
            {if (($MODULE_STATUS['product_status'] == "yes") || ($MODULE_STATUS['opencart_status'] == "yes" && $MODULE_STATUS['opencart_status_demo'] == "yes")) && $active_type == "package" }

                <legend>
                    <span class="fieldset-legend">
                        {lang('distribution_upline_package')}
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
                                                    <input type="text" maxlength="5" class="pck_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_sales" data-lang="{lang('you_must_enter')} {lang('level')|strtolower} {$u['level']} {$v['prod_id']} {lang('sales_perc')|strtolower}" id="level_{$u['level']}_{$v['prod_id']}_sales" min="0" value="{number_format($u[{"{$v['prod_id']}sales"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                                    {$right_symbol}
                                                </div>
                                                {form_error("level_{$u['level']}_{$v['prod_id']}_sales")}
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
                                {lang('level')} {$u['level']}
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
                                    <input type="text" maxlength="5" class="pck_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_sales" data-lang="{lang('you_must_enter')|strtolower} {lang('level')} {$u['level']} {$v['prod_id']} {lang('sales_perc')|strtolower}" id="level_{$u['level']}_{$v['prod_id']}_sales" min="0" value="{number_format($u[{"{$v['prod_id']}sales"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                    {$right_symbol}
                                </div>
                                {form_error("level_{$u['level']}_{$v['prod_id']}_sales")}
                            </div>
                        {/foreach}
                    {/foreach}
                {/if}
                <input type="hidden" name="level_count" id="level_count" value="{$level_count}">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="sales_commission" id="sales_commission">{lang('update')}</button>
                </div>
            {/if}
            {if $MODULE_STATUS['rank_status'] == "yes"  && $active_type == "rank" }

                <legend>
                    <span class="fieldset-legend">
                        {lang('distribution_rank')}
                    </span>
                </legend>
                {$level_count = count($rank_array)}
                {assign var=level value="0"}
                {if $level_count <=3 }
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{lang('level')}</th>
                                    {foreach from=$rank_array item=v}
                                        <th>{$v['rank_name']} <span class="span_level_commission">(%)</span></th>
                                    {/foreach}
                                </tr>
                            </thead>
                            <tbody>
                                {foreach from=$arr_level_rank item=u}
                                    <tr>
                                        <td>
                                            {lang('level')} - {$u['level']}
                                        </td>
                                        {foreach from=$rank_array item=v}
                                            <td>
                                                <div class="input-group {$input_group_hide}">
                                                    {$left_symbol}
                                                    <input type="text" maxlength="5" class="rank_percentage form-control" name="level_{$u['level']}_{$v['rank_id']}_rank" data-lang="{lang('you_must_enter')} {lang('level')|strtolower} {$u['level']} {$v['rank_name']} {lang('sales_perc')|strtolower}" id="level_{$u['level']}_{$v['rank_id']}_rank" min="0" value="{number_format($u[{"{$v['rank_id']}rank"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                                    {$right_symbol}
                                                </div>
                                                {form_error("level_{$u['level']}_{$v['rank_id']}_rank")}
                                            </td>
                                        {/foreach}
                                    </tr>
                                {/foreach}
                            </tbody>
                        </table>
                    </div>
                {else}
                    {foreach from=$arr_level_rank item=u}
                        <legend>
                            <span class="fieldset-legend">
                                {lang('level')} {$u['level']}
                            </span>
                        </legend>
                        {foreach from=$rank_array item=v}
                            <div class="form-group">
                                <label class="required">
                                    {$v['rank_name']}
                                    <span class="span_level_commission">(%)</span>
                                </label>
                                <div class="input-group {$input_group_hide}">
                                    {$left_symbol}
                                    <input type="text" maxlength="5" class="rank_percentage form-control" name="level_{$u['level']}_{$v['rank_id']}_rank" data-lang="{lang('you_must_enter')|strtolower} {lang('level')} {$u['level']} {$v['rank_name']} {lang('sales_perc')|strtolower}" id="level_{$u['level']}_{$v['rank_id']}_rank" min="0" value="{number_format($u[{"{$v['rank_id']}rank"}]*$DEFAULT_CURRENCY_VALUE,2)}">
                                    {$right_symbol}
                                </div>
                                {form_error("level_{$u['level']}_{$v['rank_id']}_rank")}
                            </div>
                        {/foreach}
                    {/foreach}
                {/if}
                <input type="hidden" name="level_count" id="level_count" value="{$level_count}">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="sales_commission" id="sales_commission">{lang('update')}</button>
                </div>
            {/if}
        {form_close()}
    </div>
</div>
<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_success')} </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {lang('configuration_error')} </div>

{/block}