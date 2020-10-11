{extends file=$BASE_TEMPLATE}
{block name=script} {$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateCommissionReport.init();
    });
</script>
{/block}
{block name=$CONTENT_BLOCK}
 <div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_select_from_date')}</span>
    <span id="error_msg1">{lang('you_must_select_to_date')}</span>
    <span id="error_msg2">{lang('you_must_select_from_to_date_correctly')}</span>
    <span id="error_msg3">{lang('you_must_select_product')}</span>
    <span id ="error_msg4">{lang('from_date_greater_than_to_date')}</span>
    <span id ="error_msg5">{lang('digits_only')}</span>
    <span id ="error_msg6">{lang('digits_dot')}</span>
</div>
 <div class="panel panel-default">
  <div class="panel-body">
    {form_open('admin/config_changes_report_view','role="form" class="" method="post"    name="commision_form" id="commision_form" target="_blank" ')}
      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label >{lang('start_date')}</label>
        <input class="form-control date-picker" name="from_date" id="from_date" type="text" size="20" maxlength="10" >
      {if isset($error_array_date['start_date'])}{$error_array_date['start_date']}{/if}
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
      <div class="form-group">
        <label >{lang('end_date')}</label>
        <input class="form-control date-picker" name="to_date" id="to_date" type="text" size="20" maxlength="10" >
      {if isset($error_array_date['end_date'])}{$error_array_date['end_date']}{/if}
      </div>
      </div>
      <div class="col-sm-3 padding_both_small">
            <div class="form-group">
        <label >{lang('ip_address')}</label>
        <input type="text" name="ip_address" id="ip_address" size="20" class="form-control">
                                <span id="ip_address_err"></span>
                                {if isset($error_array_date['ip_address'])}{$error_array_date['ip_address']}{/if}
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
      <div class="form-group credit_debit_button">
      <button class="btn btn-primary" type="submit" id="submit_date" value="submit_date" name="submit_date">
                                {lang('submit')}
                            </button>

                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
      </div>
      </div>
    {form_close()}
  </div>
</div>

{/block}