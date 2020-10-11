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
    <span id="error_msg">{lang('you_must_select_an_amount')}</span>
    <span id="error_msg1">{lang('digits_only')}</span>
    <span id="error_msg2">{lang('you_must_select_a_product_name')}</span>
    <span id="error_msg3">{lang('you_must_enter_your_product_amount')}</span>
    <span id="error_msg4">{lang('please_enter_any_keyword_like_pin_number_or_pin_id')}</span>
    <span id ="error_msg6">{lang('you_must_select_a_date')}</span>
    <span id ="error_msg7">{lang('expire_date_greater_current_date')}</span>
    <span id="validate_msg">{lang('enter_digits_only')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="err_msg_count">{lang('you_must_enter_count')}</span>
    <span id ="error_msg11">{lang('maximum_two_digit')}</span>
</div>
<div style="text-align: right;" > 
<div class="button_back" style="display: inline;text-align: right">
<a href="{BASE_URL}/admin/epin/epin_management"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>Back</button></a>
</div>
<div style ="text-align: right;display: inline" class="E-pin_settings">
    <a href="{BASE_URL}/admin/configuration/pin_config" target="_blank"> <button class="btn m-b-xs btn-sm btn-info btn-addon">E-Pin Settings</button></a>
</div>  
</div>

<div class="panel panel-default">
   <div class="panel-body">
   <legend><span class="fieldset-legend">{lang('number_of_epin')} {$un_allocated_pin}</span></legend>
    {form_open('admin/add_new_epin','role="form"  id="generate_epin" name="generate_epin" method="post"')}
      {include file="layout/error_box.tpl"} 
      <div class="form-group">
        <label>{lang('amount')}<font color="#ff0000">*</font></label>
        <select name="amount1" class="form-control m-b" tabindex="1">
          <option value="">{lang('select_amount')}</option>
          {assign var=i value=0}
          {foreach from=$amount_details item=v}
          <option value="{$v.amount}">{$DEFAULT_SYMBOL_LEFT}{round($v.amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</option>
          {$i = $i+1}
          {/foreach}
        </select>
         <span class="val-error">{form_error('amount1')}</span>
      </div>
      <div class="form-group">
        <label>{lang('count')}<font color="#ff0000">*</font></label>
        <input type="text" class="form-control" name="count" id="count" size="20" value="" tabindex="2">
        <span class="val-error">{form_error('count')}</span>
      </div>
      <div class="form-group">
        <label>{lang('expiry_date')}<font color="#ff0000">*</font></label>
        <input  autocomplete="off" type="text" class="form-control date-picker" name="date" id="date" type="text" value="" tabindex="3">
        <span class="val-error">{form_error('date')}</span>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-sm btn-primary" name="addpasscode" id="addpasscode" value="{lang('add_epin')}" tabindex="4">
      </div>
    {form_close()}
  </div>
</div>
<div class="card mb-2 pink-gradient">
  <div class="card-body ">
    <div class="media">
      <figure class=" avatar-50 "> <i class="icon-notebook"></i> </figure>
      <div class="media-body">
        <h6 class="my-0">{lang('note_add_new_epin_page')}</h6>
      </div>
    </div>
  </div>
</div>
{/block}