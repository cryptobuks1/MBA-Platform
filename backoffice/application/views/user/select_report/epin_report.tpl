{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg">{lang('You_must_select_from_date')}</span>
        <span id="error_msg1">{lang('You_must_select_to_date')}</span>
        <span id="errmsg4">{lang('to_date_greater_than_from_date')}</span>
        <span id="error_msg2">{lang('You_must_enter_user_name')}</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('user/epin_transfer_report_view', 'role="form" class="" method="post" target="_blank" name="epin_report" id="epin_report"')}
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                </div>
            </div>
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label>{lang('user_name')}</label>
                    <input tabindex="1" type="text" class="form-control" id="user_name" name="user_name">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('from_date')}</label>
                    <input data-date-format="yyyy-mm-dd" autocomplete="off" data-date-viewmode="years" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="1" size="20" maxlength="10"  value="" >
                {if isset($error_array['week_date1'])}{$error_array['week_date1']}{/if}
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label>{lang('from_date')}</label>
                <input data-date-format="yyyy-mm-dd" autocomplete="off" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="1" size="20" maxlength="10"  value="" > 
            </div>
        {if isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
    </div>
    <div class="col-sm-3 padding_both_small">
        <div class="form-group m-t-t-t">
            <button class="btn btn-primary" tabindex="4" name="submit" id="submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
        </div>
    </div>
    {form_close()}
</div>
</div>

{/block}