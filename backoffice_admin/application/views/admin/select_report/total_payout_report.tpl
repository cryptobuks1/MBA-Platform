{extends file=$BASE_TEMPLATE}{block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
{/block} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_select_from_date')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('to_date_greater_than_from_date')}</span>
    <span id="error_msg2">{lang('search_member_error')}</span>
    <span id="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('total_bonus_report')}</span></legend>
        {form_open('admin/total_payout_report_view','role="form" class="" method="post" name="daily" id="daily" target="_blank"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                {* <label>{lang('user_bonus_report')}</label> *}
                <button class="btn btn-primary" name="dailydate" type="submit" value="{lang('view')}"> {lang('view')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('week_wise_bonus_report')}</span></legend>
        {form_open('admin/weekly_payout_report','role="form" class="" method="post" name="weekly_payout" id="weekly_payout" target="_blank" onsubmit="return dateValidation()"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label>{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> {if $error_count && isset($error_array['week_date1'])}{$error_array['week_date1']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label>{lang('to_date')}</label>
                <input class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {if $error_count && isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="weekdate" type="submit" value="{lang('submit')}">
                {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('member_wise_bonus_report')}</span></legend>
        {form_open('admin/member_payout_report','role="form" class="" method="post" name="user" id="user" target="__blank"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('user_name')}</label>
                <input type="text" class="form-control user_autolist" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="user_submit" type="submit" value="{lang('view')}">{lang('view')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
{/block}