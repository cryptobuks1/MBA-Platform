{extends file=$BASE_TEMPLATE}{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_select_from_date')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="error_msg2">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg3">{lang('You_must_select_a_date')}</span>
    <span id="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('daily_joining')}</span></legend>
        {form_open('admin/total_joining_daily','role="form" class="" method="post" name="daily" id="daily" target="__blank"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="date">{lang('date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="date" id="date" type="text" value=""> {if $error_count && isset($error_array['date'])}{$error_array['date']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="dailydate" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('weekly_joining')}</span></legend>
        {form_open('admin/total_joining_weekly','role="form" class="" method="post" name="weekly_join" id="weekly_join" target="__blank" onsubmit= "return dateValidation()"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="week_date1">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> {if $error_count_weekly && isset($error_array_weekly['week_date1'])}{$error_array_weekly['week_date1']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="required">{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {if $error_count_weekly && isset($error_array_weekly['week_date2'])}{$error_array_weekly['week_date2']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="weekdate" type="submit" value="{lang('submit')}"> {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
{/block}