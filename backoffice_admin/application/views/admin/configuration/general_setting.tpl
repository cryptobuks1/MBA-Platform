
{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg13">{lang('digit_only')}</span>
    <span id="validate_msg20">{lang('service_charge_required')}</span>
    <span id="validate_msg21">{lang('service_charge_must_between_0_to_100')}</span>
    <span id="validate_msg22">{lang('tds_required')}</span>
    <span id="validate_msg23">{lang('tds_must_between_0_to_100')}</span>
    <span id="validate_msg24">{lang('sum_of_tds_and_service_charge_should_be_less_equal_to_100')}</span>
    <span id="validate_msg25">{lang('commission_must_be_less_than_100')}</span>
    <span id="validate_msg26">{lang('field_is_required')}</span>
    <span id="validate_msg27">{lang('field_must_be_between_0_100')}</span>
    <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
    <span id="registration_amount_required">{lang('registration_amount_required')}</span>
    <span id="trans_fee_required">{lang('trans_fee_required')}</span>
    <span id="you_must_enter">{lang('you_must_enter')}</span>
    <span id="purchase_income_perc_required">{lang('purchase_wallet_commission')|strtolower}</span>
    <span id="greater_zero">{lang('subs_count_greater_zero')}</span>
    <span id="sus_fee_greater">{lang('sus_fee_greater')}</span>
    <span id="field_req">{lang('field_req')}</span>
    <span id="upgrade_fee_req">{lang('upgrade_fee_req')}</span>
    <span id="upgrade_fee_min">{lang('upgrade_fee_min')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('general_settings')}</span></legend>
        <div class="table-responsive">

            {form_open('','role="form" class="" name="form_general_setting" id="form_general_setting"')}

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
                <label class="required">{lang('monthly_subscription_fee')}</label>
                <div class="input-group {$input_group_hide}">
                    {$left_symbol}
                    <input class="form-control" type="text" name="subs_fee"  id="subs_fee" value="{round($obj_arr["monthly_subs_fee"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" autocomplete="off" maxlength="5">
                    {$right_symbol}
                </div>
                {form_error('subs_fee')}
            </div>
            
            <div class="form-group">
                <label class="required">{lang('upgrade_fee')}</label>
                <div class="input-group {$input_group_hide}">
                    {$left_symbol}
                    <input class="form-control" type="text" name="upgrade_fee"  id="upgrade_fee" value="{round($obj_arr["upgrade_amount"]*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" autocomplete="off">
                    {$right_symbol}
                </div>
                {form_error('upgrade_fee')}
            </div>
            
            
            <div class="form-group">
                <label class="required"> {lang('subs_referral_count')} </label>
                <input class="form-control" type="text" name="subs_referal_count" id="subs_referal_count" value="{$obj_arr["subs_referal_count"]}">
                {form_error('subs_referal_count')}
            </div>

            <div class="form-group">
                <label class="required">{lang('auto_logout_after')}</label>
                <select type="text" class="form-control m-b" name="logout_time" id="logout_time">
                    <option {if $prev_time eq "180"} selected {/if} value="180">{3} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "240"} selected {/if} value="240">{4} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "300"} selected {/if} value="300">{5} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "600"} selected {/if} value="600">{10} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "900"} selected {/if} value="900">{15} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "1200"} selected {/if} value="1200">{20} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "1500"} selected {/if} value="1500">{25} {lang('n_minutes_of_inactivity')}</option>
                    <option {if $prev_time eq "1800"} selected {/if} value="1800">{30} {lang('n_minutes_of_inactivity')}</option>
                </select>
                {form_error('logout_time')}
            </div>
            {if $MODULE_STATUS['compression_status'] == "yes"}
                <div class="form-group">
                    <div class="checkbox">
                    <label class="i-checks">
                        <input type="checkbox" name="compression_commission" {if $signup_config['general_signup_config']['compression_commission'] == 'yes'} checked {/if}><i></i> {lang('enable_dynamic_compression')}
                    </label>
                    </div>
                </div>
            {/if}

            <div class="form-group">
                <div class="checkbox">
                  <label class="i-checks">
                    <input type="checkbox" name="skip_blocked_users_commission" {if $obj_arr['skip_blocked_users_commission'] == 'yes'} checked {/if}><i></i> {lang('skip_blocked_users_commission')}
                  </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="setting" id="setting">{lang('update')}</button>
            </div>
            {include file="common/notes.tpl" notes=lang('note_tax_transaction_fee')}

            {form_close()}

        </div>
    </div>
</div>

{/block}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name='script'}
    {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/general_settings.js"></script>
{/block}