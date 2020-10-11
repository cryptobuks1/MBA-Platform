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
    <span id="error_msg">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg1">{lang('You_must_select_to_date')}</span>
    <span id="errmsg4">{lang('You_must_Select_From_To_Date_Correctly')}</span>
    <span id="error_msg7">{lang('invalid_user_name')}</span>
    <span id ="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
    <span id ="error_msg5">{lang('digits_only')}</span>
</div>
 <div class="panel panel-default">
  <div class="panel-body">
    {form_open('admin/report/rank_performance_report','role="form" class="" method="post" name="user" id="searchform" target="__blank"')}
      {include file="layout/error_box.tpl"}
      <div class="col-sm-3 padding_both">
      <div class="form-group">
        <label class="required" for="user_name">{lang('user_name')}</label>
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