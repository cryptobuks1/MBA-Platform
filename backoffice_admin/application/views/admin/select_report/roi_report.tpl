{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('You_must_select_from_date')}</span>
        <span id="error_msg2">{lang('You_must_select_to_date')}</span>
        <span id="error_msg10">{lang('You_must_Select_From_To_Date_Correctly')}</span>
        <span id="error_msg3">{lang('to_date_greater_than_from_date')}</span>
    </div>
    <style>
        .dropdown-menu {

            min-width: 220px;
        }
    </style>

    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('admin/roi_report_view', 'role="form" class="" method="post" name="repurchase_report" id="repurchase_report" onsubmit="return validation()"')}
            {include file="layout/error_box.tpl"}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label>{lang('user_name')}</label>
                    <input tabindex="1" type="text" class="form-control user_autolist" autocomplete="Off" id="user_name" name="user_name" size="100">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>    {lang('from_date')} </label>
                    <input  autocomplete="off"  class="form-control date-picker" type="text"  size="70" maxlength="10" name='week_date1' id='week_date1'>
                    <span>{form_error('week_date1')}</span>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('to_date')}</label>
                    <input  autocomplete="off"  class="form-control date-picker" type="text"  size="70" maxlength="10" name='week_date2' id='week_date2'>
                    <span>{form_error('week_date2')}</span>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button">
                    <button class="btn btn-primary" tabindex="4" name="submit" id="submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
{/block}
{block name=script}{$smarty.block.parent}
    <script>
        jQuery(document).ready(function () {
            ValidateUser.init();
        });
    </script>
{/block}

