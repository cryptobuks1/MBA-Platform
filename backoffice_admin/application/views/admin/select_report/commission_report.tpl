{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">

    <span id="error_msg">{lang('you_must_select_from_date')}</span>
    <span id="error_msg1">{lang('you_must_select_to_date')}</span>
    <span id="error_msg2">{lang('you_must_select_from_to_date_correctly')}</span>
    <span id="error_msg3">{lang('you_must_select_product')}</span>
    <span id="error_msg4">{lang('you_must_select_a_to_date_greater_than_from_date')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        {form_open('admin/commission_report_view','role="form" class="" method="post" name="commision_form" id="commision_form" target="_blank" onsubmit="return validation()"')}
        <div class="col-sm-3 padding_both">
        <div class="form-group">
            <label>{lang('user_name')}</label>
            <input type="text" class="form-control user_autolist" id="user_name" name="user_name" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('from_date')}</label>
            <input dautocomplete="off" class="form-control date-picker" name="from_date" id="from_date" type="text" size="20" maxlength="10" value=""> {if $error_count && isset($error_array['from_date'])}{$error_array['from_date']}{/if}
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('to_date')}</label>
            <input autocomplete="off" class="form-control date-picker" name="to_date" id="to_date" type="text" size="20" maxlength="10" value=""> {if $error_count && isset($error_array['to_date'])}{$error_array['to_date']}{/if}
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label class="required">{lang('amount_type')}</label>
            <select multiple name="amount_type[]" id="amount_type" class="form-control">
            {foreach from=$commission_types item=v}
                <option value="{$v}">{lang($v)}</option>
            {/foreach}
            </select>
        </div>
        </div>
        <div class="form-group credit_debit_button">
            <button class="btn btn-primary" name="commision" type="submit" value="{lang('submit')}">
                {lang('submit')}</button>
        </div>
        {form_close()}
    </div>
</div>

{/block}