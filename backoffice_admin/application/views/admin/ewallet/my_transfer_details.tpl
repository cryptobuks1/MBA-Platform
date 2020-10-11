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
    <span id="error_msg1">{lang('you_must_select_user')}</span>
    <span id="error_msg2">{lang('You_must_select_a_date')}</span>
    <span id="error_msg3">{lang('invalid_period')}</span>
    <span id="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('weekly_transfer')}</span></legend>
        {form_open('','role="form"  name="weekly_join" id="weekly_join"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
        <div class="form-group">
            <label>{lang('given_user_name')}</label>
            <input type="text" id="user_name" name="user_name" class="form-control user_autolist" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('recieved_user_name')}</label>
            <input type="text" id="recieved_user_name" name="recieved_user_name" class="form-control user_autolist" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('from_date')}</label>
            <input  autocomplete="off"  class="form-control date-picker" name="week_date1" id="week_date1" type="text" size="70" maxlength="10">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('to_date')}</label>
            <input  autocomplete="off"  class="form-control date-picker" name="week_date2" id="week_date2" type="text" size="70" maxlength="10">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary" id="weekdate" value="profile_update" name="weekdate"> {lang('submit')}</button>
        </div>
        </div>
        </div>
         
        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"> {form_close()}
    </div>
 
{if $weekdate}

<div class="panel panel-default">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('weekly_transfer')}</span></legend>
    {assign var=count value=""} {assign var=i value="0"} {assign var=amount value=""} {assign var=date value=""} {assign var=amount_type value=""} {$count = $details_count}
    <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead class="table-bordered">
            <tr class="th">
                <th>{lang('slno')}</th>
                <th>{lang('given_user_name')}</th>
                <th>{lang('recieved_user_name')}</th>
                <th>{lang('transaction_id')}</th>
                <th>{lang('amount')}</th>
                <th>{lang('transaction_fee')}</th>
                <th>{lang('transfer_type')}</th>
                <th>{lang('transaction_note')}</th>
                <th>{lang('date')}</th>
            </tr>
        </thead>
        {if $count>0}
        <tbody>
            {foreach from=$details item=v} {$amount = $v.total_amount} {$from_user_name = $v.from_user_name} {$date = $v.date} {$trans_fee = $v.trans_fee} {$amount_type = $v.amount_type} {$transaction_id = $v.transaction_id} {$transaction_note = $v.transaction_note} {$user_name = $v.user_name} {if $amount_type
            == "user_credit"} {$type = "Fund Transfer Credit"} {else if $amount_type == "user_debit"} {$type = "Fund Transfer Debit"} {else if $amount_type == "admin_debit"} {$type = "Fund Transfer Debit"} {else if $amount_type == "admin_credit"} {$type
            = "Fund Transfer Credit"} {else if $amount_type == "fsb"} {$type = "Fast Start Bonus"} {else if $amount_type == "direct_commission"} {$type = "Direct Commission"} {else if $amount_type == "binary_match"} {$type = "Binary Match Commission"}
            {else if $amount_type == "leg"} {$type = "Binary Commission"} {else} {$type = $amount_type} {/if} {$i = $i+1}
            <tr>
                <td>{counter}</td>
                <td>{$user_name}</td>
                <td>{$from_user_name}</td>
                {if $transaction_id == "" || $transaction_id == 0}
                <td>{lang('na')}</td>
                {else}
                <td>{$transaction_id}</td>
                {/if}
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$DEFAULT_SYMBOL_LEFT}{number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{$type}</td>
                <td>{$transaction_note}</td>
                <td>{$date}</td>
            </tr>
            {/foreach}
        </tbody>
        {else}
        <tbody>
            <tr>
                <td colspan="8" align="center">
                    <h4 align="center"> {lang('no_transfer_details')}</h4>
                </td>
            </tr>
        </tbody>
        {/if}
    </table>
    </div>
    </div>
</div>
{/if}

<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend">{lang('daily_transfer')}</span></legend>
        {form_open('','role="form" class="" name="daily_transfer" id="daily_transfer"')}
        <div class="col-sm-3  padding_both">
        <div class="form-group">
            <label>{lang('given_user_name')}</label>
            <input class="form-control user_autolist" type="text" id="user_name1" name="user_name1" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label>{lang('recieved_user_name')}</label>
            <input class="form-control user_autolist " type="text" id="recieved_user_name1" name="recieved_user_name1" autocomplete="Off">
        </div>
        </div>
        <div class="col-sm-3 padding_both_small">
        <div class="form-group">
            <label class="required">{lang('date')}</label>
            <input  autocomplete="off"  class="form-control date-picker" name="week_date3" id="week_date3" type="text" size="70">
        </div>
        </div>
        <div class="col-sm-3 credit_debit_button padding_both_small">
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="daily" id="daily" value="profile_update">{lang('submit')}</button>
        </div>
        </div>
        <input type="hidden" id="path_temp2" name="path_temp" value="{$PUBLIC_URL}"> {form_close()}
    </div>
</div>
{if $daily}

<div class="panel panel-default">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('daily_transfer_details')}</span></legend>
    {assign var=count value=""} {assign var=i value="0"} {assign var=amount value=""} {assign var=date value=""} {assign var=amount_type value=""} {$count = $details_count}
    <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{lang('slno')}</th>
                <th>{lang('given_user_name')}</th>
                <th>{lang('recieved_user_name')}</th>
                <th>{lang('date')}</th>
                <th>{lang('amount')}</th>
                <th>{lang('transaction_fee')}</th>
                <th>{lang('transaction_note')}</th>
                <th>{lang('transfer_type')}</th>
            </tr>
        </thead>
        {if $count>0}
        <tbody>
            {foreach from=$details item=v} {$amount = $v.total_amount} {$date = $v.date} {$amount_type = $v.amount_type} {$trans_fee = $v.trans_fee} {$transaction_note = $v.transaction_note} {$user_name = $v.user_name} {if $amount_type == "user_credit"} {$type =
            "Fund Transfer Credit"} {else if $amount_type == "user_debit"} {$type = "Fund Transfer Debit"} {else if $amount_type == "admin_debit"} {$type = "Fund Transfer Debit"} {else if $amount_type == "admin_credit"} {$type = "Fund Transfer Credit"}
            {else if $amount_type == "fsb"} {$type = "Fast Start Bonus"} {else if $amount_type == "direct_commission"} {$type = "Direct Commission"} {else if $amount_type == "binary_match"} {$type = "Binary Match Commission"} {else if $amount_type ==
            "leg"} {$type = "Binary Commission"} {else} {$type = $amount_type} {/if} {if $i%2 == 0} {$class="tr2"} {else} {$class="tr1"} {/if} {$i = $i+1}
            <tr>
                <td>{counter}</td>
                <td>{$user_name}</td>
                <td>{$v.from_user_name}</td>
                <td>{$date}</td>
                <td align="center">{$DEFAULT_SYMBOL_LEFT}{number_format($amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td align="center">{$DEFAULT_SYMBOL_LEFT}{number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                <td>{stripslashes($transaction_note)}</td>
                <td>{$type}</td>
            </tr>
            {/foreach}
        </tbody>
        {else}
        <tbody>
            <tr>
                <td colspan="8" align="center">
                    <h4 align="center"> {lang('no_transfer_details')}</h4>
                </td>
            </tr>
        </tbody>
        {/if}
    </table>
    </div>
    </div>
</div>
{/if} {/block}