{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg_user">{lang('You_must_enter_user_name')}</span>
    <span id="error_msg1">{lang('digits_only')}</span>
    <span id="error_msg2">{lang('Please_type_transaction_password')}</span>
    <span id="error_msg">{lang('you_must_select_an_amount')}</span>
    <span id="error_msg3">{lang('maximum_two_digit')}</span>
    <span id="error_name">{lang('invalid_user_name')}</span>
    <span id ="error_amount">{lang('you_must_enter_count')}</span>
</div>
 <div class="panel panel-default">
   <div class="panel-body">
     {form_open('','role="form" class="" method="post"  name="fund_form" id="fund_form"')}
      <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
      {include file="layout/error_box.tpl"}
      <div class="form-group">
        <label class="required">{lang('user_name')}</label>
        <input type="text" id="user_name" class="form-control autolist_except_admin" name="user_name"  autocomplete="Off"/>
        {form_error('user_name')}
      </div>
      <div class="form-group">
        <label class="required">{lang('amount')}</label>
        <select name="amount" class="form-control m-b" name="amount" id="amount">
          <option value="">{lang('select_amount')}</option>
          {assign var=i value=0}
            {foreach from=$amount_details item=v}
                <option value="{$v.id}">{$DEFAULT_SYMBOL_LEFT}{$v.amount*$DEFAULT_CURRENCY_VALUE}{$DEFAULT_SYMBOL_RIGHT}</option>
                {$i = $i+1}
            {/foreach}
        </select>
        {form_error('amount')}
      </div>
      <div class="form-group">
        <label class="required">{lang('epin_count')}</label>
        <input type="text" class="form-control" name="pin_count" id="pin_count" size="20" value="" title="" >
        <span id="pin_count_err"  style="color:#b94a48;"></span>
        {form_error('pin_count')}
      </div>
        <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary" name="transfer" id="transfer" value="{lang('pin_purchase')}" >{lang('pin_purchase')}</button>
      </div>
      {form_close()}
      </div>
      </div>


{/block}