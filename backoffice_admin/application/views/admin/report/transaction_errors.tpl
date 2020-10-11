{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
   <span id="error_msg">{lang('You must select from date')}</span>
   <span id="error_msg1">{lang('You must select to date')}</span>
   <span id="error_msg2">{lang('You must select From To Date Correctly')}</span>
   <span id="error_msg3">{lang('You must select a date')}</span>
   <span id="error_msg4">{lang('You must select a TO date greater than FROM date')}</span>
   <span id="error_msg5">{lang('digits_only')}</span>
</div>
<div class="panel panel-default">
   <div class="panel-body">
      {form_open('','role="form" class="" method="post" name="weekly_join" id="weekly_join" onsubmit= "return dateValidation()"')} {include file="layout/error_box.tpl"}
      <div class="col-sm-3 padding_both">
         <div class="form-group">
            <label class="required" for="week_date1">{lang('from_date')}</label>
            <input class="form-control date-picker" name="week_date1" id="week_date1" type="text" value=""> {form_error('week_date1')}
         </div>
      </div>
      <div class="col-sm-3 padding_both_small">
         <div class="form-group">
            <label class="required">{lang('to_date')}</label>
            <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" value=""> {form_error('week_date2')}
         </div>
      </div>
      <div class="col-sm-3 padding_both_small">
         <div class="form-group credit_debit_button">
            <button class="btn btn-primary" name="weekdate" type="submit" value="{lang('submit')}"> {lang('submit')}</button>
         </div>
      </div>
      {form_close()}
   </div>
</div>
{if count($details) > 0}       

<h4>{lang('Error From')} : {lang('Payout Release')}</h4>
<div class="panel panel-default">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('transaction_error')}</span></legend>
<div class=" table-responsive">
   <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
      <thead>
         <th>{lang('sl_no')}</th>
         <th>{lang('requested_user')}</th>
         <th>{lang('requested_amount')}</th>
         <th>{lang('bitcoin_address')}</th>
         <th>{lang('error_reason')}</th>
         <th>{lang('payment_method')}</th>
         <th>{lang('date')}</th>
      </thead>
      <tbody>
         {foreach $details as $row}
         <tr>
            <td>{counter}</td>
            <td>{$row['user_name']}</td>
            <td>{$DEFAULT_SYMBOL_LEFT}{number_format($row['payout_release_amount']*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
            <td>{$row['bitcoin_address']}</td>
            <td>{$row['message']}</td>
            <td>{if $row['payment_type'] == "Bitcoin"}{lang("Blocktrail")}{else}{$row['payment_type']} {/if}</td>
            <td>{$row['date']}</td>
         </tr>
         {/foreach}
      </tbody>
   </table>
   </div>
</div>
</div>
{/if}
{if $post_status && !$details}

<div class="panel panel-default table-responsive">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('transaction_error')}</span></legend>
   <h2 align="center">
   {lang("no_data")}
   <h2>
</div>
</div>
{/if}
{/block}