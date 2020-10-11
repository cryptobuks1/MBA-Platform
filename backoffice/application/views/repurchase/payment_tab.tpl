
<div id="span_js_messages" style="display: none;">
    <span id="validate_msg9">Invalid E-pin..</span>
    <span id="validate_msg10">E-pin validated..</span>
    <span id="validate_msg11">checking_e_pin_availability</span>
    <span id="validate_msg50">Insufficient Balance</span>
    <span id="validate_msg60">Checking transaction details.</span>
    <span id="validate_msg61">Invalid transaction details</span>
    <span id="validate_msg62">Valid transaction details</span>
    <span id="validate_msg71">Duplicate E-Pin</span>
    <span id="validate_msg72">{lang('username_required')}</span>
    <span id="validate_msg73">{lang('trnxtnpwd_required')}</span>
</div>
<input type="hidden" id="pin_count" name="pin_count" value="{$pin_count}" />
<input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}" />
<input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}" />
<input type="hidden" id="total_amount" name="total_amount" value="{$cart_total_amount}" />
<input type="hidden" id="ewallet_cheking_type" name="ewallet_cheking_type" value="repurchase" />
{if $payment_methods_tab}
    {$payment_pin_status     = $payment_module_status_array['epin_type']}
    {$free_joining_status    = $payment_module_status_array['free_joining_type']}
    {$payment_ewallet_status = $payment_module_status_array['ewallet_type']} {$payment_gateway_status = $payment_module_status_array['gateway_type']}
    {$bank_transfer_status   = $payment_module_status_array['bank_transfer']}
    {$paypal_status          = $payment_gateway_array['paypal_status']}
    {$authorize_status       = $payment_gateway_array['authorize_status']}
    {$sofort_status          = $payment_gateway_array['sofort_status']}
    {$payeer_status          = $payment_gateway_array['payeer_status']}
    {$blocktrail_status      = $payment_gateway_array['bitcoin_status']}
    {$blockchain_status      = $payment_gateway_array['blockchain_status']}
    {$bitgo_status           = $payment_gateway_array['bitgo_status']}
    {$purchase_wallet_status = $MODULE_STATUS['purchase_wallet']}
    {$squareup_status        = $payment_gateway_array['squareup_status']}

    {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes" }
        {$active_tab_val="epin_tab"}
    {else if $payment_ewallet_status== 'yes' }
        {$active_tab_val="ewallet_tab"}
    {else if $purchase_wallet_status== 'yes' }
        {$active_tab_val="purchase_wallet_tab"}
    {else if $payment_gateway_status == "yes" && $paypal_status == "yes" }
        {$active_tab_val="paypal_tab"}
    {else if $payment_gateway_status == "yes" && $authorize_status == 'yes'}
        {$active_tab_val="authorize_tab"}
    {else if $payment_gateway_status == "yes" && $blocktrail_status == 'yes'}
        {$active_tab_val="blocktrail_tab"}
    {else if $payment_gateway_status == "yes" && $blockchain_status == 'yes'}
        {$active_tab_val="blockchain_tab"}
    {else if $payment_gateway_status == "yes" && $bitgo_status == 'yes'}
        {$active_tab_val="bitgo_tab"}
    {else if $payment_gateway_status == "yes" && $sofort_status == 'yes'}
        {$active_tab_val="sofort_tab"}
    {else if $payment_gateway_status == "yes" && $payeer_status == 'yes'}
        {$active_tab_val="payeer_tab"}
    {else if $payment_gateway_status == "yes" && $squareup_status == 'yes'}
        {$active_tab_val="squareup_tab"}
    {else if $bank_transfer_status == 'yes' }
        {$active_tab_val="bank_transfer"}
    {else if $free_joining_status == 'yes' }
        {$active_tab_val="free_purchase"}
    {/if}
 {/if}
<div class="col-sm-12 bhoechie-tab-container">
    <div class=" col-sm-3 bhoechie-tab-menu">
        <div class="list-group">
            {if $payment_methods_tab} {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
            <a href="#" class="list-group-item active text-center" {if $active_tab_val=='epin_tab' }class="active" {/if} onclick="changeActiveTab('epin_tab');">
                <h4 class="tabs_h4"><i class="icon-pin"></i></h4>
                {lang('epin')}
            </a>
            {/if}
            {if $payment_ewallet_status== 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='ewallet_tab' }class="active" {/if} onclick="changeActiveTab('ewallet_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="icon-wallet"></i></h4>
                <br /> {lang('ewallet')}
            </a>
            {/if}
            {if $purchase_wallet_status== 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='purchase_wallet_tab' }class="active" {/if} onclick="changeActiveTab('purchase_wallet_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-shopping-basket f-30"></i></h4>
                <br /> {lang('purchase_wallet')}
            </a>
            {/if}
            {if $bank_transfer_status == "yes" }
            <a href="#" class="list-group-item text-center {if $active_tab_val=='bank_transfer'}active{/if}" onclick="changeActiveTab('bank_transfer');">
                <h4 class="tabs_h4"><i class="fa fa-bank"></i></h4>
                    {lang('bank_transfer')}
            </a>
            {/if}
            {if $payment_gateway_status == "yes" && $paypal_status == "yes"}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='paypal_tab' }class="active" {/if} onclick="changeActiveTab('paypal_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-paypal"></i></h4>
                <br /> {lang('paypal')}
            </a>
            {/if} {if $authorize_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='authorize_tab' }class="active" {/if} onclick="changeActiveTab('authorize_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="icon-lock"></i></h4>
                <br />{lang('authorize')}
            </a>
            {/if} {if $blocktrail_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='blocktrail_tab' }class="active" {/if} onclick="changeActiveTab('bitcoin_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-btc"></i></h4>
                <br /> {lang('blocktrail')}
            </a>
            {/if} {if $blockchain_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='blockchain_tab' }class="active" {/if} onclick="changeActiveTab('blockchain_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-asterisk"></i></h4>
                <br /> {lang('blockchain')}
            </a>
            {/if} {if $bitgo_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='bitgo_tab' }class="active" {/if} onclick="changeActiveTab('bitgo_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-btc"></i></h4>
                <br /> {lang('bitgo')}
            </a>
            {/if} {if $payeer_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='payeer_tab' }class="active" {/if} onclick="changeActiveTab('payeer_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-product-hunt"></i></h4>
                <br /> {lang('payeer')}
            </a>
            {/if} {if $sofort_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='sofort_tab' }class="active" {/if} onclick="changeActiveTab('sofort_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-euro"></i></h4>
                <br /> {lang('sofort')}
            </a>
            {/if} {if $squareup_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='squareup_tab' }class="active" {/if} onclick="changeActiveTab('squareup_tab');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-square"></i></h4>
                <br /> {lang('squareup')}
            </a>
            {/if} {if $free_joining_status == 'yes'}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='free_purchase' }class="active" {/if} onclick="changeActiveTab('free_purchase');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-cog"></i></h4>
                <br /> {lang('free_purchase')}
            </a>
            {/if} {else} {$active_tab_val="free_purchase"}
            <a href="#" class="list-group-item text-center" {if $active_tab_val=='free_purchase' }class="active" {/if} onclick="changeActiveTab('free_purchase');">
                <h4 class="tabs_h4 glyphicon"><i class="fa fa-cog"></i></h4>
                <br /> {lang('free_purchase')} {/if}
        </div>
    </div>
    <div class="col-sm-9 bhoechie-tab">
        <input type="hidden" name="active_tab" id="active_tab" value="{$active_tab_val}">
        <!-- flight section -->
        {if $payment_methods_tab} {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
        <div class="bhoechie-tab-content {if $active_tab_val=='epin_tab'}active{/if}">
            <div class="content">

                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped" id="p_scents">
                        <thead>
                            <tr>
                                <th>{lang('sl_no')}</th>
                                <th>{lang('epin')}</th>
                                <th>{lang('epin_amount')}</th>
                                <th>{lang('remain_epin_amount')} </th>
                                <th>{lang('req_epin_amount')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {if $pin_count} {for $i=1 to $pin_count}
                            <tr>
                                <td>{$i}</td>
                                <td>
                                    <input type="text" name="epin{$i}" id="epin{$i}" size="20" autocomplete="Off" class="form-control rounded" onblur="check_epin_submit();" value="{$reg_post_array[" epin{$i} "]}" />
                                    <span id="pin_box_{$i}" style="display:none;"></span> {if isset($error["epin$i"])}
                                    <span class='val-error'>{$error["epin$i"]}</span>{/if}
                                </td>
                                <td>
                                    {$DEFAULT_SYMBOL_LEFT}<input type="text" name="pin_amount{$i}" id="pin_amount{$i}" size="20" autocomplete="Off" class="form-control" readonly value="{$reg_post_array[" pin_amount{$i} "]}" /> {$DEFAULT_SYMBOL_RIGHT}
                                    <span id="pin_amount_span" style="display:none;"></span>
                                </td>
                                <td>{$DEFAULT_SYMBOL_LEFT}<input type="text" name="remaining_amount{$i}" id="remaining_amount{$i}" size="20" autocomplete="Off" class="form-control" readonly value="{$reg_post_array[" remaining_amount{$i} "]}" /> {$DEFAULT_SYMBOL_RIGHT}
                                    <span id="remain_amount_span" style="display:none;"></span></td>
                                <td>{$DEFAULT_SYMBOL_LEFT}<input type="text" name="{$i}" id="balance_amount{$i}" size="19" autocomplete="Off" class="form-control" readonly value="{$reg_post_array[" balance_amount{$i} "]}" /> {$DEFAULT_SYMBOL_RIGHT}
                                    <span id="balance_amount_span" style="display:none;"></span></td>
                            </tr>
                            {/for} {else}
                            <tr>
                                <td>1</td>
                                <td>
                                    <input class="form-control epin_input" type="text" name="epin[]" autocompleautote="Off" />
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="pin_amount[]" readonly />
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="remaining_amount[]" readonly />
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="balance_amount[]" readonly />
                                </td>
                            </tr>
                            {/if}
                        </tbody>
                    </table>
                </div>
                <div class="pull-left">
                    <div class="form-group line_block">
                        <label class="bg_color_none">{lang('total_amount')}</label>
                        <input type="text" name="epin_total_amount" id="epin_total_amount" size="30" autocomplete="Off" class="form-control" readonly {if isset($reg_post_array[ "epin_total_amount"])}value="{$reg_post_array[" epin_total_amount "]}"{/if}/>
                        <span id="epin_total_amount_span" style="display:none;">
                            </span>
                    </div>
                    <div class="form-group line_block" id="validate_epin_div">
                        <input type="button" class="btn m-b-xs btn-primary validate_e_pin" id="pin_btn" name="pin_btn" value="{lang('epin_val')}" />
                    </div>
                </div>
            </div>
        </div>
        {/if}
        {if $payment_ewallet_status== 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='ewallet_tab'}active{/if}">
            <input type="text" style="display:none" />
            <input type="password" style="display:none">
            <div class="col-lg-4 form-group padding_both_small">
                <label class="required">{lang('User_Name')}</label>
                <input type="text" class="form-control" id="user_name_ewallet" name="user_name_ewallet" placeholder="{lang('User_Name')}" title="{lang('User_Name')}" class="form-control" autocomplete="false" maxlength="32">
                <span class="help-block m-b-none" id="user_name_ewallet_box" style="display:none;"></span> {if isset($error['user_name_ewallet'])}
                <span class='val-error'>{$error['user_name_ewallet']}
                                                </span>{/if}
            </div>
            <div class="col-lg-4 form-group padding_both_small">
                <label class="required">{lang('transaction_password')}</label>
                <input type="password" id="tran_pass_ewallet" name="tran_pass_ewallet" placeholder="{lang('transaction_password')}" title="{lang('transaction_password')}" class="form-control" autocomplete="false" maxlength="32">
                <span class="help-block m-b-none" id="tran_pass_ewallet_box" style="display:none;"></span> {if isset($error['tran_pass_ewallet'])}
                <span class='val-error'>{$error['tran_pass_ewallet']}
                                                </span>{/if}
            </div>
            <div class="col-lg-4 form-group padding_both_small">
            <div class="mark_paid padding_both_small">
                <button type="button" class="btn btn-primary" name="ewallet_btn" id="ewallet_btn" value="Check Availability">{lang('check_availability')}</button>
            </div>
            </div>
        </div>
        {/if}
        {if $purchase_wallet_status== 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='purchase_wallet_tab'}active{/if}">
            <input type="text" style="display:none" />
            <input type="password" style="display:none">
            <div class="col-lg-4 form-group padding_both_small">
                <label class="required">{lang('User_Name')}</label>
                <input type="text" class="form-control" id="uname_pwallet" name="uname_pwallet" placeholder="{lang('User_Name')}" title="{lang('User_Name')}" class="form-control" autocomplete="false">
                <span class="help-block m-b-none" id="uname_pwallet_box" style="display:none;"></span> {if isset($error['uname_pwallet'])}
                <span class='val-error'>{$error['uname_pwallet']}
                                                </span>{/if}
            </div>
            <div class="col-lg-4 form-group padding_both_small">
                <label class="required">{lang('transaction_password')}</label>
                <input type="password" id="tran_pass_pwallet" name="tran_pass_pwallet" placeholder="{lang('transaction_password')}" title="{lang('transaction_password')}" class="form-control" autocomplete="false" size=10>
                <span class="help-block m-b-none" id="tran_pass_pwallet_box" style="display:none;"></span> {if isset($error['tran_pass_pwallet'])}
                <span class='val-error'>{$error['tran_pass_pwallet']}
                                                </span>{/if}
            </div>
            <div class="col-lg-4 form-group padding_both_small">
            <div class="mark_paid padding_both_small">
                <button type="button" class="btn btn-primary" name="pwallet_btn" id="pwallet_btn" value="Check Availability" onclick="validate_pwallet();">{lang('check_availability')}</button>
            </div>
            </div>
        </div>
        {/if}

        <!-- Bank section -->
        {if $bank_transfer_status== 'yes'}
            {include file="payment/bank_transfer.tpl"}
        {/if}

        {if $paypal_status == "yes"}
        <div class="bhoechie-tab-content {if $active_tab_val=='paypal_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if} {if $authorize_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='authorize_tab'}active{/if}">
            <div class="content">
                <div class="content">
                    <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
                </div>
            </div>
        </div>
        {/if}{if $blocktrail_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='bitcoin_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if} {if $blockchain_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='blockchain_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{if $DEMO_STATUS == "yes"}{lang('blockchain_only_in_live')}{else}{lang('click_finish_continue')}{/if}</pre>
            </div>
        </div>
        {/if} {if $bitgo_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='bitgo_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if}{if $payeer_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='payeer_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('payeer_only_in_live')}</pre>
            </div>
        </div>
        {/if} {if $sofort_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='sofort_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('sofort_only_in_live')}</pre>
            </div>
        </div>
        {/if}{if $squareup_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='squareup_tab'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if} {if $free_joining_status == 'yes'}
        <div class="bhoechie-tab-content {if $active_tab_val=='free_purchase'}active{/if}">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if} {else}
        <div class="bhoechie-tab-content active">
            <div class="content">
                <pre class="alert alert-info">{lang('click_finish_continue')}</pre>
            </div>
        </div>
        {/if}
    </div>
</div>