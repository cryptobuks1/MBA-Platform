{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <style>
        .help-block {
            color: #a94442;
        }
    </style>
    <div id="span_js_messages" style="display: none;">
        <span id="error_msg1">{lang('you_must_enter_transaction_password')}</span>
        <span id="error_msg2">{lang('transaction_password_atleast_8_characters_long')}</span>
        <span id="error_msg3">{lang('you_must_enter_payout_amount')}</span>
        <span id="error_msg4">{lang('payout_amount_must_be_greater_than_0')}</span>
        <span id="error_msg5">{lang('payout_amount_must_be_an_integer')}</span>
        <!--edited for cancel waiting withrawal-->
        <span id="show_msg1">{lang('are_you_sure_you_want_to_cancel_There_is_NO_undo')}</span>
        <!--edited for cancel waiting withrawal ends-->
        <span id="show_msg2">{lang('digits_only')}</span>
    </div> 
    <div class="panel panel-default">
        <div class="panel-body">

            {form_open('user/payout/post_payout_release_request','role="form" class="" method="post"  name="payout_request" id="payout_request" ')}

            <div class="col-md-12 padding_both">
                <div id="req-err" class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i>  {lang('errors_check')}   
                </div>
            </div>

            {* <div class="col-sm-3 padding_both">*}
            <div class="form-group">
                <label class="control-label required" for="company">{lang('withdraw_amount')}</label>

                <div class="input-group" style="width: 245px;">
                    {if $DEFAULT_SYMBOL_LEFT}
                        <span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>
                    {/if}
                    <input class="form-control" type="text" name="payout_amount" id="payout_amount" value="{round($balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"  autocomplete="Off" >
                    {if $DEFAULT_SYMBOL_RIGHT}
                        <span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>
                    {/if}
                </div>
                <span id="errmsg1"></span>
                {form_error('payout_amount')}
            </div>
            {* </div>*}
           {* <div class="col-sm-3">*}
            <div class="form-group">
                <label class="control-label">{lang('payout_method')}</label>
                <div class="input-group" style="width: 245px;">
                    <select class="form-control input-sm form-control w-sm inline v-middle" name="payment_method">
                        
                        {*<option value="bank" selected="selected">{lang('bank')}</option>*}
                        {if count($payout_method) >0}
                            
                            {foreach from=$payout_method item="v"}
                                <option  value="{$v.gateway_name}">
                                    {$v.gateway_name}</option>
                                {/foreach}
                           
                            {/if}
                    </select>
                </div>
               
            </div>
               
            {*</div>*}

            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label" for="company">{lang('transaction_password')}<span class="symbol required"></span></label>

                    <input class="form-control" type="password" name="transation_password" id="transation_password" value=""  placeholder={lang('transaction_password')} autocomplete="Off" >
                    {form_error('transation_password')}
                </div>
            </div>

            <div class="col-sm-3 padding_both_small">

                <a href="change_passcode/forgot"  class="btn btn-sm btn-primary mark_paid_1">{lang('forgot_password')}</a>

            </div>
            {*  <div class="col-sm-3 padding_both_small">
         
            <label class="control-label">{lang('payout_method')}</label>
        
            <select class="form-control input-sm form-control w-sm inline v-middle" name="payment_method">
            <option value="" selected="selected">{lang('select_option')}</option>
            <option value="bank">{lang('bank')}</option>
            {if count($payout_method) >0}
            {foreach from=$payout_method item="v"}
            <option  value="{$v.gateway_name}">
            {$v.gateway_name}</option>
            {/foreach}
            {/if}
            </select>
           
            </div>*}
           
            
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <!--edited for cancel waiting withrawal--> 
                {assign var="path" value="{$BASE_URL}user/"}
                <!--edited for cancel waiting withrawal ends-->
                <thead class="table-bordered">
                    <tr class="th">
                        <th>{lang('particulars')}</th>
                        <th>{lang('amount')}</th>
                    </tr>
                </thead>
                <tr>
                    <td>{lang('ewallet_balance')}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($balance_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr> 
                <tr>
                    <td>{lang('ewallet_amount_already_in_payout_process')}</td>
                    <td>
                        {$DEFAULT_SYMBOL_LEFT}{number_format($req_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}

                        <!--edited for cancel waiting withrawal-->
                        {if $req_amount  > '0'}
                            <a href = "javascript:cancel_withdrawal('{$path}')" class="pull-right h4" title="{lang('cancel')}" data-original-title="{lang('cancel')}"><i class="fa fa-close text-primary" style=" color: red;"></i> 
                            </a>
                        {/if}
                        <!--edited for cancel waiting withrawal ends-->
                    </td>
                </tr> 
                <tr>
                    <td>{lang('total_paid_amount')}</td>
                    <td>
                        {$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
                    </td>
                </tr> 
                <tr>
                   <!-- <td>{*{lang('preffered_payout_method')}*}</td>
                    <td>
                    {*{if $pa{}yout_method == "bank"}
                    Bank
                    {elseif $payout_method == "Bitcoin"}
                    Blocktrail
                    {else}
                    {$payout_method}
                    {/if}*}
                </td>
            </tr>
            <tr>-->
                    <td>{lang('minimum_withdrawal_amount')}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($min_payout*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td>{lang('maximum_withdrawal_amount')}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($max_payout*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td>{lang('available_maximum_withdrawal_amount')}</td>
                    <td>{$DEFAULT_SYMBOL_LEFT}{number_format($available_max_payout*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                </tr>
                <tr>
                    <td>{lang('payout_request_validity')}{lang('(days)')}</td>
                    <td>{$config_details['payout_request_validity']}</td>
                </tr>

            </table>


            <div class="form-group">
                <button class="btn btn-sm btn-primary" name="payout_request_submit" id="payout_request_submit" value="Send Request">
                    {lang('withdraw')}
                </button>
            </div>
            {form_close()}             

        </div>
    </div>

{/block}
{block name=script}{$smarty.block.parent} 
    <script>
        jQuery(document).ready(function () {
            ValidateUser.init();
        });
    </script>
{/block}