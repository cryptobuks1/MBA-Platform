{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display:none;">
    <span id="error_msg1">{lang('you_must_select_user')}</span>
    <span id="error_msg2">{lang('You_must_select_a_date')}</span>
    <span id="error_msg3">{lang('invalid_period')}</span>
    <span id="error_msg4">{lang('You_must_select_a_Todate_greaterThan_Fromdate')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
</div>

<div class="panel panel-default">
    {form_open('user/my_transfer_details','role="form" class="" name="weekly_join" id="weekly_join" action="" method="post"')}
    <div class="panel-body">
    <legend> <span class="fieldset-legend"> {lang('weekly_transfer')} </span> </legend>
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="letter_width" for="fb_count">{lang('from_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date1" id="week_date1" type="text" tabindex="1" size="70">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="letter_width" for="fb_count">{lang('to_date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date2" id="week_date2" type="text" tabindex="2" size="70">
            </div>
        </div>
        <div class="col-sm-4 padding_both_small ">
            <button class="btn btn-sm btn-primary mark_paid_1" type="submit" id="weekdate" value="profile_update" name="weekdate" tabindex="3">{lang('submit')}</button>
        </div>
    </div>
    {form_close()}
</div>
{if $weekdate || $weekly_session eq 1}

<div class=" panel-default">

        {assign var=count value=""} {assign var=i value="0"} {assign var=amount value=""} {assign var=date value=""} {assign var=amount_type value=""} {assign var=class value=""} {$count = $details_count} {*
        <h3>{lang('weekly_transfer_details')}</h3>*}
        </br>
        <div class="panel panel-default table-responsive">
        <div class="panel-body">
        <legend> <span class="fieldset-legend">{lang('weekly_transfer_details')} </span> </legend>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="sample_1">
                <thead class="table-bordered">
                    <tr class="th">
                        <th>{lang('slno')}</th>
                        {*
                        <th>{lang('user_name')}</th>*}
                        <th>{lang('transaction_id')}</th>
                        <th>{lang('amount')}</th>
                        <th>{lang('transaction_fee')}</th>
                        <th>{lang('transaction_note')}</th>
                        <th>{lang('transfer_type')}</th>
                        <th>{lang('date')}</th>

                    </tr>
                </thead>
                {if $count>0}
                <tbody>
                    {assign var="i" value=1}
                    {foreach from=$details item=v} {$amount = $v.total_amount} {$date = $v.date} {$amount_type = $v.amount_type} {$trans_fee = $v.trans_fee} {$transaction_id = $v.transaction_id} {$transaction_note = $v.transaction_note} {if $amount_type == "user_credit"}
                    {$type = "User Credit"} {else if $amount_type == "user_debit"} {$type = "User Debit"} {else if $amount_type == "admin_debit"} {$type = "Admin Debit"} {else if $amount_type == "admin_credit"} {$type = "Admin Credit"} {else if $amount_type
                    == "fsb"} {$type = "Fast Start Bonus"} {else if $amount_type == "direct_commission"} {$type = "Direct Commission"} {else if $amount_type == "binary_match"} {$type = "Binary Match Commission"} {else if $amount_type == "leg"} {$type
                    = "Binary Commission"} {else} {$type = $amount_type} {/if} {if $i%2 == 0} {$class="tr2"} {else} {$class="tr1"} {/if}
                    <tr class="{$class}">
                        <td>{$page + $i}</td>
                        {*
                        <td>{$user_name}</td>*} {if $transaction_id == "" || $transaction_id == 0}
                        <th>{lang('na')}</th>
                        {else}
                        <td>{$transaction_id}</td>
                        {/if}

                        <td align="center">{$DEFAULT_SYMBOL_LEFT} {number_format($amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                        <td align="center">{$DEFAULT_SYMBOL_LEFT} {number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{stripslashes($transaction_note)}</td>
                        <td>{$type}</td>
                        <td>{$date}</td>

                    </tr>
                    {$i = $i + 1}
                    {/foreach}
                </tbody>
                {else}
                <tbody>
                    <tr>
                        <td colspan="12" align="center">
                            <h4>{lang('no_transfer_details')}</h4>
                        </td>
                    </tr>
                </tbody>
                {/if}
            </table>{$result_per_page}
         </div>
        </div>
    </div>
</div>
{/if} {form_open('user/my_transfer_details','role="form" class="" name="daily_transfer" id="daily_transfer" action="" method="post"')}

<div class="panel panel-default">
    <div class="panel-body">
    <legend> <span class="fieldset-legend">{lang('daily_transfer')}</span> </legend>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group">
                <label class="letter_width required" for="fb_count"> {lang('date')}</label>
                <input autocomplete="off" class="form-control date-picker" name="week_date3" id="week_date3" size="70" type="text" tabindex="4">
            </div>
        </div>
        <div class="col-sm-4 padding_both_small ">
            <button class="btn btn-sm btn-primary mark_paid_1 " type="submit" name="daily" id="daily" value="profile_update" name="weekdate" tabindex="5">{lang('submit')}</button>
        </div>
    </div>
</div>
{if $daily || $daily_session eq 1}

<div class="panel-default">

        {assign var=count value=""} {assign var=i value="0"} {assign var=amount value=""} {assign var=date value=""} {assign var=amount_type value=""} {assign var=class value=""} {$count = $details_count} {*
        <h3>{lang('daily_transfer_details')}</h3>*}
        </br>
        <div class="panel panel-default">
        <div class="panel-body">
        <legend> <span class="fieldset-legend"> {lang('daily_transfer_details')}</span> </legend>
    <div class="table-responsive">
            <table class="table table-bordered table-striped" id="">
                <thead class="table-bordered">
                    <tr class="th">
                        <th>{lang('slno')}</th>
                        {*
                        <th>{lang('user_name')}</th>*}
                        <th>{lang('date')}</th>
                        <th>{lang('amount')}</th>
                        <th>{lang('transaction_fee')}</th>
                        <th>{lang('transaction_note')}</th>
                        <th>{lang('transfer_type')}</th>
                    </tr>
                </thead>
                {if $count>0}
                <tbody>
                    {assign var="i" value=1}
                    {foreach from=$details item=v} {$amount = $v.total_amount} {$date = $v.date} {$amount_type = $v.amount_type} {$trans_fee = $v.trans_fee} {$transaction_note = $v.transaction_note} {if $amount_type == "user_credit"} {$type = "User Credit"} {else if $amount_type
                    == "user_debit"} {$type = "User Debit"} {else if $amount_type == "admin_debit"} {$type = "Admin Debit"} {else if $amount_type == "admin_credit"} {$type = "Admin Credit"} {else if $amount_type == "fsb"} {$type = "Fast Start Bonus"}
                    {else if $amount_type == "direct_commission"} {$type = "Direct Commission"} {else if $amount_type == "binary_match"} {$type = "Binary Match Commission"} {else if $amount_type == "leg"} {$type = "Binary Commission"} {else} {$type =
                    $amount_type} {/if} {if $i%2 == 0} {$class="tr2"} {else} {$class="tr1"} {/if}
                    <tr class="{$class}">
                        <td>{$page + $i}</td>
                        {*
                        <td>{$user_name}</td>*}
                        <td>{$date}</td>
                        <td align="center">{$DEFAULT_SYMBOL_LEFT} {number_format($amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                        <td align="center">{$DEFAULT_SYMBOL_LEFT} {number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)} {$DEFAULT_SYMBOL_RIGHT}</td>
                        <td>{$transaction_note}</td>
                        <td>{$type}</td>
                    </tr>
                    {$i = $i + 1}
                    {/foreach}
                </tbody>
                {else}
                <tbody>
                    <tr>
                        <td colspan="12" align="center">
                            <h4>{lang('no_transfer_details')}</h4>
                        </td>
                    </tr>
                </tbody>
                {/if}
            </table>{$result_per_page}
        </div>
        </div>
    </div>
</div>

{/if} {/block} {block name=script}{$smarty.block.parent}
<script>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
</script>
{/block}