{$left_symbol = NULL}
{$right_symbol = NULL}
{$input_group_hide = "input-group-hide"}
{if $DEFAULT_SYMBOL_LEFT}
    {$input_group_hide = ""}
    {$left_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_LEFT</span>"}
{/if}
{if $DEFAULT_SYMBOL_RIGHT}
    {$input_group_hide = ""}
    {$right_symbol = "<span class='input-group-addon'>$DEFAULT_SYMBOL_RIGHT</span>"}
{/if}
<hr class="new_line">
{include file="layout/error_box.tpl"}
<div class="genealogy_view" id="genealogy_view">
    {if ($MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes") && $MLM_PLAN !="Donation" && $obj_arr['commission_criteria'] == "genealogy"}
        <legend>
            <span class="fieldset-legend">
                {if $MODULE_STATUS['xup_status'] == "yes"} {lang('X-UP')} {/if}{lang('commission_Based_on_Genealogy')}
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
    {/if}
    {if $MLM_PLAN=="Donation"}
        <legend>
            <span class="fieldset-legend">
                {lang('level_commission')}
            </span>
        </legend>
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
            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="donation_level_commission" id="donation_level_commission">{lang('update')}</button>
        </div>
        {/if}
</div>
<div class="reg_pck_view" id="reg_pck_view">
{if (($MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes") && $MODULE_STATUS['product_status'] == "yes") && $obj_arr['commission_criteria'] == "reg_pck"}
    <legend>
        <span class="fieldset-legend">
            {lang('level_commission_reg_package')}
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
                            <th>{$v['product_name']} <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span></th>
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
                                        <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_reg" data-lang="{lang('you_must_enter')} {lang('level')} {$u['level']} {$v['prod_id']} {lang('commission_')}" id="level_{$u['level']}_{$v['prod_id']}_reg" min="0" {if $obj_arr["level_commission_type"] != "percentage"} value="{number_format($u[{"{$v['prod_id']}reg"}]*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u[{"{$v['prod_id']}reg"}]}"{/if}>
                                        {$right_symbol}
                                    </div>
                                    {form_error("level_{$u['level']}_{$v['prod_id']}_reg")}
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
                        <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span>
                    </label>
                    <div class="input-group {$input_group_hide}">
                        {$left_symbol}
                        <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_reg" data-lang="{lang('you_must_enter')} {lang('level')} {$u['level']} {$v['prod_id']} {lang('commission_')}" id="level_{$u['level']}_{$v['prod_id']}_reg" min="0" {if $obj_arr["level_commission_type"] != "percentage"} value="{number_format($u[{"{$v['prod_id']}reg"}]*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u[{"{$v['prod_id']}reg"}]}"{/if}>
                        {$right_symbol}
                    </div>
                    {form_error("level_{$u['level']}_{$v['prod_id']}_reg")}
                </div>
            {/foreach}
        {/foreach}
    {/if}
    <input type="hidden" name="level_count" id="level_count" value="{$level_count}">
    <div class="form-group">
        <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_commission" id="level_commission" >{lang('update')}</button>
    </div>
{/if}
</div>
<div class="member_pck_view" id="member_pck_view">
{if (($MLM_PLAN=="Matrix" || $MLM_PLAN=="Unilevel" || $MODULE_STATUS['sponsor_commission_status'] == "yes") && $MODULE_STATUS['product_status'] == "yes") && $obj_arr['commission_criteria'] == "member_pck"}
    <legend>
        <span class="fieldset-legend">
            {lang('level_commission_sponsor_package')}
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
                            <th>{$v['product_name']} <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span></th>
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
                                        <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_member" data-lang="{lang('you_must_enter')} {lang('level')} {$u['level']} {$v['prod_id']} {lang('commission_')}" id="level_{$u['level']}_{$v['prod_id']}_member" min="0" {if $obj_arr["level_commission_type"] != "percentage"} value="{number_format($u[{"{$v['prod_id']}member"}]*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u[{"{$v['prod_id']}member"}]}"{/if}>
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
                        <span class="span_level_commission">{if $obj_arr["level_commission_type"] == "percentage"}%{/if}</span>
                    </label>
                    <div class="input-group {$input_group_hide}">
                        {$left_symbol}
                        <input type="text" maxlength="5" class="level_percentage form-control" name="level_{$u['level']}_{$v['prod_id']}_member" data-lang="{lang('you_must_enter')} {lang('level')} {$u['level']} {$v['prod_id']} {lang('commission_')}" id="level_{$u['level']}_{$v['prod_id']}_member" min="0" {if $obj_arr["level_commission_type"] != "percentage"} value="{number_format($u[{"{$v['prod_id']}member"}]*$DEFAULT_CURRENCY_VALUE,2)}"{else} value="{$u[{"{$v['prod_id']}member"}]}"{/if}>
                        {$right_symbol}
                    </div>
                    {form_error("level_{$u['level']}_{$v['prod_id']}_member")}
                </div>
            {/foreach}
        {/foreach}
    {/if}
    <input type="hidden" name="level_count" id="level_count" value="{$level_count}">
    <div class="form-group">
        <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="level_commission" id="level_commission">{lang('update')}</button>
    </div>
{/if}
</div>

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