{extends file=$BASE_TEMPLATE}
{block name=script}
  {$smarty.block.parent}
  <script>
  $(function(){
      ValidateUser.init();
  });
  </script>
{/block}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('digits_only')}</span>
    <span id="error_msg2">{lang('you_must_enter_user_name')}</span>
    <span id ="error_msg6">{lang('you_must_select_a_date')}</span>
    <span id ="error_msg7">{lang('past_expiry_date')}</span>
    <span id ="error_msg8">{lang('select_amount')}</span>
    <span id ="error_msg9">{lang('digits_only')}</span>
    <span id ="error_msg10">{lang('expire_date_greater_current_date')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id ="error_msg11">{lang('maximum_two_digit')}</span>
    <span id="error_name">{lang('invalid_user_name')}</span>
    <span id="err_msg_count">{lang('you_must_enter_count')}</span>
</div>
 <div class="panel panel-default">
   <div class="panel-body">
     {form_open('','role="form" class="" method="post"  name="user_select_form" id="user_select_form"')}
     {include file="layout/error_box.tpl"}
      <div class="form-group">
        <label class="required">{lang('user_name')}</label>
        <input type="text" name="user_name" id="user_name" value="" onKeyUp="" class="form-control user_autolist">
      {form_error('user_name')}
      </div>
      <div class="form-group">
        <label class="required">{lang('amount')}</label>
        <select name="amount1" id="amount1" class="form-control m-b">
        <option value="">{lang('select_amount')}</option>
        {assign var=i value=0}
        {foreach from=$amount_details item=v}
            <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{round($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</option>
            {$i = $i+1}
        {/foreach}
        </select>
        {form_error('amount1')}
      </div>
      <div class="form-group">
        <label class="required">{lang('epin_count')}</label>
        <input type="text" name="count" id="count" value="" title="" class="form-control">
        <span id="count_err" style="color:#b94a48;"></span>
         {form_error('count')}
      </div>
      <div class="form-group">
        <label class="required">{lang('expiry_date')}</label>
        <input type="text"   class="form-control date-picker" name="date" id="date" type="text" tabindex="4" maxlength="10"  value="" >
        <span for="date" class="help-block">    </span>
        {form_error('date')}
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary"  name="insert" id="insert" value="{lang('submit')}" >{lang('submit')}</button>
      </div>
    {form_close()}
  </div>
</div>

{/block}