{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('You_must_select_from_date')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="error_msg2">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg3">{lang('You_must_select_a_date')}</span>
    <span id="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('activate_deactivate_report_dialy')}</span></legend>
        {form_open('admin/activate_deactivate_daily','role="form" class="" method="post" name="daily" id="daily" target="_blank"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('date')}</label>
                <input type="text" class="form-control date-picker" name="date" id="date"> {if $error_count_activeInactive && isset($error_array_actveInactive['date'])}{$error_array_actveInactive['date']}{/if}
            </div>
        </div>
        <div class="padding_both_small col-sm-3">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="dailydate" type="submit" value="{lang('submit')}">
                {lang('submit')} </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('activate_deactivate_report_weekely')}</span></legend>
        {form_open('admin/activate_deactivate_report_view','role="form" class="" method="post" name="weekly_join" id="weekly_join" target="_blank"')}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('from_date')}</label>
                <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" size="20" maxlength="10" value=""> {if $error_count_activeInactive && isset($error_array_actveInactive['week_date1'])}{$error_array_actveInactive['week_date1']}{/if}
            </div>
        </div>
        <div class="padding_both_small col-sm-3">
            <div class="form-group">
                <label class="required">{lang('to_date')}</label>
                <input class="form-control date-picker" name="week_date2" id="week_date2" type="text" size="20" maxlength="10" value=""> {if $error_count_activeInactive && isset($error_array_actveInactive['week_date2'])}{$error_array_actveInactive['week_date2']}{/if}
            </div>
        </div>
        <div class="padding_both_small col-sm-3">
            <div class="form-group credit_debit_button">
                <button class="btn btn-primary" name="submit_active_deactive" type="submit" value="{lang('submit')}">
                {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
    </div>
</div>
{/block}