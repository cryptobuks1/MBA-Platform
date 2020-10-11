{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
   <span id="error_msg3">{lang('digits_only')}</span>        
   <span id="error_msg2">{lang('Please_type_transaction_password')}</span>        
   <span id="error_msg">{lang('you_must_select_an_amount')}</span>
   <span id="error_msg1">{lang('you_must_enter_count')}</span>
</div>
<div class="panel panel-default">
   <div class="panel-body">
      {form_open('user/ewallet/ewallet_pin_purchase','role="form" class="ng-pristine ng-valid" method="post"  name="searchform" id="searchform"')}
      <div class="form-group">
         <label>{lang('your_current_bal')}</label>
         <div class="input-group m-b"> <span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>
            <input class="form-control" tabindex="1" type="text" name="balance" id="balance" size="20" value=" {number_format($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" disabled="true"/>
            {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
         </div>
      </div>
      <div class="form-group">
         <label>{lang('amount')}<font color="#ff0000">*</font></label>
         <select  class="form-control"  name="amount" id="amount" tabindex="1">
            <option value="">{lang('select_amount')}</option>
            {assign var=i value=0}
            {foreach from=$amount_details item=v}
            <option value="{$v.id}">{$DEFAULT_SYMBOL_LEFT} {number_format($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</option>
            {$i = $i+1}
            {/foreach}
         </select>
         {form_error('amount')} 
      </div>
      <div class="form-group">
         <label>{lang('epin_count')}<font color="#ff0000">*</font></label>
         <input class="form-control" tabindex="2" type="text" name="pin_count" id="pin_count" size="20" value="" title=""/>
         <span id="pin_count_err"  style="color:#f56b6b;"></span>
         {form_error('pin_count')}
      </div>
      <div class="form-group">
         <label>{lang('transaction_password')}<font color="#ff0000">*</font></label>
         <input class="form-control" tabindex="3" type="password" name="passcode" id="passcode" size="20" value="" title=""/>
         {form_error('passcode')}
      </div>
      <button type="submit" class="btn btn-sm btn-primary" name="transfer" id="transfer" value="{lang('e_pin_purchase')}" tabindex="4">{lang('e_pin_purchase')}</button>
      {form_close()}
   </div>
</div>
{/block}
{block name=script} {$smarty.block.parent}
<script>
   jQuery(document).ready(function () {
       ValidateUserEwallet.init();
   });
</script>
{/block}