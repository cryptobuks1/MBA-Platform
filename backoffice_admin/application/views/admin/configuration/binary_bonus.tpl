{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_binary_bonus.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
        <span id="validate_msg26">{lang('field_is_required')}</span>
        <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
        <span id="pnt_val">{lang('point_value')}</span>
        <span id="pr_val">{lang('pair_value')}</span>
        <span id="fl_lmt">{lang('flush_out_limit')}</span>
        <span id="pr_comm">{lang('pair_commission')}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {* <legend><span class="fieldset-legend">{lang('binary_commission')}</span></legend> *}
            {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
            {include file="layout/error_box.tpl"}
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
            {if $MODULE_STATUS['product_status']=='yes' || $MODULE_STATUS['opencart_status']=='yes'}
                {foreach from=$package_list item=pack}
                    <div class="form-group">
                        <label class="required">{lang('pair_commission')} - {$pack['product_name']}<span class="span_percent"> (%)</span></label>
                        <div class="input-group {$input_group_hide}">
                            {$left_symbol}
                            {if $binary_bonus_config['commission_type']=='flat'}
                            <input class="form-control pair-commission" name="pair_commission_{$pack['product_id']}" id="pair_commission_{$pack['product_id']}" value="{number_format($pack['pair_price'] * $DEFAULT_CURRENCY_VALUE)}" maxlength="5">
                            {else $binary_bonus_config['commission_type']=='percentage'}
                             <input class="form-control pair-commission" name="pair_commission_{$pack['product_id']}" id="pair_commission_{$pack['product_id']}" value="{number_format($pack['pair_price'])}" maxlength="5">
                             {/if}
                            {$right_symbol}
                        </div>
                        {form_error("pair_commission_{$pack['product_id']}")}
                    </div>
                {/foreach}
            {else}
                <div class="form-group">
                    <label class="required">{lang('pair_commission')}<span class="span_percent"> (%)</span></label>
                    <div class="input-group {$input_group_hide}">
                        {$left_symbol}
                        <input class="form-control pair-commission" name="pair_commission" id="pair_commission" value="{$binary_bonus_config['pair_commission']}" maxlength="5">
                        {$right_symbol}
                    </div>
                    {form_error('pair_commission')}
                </div>
            {/if}
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
            {form_close()}
        </div>
    </div>

{/block}
