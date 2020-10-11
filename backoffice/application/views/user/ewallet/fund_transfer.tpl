{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK} 
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
        <span id="error_msg2">{lang('NO_BALANCE')}</span>
        <span id="error_msg3">{lang('Please_type_transaction_password')}</span>
        <span id="error_msg4">{lang('Please_type_To_User_name')}</span>                     
        <span id="error_msg5">{lang('Please_type_Amount')}</span>
        <span id="error_msg6">{lang('NO_BALANCE')}</span>     
        <span id="validate_msg1">{lang('digits_only')}</span>
        <span id="validate_msg17">{lang('please_enter_transaction_concept')}</span>
        <span id="error_name">{lang('invalid_user_name')}</span>
        <span id="error_msg11">{lang('you_dont_have_enough_balance')}</span>
        <span id="error_msg12">{lang('digits_only')}</span>
    </div> 

    <div class="col-md-7 col-md-offset-2" style="min-height: 600px" >

        {form_open_multipart('user/ewallet/post_fund_transfer', 'role="form"  method="post" name="form" id="msform"')}

        <!-- progressbar -->
        <ul id="progressbar" class="progressbar_width">
            <li class="active"></li>
            <li></li>
        </ul>
        <!-- fieldsets -->
        <fieldset class="position_full" id="step-1">
            <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
            <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
            <h2 class="fs-title">{lang('transfer_details')}</h2>
            <div class="form-group">
                <label> {lang('transfer_to')}<span class="symbol required"></span></label>
                <input class="form-control" type="text" id="to_user_name" name="to_user_name" autocomplete="Off" /><span id="errormsg1"></span>
                {form_error('to_user_name')}
            </div>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
                <div class="form-group">
                    <label>{lang('available_amount')}</label>
                    <input class="form-control" type="text" id="avb_amount" name="avb_amount" readonly="1" value="{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"  autocomplete="Off" />
                    <input type="hidden" id="bal" name="bal"   value="{$balamount}" />
                    <input type="hidden" id="blnc" name="blnc"   value="{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" />
                </div>
            {else}
                <div class="form-group">
                    <label>{lang('available_amount')}</label>
                    <div class="form-group">
                        <div class="input-group">
                            {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                            <input class="form-control" type="text" id="avb_amount" name="avb_amount" readonly="1" value="{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"  autocomplete="Off" />
                            {*{if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}*}
                            <input type="hidden" id="bal" name="bal"   value="{$balamount}" />
                            <input type="hidden" id="blnc" name="blnc"   value="{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" />
                        </div>
                    </div>
                </div>
            {/if}
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
                <div class="form-group">
                    <label>{lang('amount')}</label>
                    <input class="form-control" type="text" id="amount1" name="amount1" />
                </div>
            {else}
                <div class="form-group">
                    <label> {lang('amount')}<span class="symbol required"></span> </label>
                    <div class="form-group">
                        <div class="input-group">
                            {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                            <input class="form-control" type="text" id="amount1" name="amount1" />
                            {*{if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}*}
                            {form_error('amount1')}
                        </div>
                    </div>
                </div>
            {/if}
            <div class="form-group">
                <label> {lang('transaction_note')}<span class="symbol required"></span></label>
                <textarea class="form-control" name="tran_concept" rows="" placeholder="" id="tran_concept" style="height: 45px; resize: none;"></textarea>
                {form_error('tran_concept')}
            </div>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
                <div class="form-group">
                    <label>{lang('transaction_fee')}</label>
                    <input class="form-control" type="text" id="trans_fee" name="trans_fee" readonly="1" value="{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"  autocomplete="Off" />
                </div>
            {else}
                <div class="form-group">
                    <label>{lang('transaction_fee')}</label>
                    <div class="form-group">
                        <div class="input-group">
                            {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                            <input class="form-control" type="text" id="trans_fee" name="trans_fee" readonly="1" value="{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"  autocomplete="Off" />
                            {* {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}*}
                        </div>
                    </div>
                </div>
            {/if}
            <input type="hidden" name="transaction_note" id="transaction_note" value="">
            <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin" >
            <input type="hidden" name="tran_fees" id="tran_fees" value="{$trans_fee*$DEFAULT_CURRENCY_VALUE}" >
            <input type="hidden" value="1" name="dotransfer"> 
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <tr>
                        <td>{lang('ewallet_balance')}</td>
                        <td class="ebal2">{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}</td>
                    </tr>
                    <tr>
                        <td>{lang('ewallet_amount already_payout_process')}</td>
                        <td class="ebal2">{round($request_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}</td>
                    </tr>
             </table>
            <input type="button" name="next" id="next" class="next action-button" value="Next"/>
        </fieldset>

        <fieldset class="position_full">
            <h2 class="fs-title">{lang('confirm')}</h2>
            <input type="hidden" value="0" name="dotransfer">
            <div class="form-group">
                <label>{lang('ewallet_balance')}</label>
                <p class="border_class" id="balnc_amt" name="balnc_amt"></p>
            </div>
            <input type="hidden" name="tot_req_amount" value="" id="tot_req_amount"/>
            <div class="form-group">
                <label>{lang('receiver')}</label>
                <input name="to_username" id="to_username" type="hidden" class="form-control" value=""/>
                <p class="border_class" id="receiver" name="to_username">{$to_user}</p>
            </div>
            <div class="form-group">
                <label>{lang('amount_to_transfer')}</label>
                <input name="amount" id ="amount" class="form-control" type="hidden" value="{round($amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}"/>
                <p class="border_class" id="disp_amount" name="disp_amount"></p>
            </div> 
            <div class="form-group">
                <label > {lang('transaction_fee')}</label>
                <input class="form-control textfixed" type= "hidden" id="transaction_fee" name="transaction_fee" value="{$DEFAULT_SYMBOL_LEFT}{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}" />{$DEFAULT_SYMBOL_LEFT}{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}
            </div>
            <div class="form-group">
                <label >{lang('transaction_password')}</label>
                <input class="form-control" type="password" id="pswd" name="pswd" />
                {form_error('pswd')}
            </div>    
             <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <tr>
                        <td>{lang('ewallet_balance')}</td>
                        <td class="ebal2">{round($balamount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}</td>
                    </tr>
                    <tr>
                        <td>{lang('ewallet_amount already_payout_process')}</td>
                        <td class="ebal2">{round($request_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}</td>
                    </tr>
             </table>
            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
            <input type="submit" class="submit action-button" id="transfer" name="transfer" value="Finish"/>
        </fieldset>


        {form_close()}
        <!-- link to designify.me code snippets -->
    </div>
      <div class="col-md-7 col-md-offset-2 min_height" style="margin-top: 10px; margin-bottom: 120px">      
      </div>
{/block}
{block name=script}{$smarty.block.parent} 
    <script src="{$PUBLIC_URL}/javascript/fund_transfer_user.js"></script>
{/block}