{extends file=$BASE_TEMPLATE}
{block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
{/block}
{block name=$CONTENT_BLOCK}
 <div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('You_must_select_from_date')}</span>
    <span id="error_msg2">{lang('You_must_select_to_date')}</span>
    <span id="error_msg10">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg3">{lang('to_date_greater_than_from_date')}</span>
</div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('user/repurchase_report_view','role="form" class="" method="post" name="repurchase_report" id="repurchase_report" target="_blank"')}
            <div class="errorHandler alert alert-danger no-display">
                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
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
                <label>{lang('to_date')}</label>
                <input data-date-format="yyyy-mm-dd" autocomplete="off" data-date-viewmode="years" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="2" size="20" maxlength="10"  value="" > 
            {if isset($error_array['week_date2'])}{$error_array['week_date2']}{/if}
        </div>
    </div>
    <div class="col-sm-3 padding_both_small">
        <div class="form-group credit_debit_button">
            <button class="btn btn-primary" name="submit" id="submit" type="submit" value="{lang('submit')}" tabindex="3"> {lang('submit')} </button>
        </div>
    </div>
    {form_close()}
</div>
</div>

{/block}