{extends file=$BASE_TEMPLATE} {block name=script} {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/fund_transfer_admin.js" type="text/javascript"></script>
{/block} {block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{lang('You_must_enter_user_name')}</span>
        <span id="error_msg2">{lang('NO_BALANCE')}</span>
        <span id="error_msg3">{lang('Please_type_transaction_password')}</span>
        <span id="error_msg4">{lang('Please_type_To_User_name')}</span>
        <span id="error_msg5">{lang('Please_type_Amount')}</span>
        <span id="error_msg11">{lang('you_dont_have_enough_balance')}</span>
        <span id="validate_msg1">{lang('digits_only')}</span>
        <span id="validate_msg17">{lang('please_enter_transaction_concept')}</span>
        <span id="error_name">{lang('invalid_user_name')}</span>
        <span id="error_msg12">{lang('digits_only')}</span>
        <span id="next">{lang('next')}</span>
        <span id="previous">{lang('back')}</span>
        <span id="finish">{lang('finish')}</span>
        <span id="otp_err1">{lang('you_must_enter_otp')} </span>
        <span id="otp_err2">{lang('otp_is_numeric')} </span>
    </div>
    <div class="col-md-7 col-md-offset-2 min_height">
        {form_open('/admin/post_fund_transfer','role="form" method="post" name="fund_form" id="msform"')} {include file="layout/error_box.tpl"}
        <!-- progressbar -->
        <ul id="progressbar" class="progressbar_width">
            <li class="active"></li>
            <li></li>

        </ul>
        <!-- fieldsets -->
        <fieldset id="step-1" class="position_full">
            <input type="password" autocomplete="off" style="display: none;" />
            <h2 class="fs-title"> {lang('transfer_details')}</h2>
            <div class="form-group">
                <label class="required"> {lang('user_name')} </label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" onblur="getAmountLeg();" autocomplete="Off" /> {form_error('user_name')} {form_error('user_name')}
            </div>
            <div class="form-group">
                <label class="required">{lang('transfer_to')}</label>
                <input class="form-control user_autolist" type="text" id="to_user_name" name="to_user_name" onkeypress="getAmountLeg();" autocomplete="Off" /> {form_error('to_user_name')}
                <input id="to_user_name1" name="to_user_name1" type="hidden">
            </div>
            <div class="form-group">
                <div id="user_amount_div"> </div>
            </div>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
            <div class="form-group">
                <label>{lang('amount')}</label>
                <input type="text" class="form-control" id="amount1" name="amount1"/> 
            </div> 
            {else}
            <div class="form-group">
                <label class="required"> {lang('amount')} </label>
                <div class="form-group">
                    <div class="input-group">
                        {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                        <input class="form-control" type="text" id="amount1" name="amount1" /> {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if} {form_error('amount1')}
                    </div>
                </div>
                <span id="errmsg1"></span>
            </div>
            {/if}
            <div class="form-group">
                <label class="required">{lang('transaction_note')}</label>
                <input type="text" class="form-control" id="tran_concept" name="tran_concept" /> {form_error('tran_concept')}
            </div>

            {if $MODULE_STATUS['multy_currency_status']=="no"} 
                <div class="form-group">
                    <label>{lang('transaction_fee')}</label>
                    <input class="form-control" type="text" id="tran_fee" name="tran_fee" disabled value="{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" autocomplete="Off" />
                </div> 
            {else}
                <div class="form-group">
                    <label>{lang('transaction_fee')}</label>
                    <div class="form-group">
                        <div class="input-group">
                            {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                            <input class="form-control" type="text" id="tran_fee" name="tran_fee" readonly="1" value="{round($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" autocomplete="Off" /> {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
                        </div>
                    </div>
                </div>
            {/if}
            <input type="hidden" name="path" id="path" value="{$PATH_TO_ROOT_DOMAIN}admin">
            <input type="hidden" name="tran_fees" id="tran_fees" value="{$trans_fee*$DEFAULT_CURRENCY_VALUE}">
            <input type="hidden" value="1" name="dotransfer">
            <input type="hidden" value="{$PRECISION}" id="precision">
            <input type="button" name="" id="product" class="next action-button" value="{lang('next')}" />
        </fieldset>

        <fieldset>
            <input type="hidden" value="0" name="dotransfer">
            <input type="hidden" value="f627cf15b4adbe7e689b7db8a5d09fc9" name="token">
            <h2 class="fs-title">{lang('confirm')}</h2>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
            <div class="form-group">
                <label>{lang('ewallet_balance')}</label>
                <input type="text" class="form-control" disabled="disabled" id="bal_amount" value="{number_format($bal_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" />
            </div>
            {else}
            <div class="form-group">
                <label>{lang('ewallet_balance')}</label>
                <div class="form-group">
                    <div class="input-group">
                        {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                        <input type="text" class="form-control" disabled="disabled" id="bal_amount" value="{number_format($bal_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" /> {if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
                    </div>
                </div>
            </div>
            {/if}
            <input name="from_user" type="hidden" id="from_user" class="form-control" />
            <div class="form-group">
                <label>{lang('receiver')}</label>
                <input type="text" class="form-control" id="receiver" disabled="disabled" />
                <input name="to_username" id="to_username" type="hidden" class="form-control" />
            </div>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
            <div class="form-group">
                <label>{lang('amount_to_transfer')}</label>
                <input type="text" class="form-control" id="disp_amount" name="disp_amount" disabled="disabled" />
            </div>        
            {else}
            <div class="form-group">
                <label>{lang('amount_to_transfer')}</label>
                <div class="form-group">
                    <div class="input-group">
                        {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                        <input type="text" class="form-control" id="disp_amount" name="disp_amount" disabled="disabled" />{if $DEFAULT_SYMBOL_RIGHT}
                        <span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
                    </div>
                    <input name="amount" id="amount" class="form-control" type="hidden" value="" />
                </div>
            </div>
            {/if}
            <div class="form-group">
                <label>{lang('transaction_note')}</label>
                <input type="text" class="form-control" id="transaction_not" disabled="disabled" \/>
            </div>
            {if $MODULE_STATUS['multy_currency_status']=="no"} 
            <div class="form-group">
                <label>{lang('transaction_fee')}</label>
                <input type="number" class="form-control" id="trans_fee" value="{number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" disabled="disabled" />
            </div>
            {else}
            <div class="form-group">
                <label>{lang('transaction_fee')}</label>
                <div class="form-group">
                    <div class="input-group">
                        {if $DEFAULT_SYMBOL_LEFT}<span class="input-group-addon">{$DEFAULT_SYMBOL_LEFT}</span>{/if}
                        <input type="number" class="form-control" id="trans_fee" value="{number_format($trans_fee*$DEFAULT_CURRENCY_VALUE,$PRECISION)}" disabled="disabled" />{if $DEFAULT_SYMBOL_RIGHT}<span class="input-group-addon">{$DEFAULT_SYMBOL_RIGHT}</span>{/if}
                    </div>
                </div>
            </div>
            {/if}
            <div class="form-group">
                <label class="required">{lang('transaction_password')}</label>
                <input type="password" id="pswd" class="form-control" name="pswd" data-bv-field="pswd" /> {form_error('pswd')}
                <input type="hidden" name="transaction_note" id="transaction_note" value="{$transaction_note}">
            </div>
            <input type="button" name="previous" class="previous action-button-previous" value="{lang('back')}" />
            <input type="button" id="transfer" name="transfer" class="submit action-button" value="{lang('finish')}" />
        </fieldset>
        {form_close()}
        <!-- link to designify.me code snippets -->
    </div>
    {include file="layout/otp_modal.tpl"} {/block}