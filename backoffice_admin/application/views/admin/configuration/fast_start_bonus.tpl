{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_fast_start_bonus.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="validate_msg13">{lang('digit_only')}</span>
        <span id="validate_msg26">{lang('field_is_required')}</span>
        <span id="validate_msg30">{lang('digit_greater_than_0')}</span>
        <span id="lang_bonus_amount">{lang('bonus_amount')|strtolower}</span>
        <span id="lang_referral_count">{lang('referral_count1')|strtolower}</span>
        <span id="lang_days">{lang('days')|strtolower}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {* <legend><span class="fieldset-legend">{lang('fast_start_bonus')}</span></legend> *}
            {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
            {include file="layout/error_box.tpl"}
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
                <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="fast_start_bonus_setting" id="fast_start_bonus_setting" >{lang('update')}</button>
            </div>
            {form_close()}
        </div>
    </div>

{/block}
