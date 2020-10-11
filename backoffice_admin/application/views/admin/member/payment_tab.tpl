{form_open('admin/member/package_validity_submit', 'role="form" class="" method="post"  name="form" id="form"')}
{assign var=active_tab_val value="free_join_tab"}

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg9">{lang('invalid_e_pin')}</span>
    <span id="validate_msg10">{lang('e_pin_validated')}</span>
    <span id="validate_msg11">{lang('checking_e_pin_availability')}</span>
    <span id="validate_msg50">{lang('insuff_bal')}</span> 
    <span id="validate_msg60">{lang('checking_trans_details')}</span>
    <span id="validate_msg61">{lang('invalid_trans_details')}</span>
    <span id="validate_msg62">{lang('valid_trans_details')}</span>
    <span id="validate_msg71">{lang('duplicate_epin')}</span>
</div>
<input type="hidden" id="product_status" name="product_status" value="yes" /> 
<input type="hidden" id="mlm_plan" name="mlm_plan" value="{$mlm_plan}" /> 
<input type="hidden" id="reg_from_tree" name="reg_from_tree" value="0" /> 
<input type="hidden" id="username_type" name="username_type" value="{$username_type}" /> 
<input type="hidden" id="next_1" name="next_1" value="0" /> 
<input type="hidden" id="pin_count" name="pin_count" value="{$pin_count}" /> 
<input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}"/>
<input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}"/>
<input type="hidden" id ="total_amount" name= "total_amount"  value = "{$product_amount}" />
<input type="hidden" id ="user_id" name= "user_id"  value = "{$user_id}" />
<input type="hidden" id ="ewallet_cheking_type" name= "ewallet_cheking_type"  value = "repurchase" />
{if $payment_methods_tab}
    {$payment_pin_status = $payment_module_status_array['epin_type']}
    {$free_joining_status = $payment_module_status_array['free_joining_type']}
    {$payment_ewallet_status = $payment_module_status_array['ewallet_type']}
    {$payment_gateway_status = $payment_module_status_array['gateway_type']}
    {$paypal_status = $payment_gateway_array['paypal_status']}

    {$authorize_status = $payment_gateway_array['authorize_status']}
    {$blocktrail_status = $payment_gateway_array['bitcoin_status']}
    {$blockchain_status = $payment_gateway_array['blockchain_status']}
    {$bitgo_status = $payment_gateway_array['bitgo_status']}
    {$sofort_status = $payment_gateway_array['sofort_status']}
    {$payeer_status = $payment_gateway_array['payeer_status']}
    {$squareup_status = $payment_gateway_array['squareup_status']}

    {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes" }         
        {$active_tab_val="epin_tab"}
    {else if  $payment_ewallet_status== 'yes'  } 
        {$active_tab_val="ewallet_tab"}
    {else if $payment_gateway_status == "yes" && $paypal_status == "yes" }
        {$active_tab_val="paypal_tab"}
    {else if  $payment_gateway_status == "yes" && $authorize_status == 'yes'}
        {$active_tab_val="authorize_tab"}
    {else if  $payment_gateway_status == "yes" && $blocktrail_status == 'yes'}
        {$active_tab_val="blocktrail_tab"}
    {else if  $payment_gateway_status == "yes" && $blockchain_status == 'yes'}
        {$active_tab_val="blockchain_tab"}
    {else if  $payment_gateway_status == "yes" && $bitgo_status == 'yes'}
        {$active_tab_val="bitgo_tab"}
    {else if  $payment_gateway_status == "yes" && $sofort_status == 'yes'}
        {$active_tab_val="sofort_tab"}
    {else if  $payment_gateway_status == "yes" && $payeer_status == 'yes'}
        {$active_tab_val="payeer_tab"}
    {else if  $payment_gateway_status == "yes" && $squareup_status == 'yes'}
        {$active_tab_val="squareup_tab"}
    {else if  $free_joining_status == 'yes' }
        {$active_tab_val="free_join_tab"}
    {/if} 
{/if}    

<div class="col-sm-12 bhoechie-tab-container">
    <div class=" col-sm-3 bhoechie-tab-menu">
        {if $payment_methods_tab}
            <div class="list-group">
                {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
                    <a href="#" class="list-group-item active text-center {if $active_tab_val=='epin_tab'}active{/if}" id="epin_tab" onclick="changeActiveTab('epin_tab');">
                        <h4 class="tabs_h4"><i class="icon-pin"></i></h4>
                            {lang('epin')}
                    </a>
                {/if}
                {if $payment_ewallet_status== 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='ewallet_tab'}active{/if}" id="ewallet_tab" onclick="changeActiveTab('ewallet_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="icon-wallet"></i></h4>
                        <br/>
                        {lang('ewallet')}
                    </a>
                {/if}
                {if $payment_gateway_status == "yes" && $paypal_status == "yes"}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='paypal_tab'}active{/if}" id="paypal_tab" onclick="changeActiveTab('paypal_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-paypal"></i></h4>
                        <br/>
                        {lang('paypal')}
                    </a>
                {/if}
                {if $authorize_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='authorize_tab'}active{/if}" id="authorize_tab" onclick="changeActiveTab('authorize_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="icon-lock"></i></h4>
                        <br/>
                        {lang('authorize')}
                    </a>
                {/if}
                {if $payment_gateway_status == "yes" && $blocktrail_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='bitcoin_tab'}active{/if}" id="bitcoin_tab" onclick="changeActiveTab('bitcoin_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-btc"></i></h4>
                        <br/>
                        {lang('blocktrail')}
                    </a>
                {/if}
                {if $payment_gateway_status == "yes" && $blockchain_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='blockchain_tab'}active{/if}" id="blockchain_tab" onclick="changeActiveTab('blockchain_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-asterisk"></i></h4>
                        <br/>
                        {lang('blockchain')} 
                    </a> 
                {/if}
                {if $payment_gateway_status == "yes" && $bitgo_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='bitgo_tab'}active{/if}" id="bitgo_tab" onclick="changeActiveTab('bitgo_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-btc"></i></h4>
                        <br/>
                        {lang('bitgo')}  
                    </a> 
                {/if}
                {if $payment_gateway_status == "yes" && $payeer_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='payeer_tab'}active{/if}" id="payeer_tab" onclick="changeActiveTab('payeer_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-product-hunt"></i></h4>
                        <br/>
                        {lang('payeer')}  
                    </a> 
                {/if}
                {if $payment_gateway_status == "yes" && $sofort_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='sofort_tab'}active{/if}" id="sofort_tab" onclick="changeActiveTab('sofort_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-euro"></i></h4>
                        <br/>
                        {lang('sofort')}  
                    </a> 
                {/if}
                {if $payment_gateway_status == "yes" && $squareup_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='squareup_tab'}active{/if}" id="squareup_tab" onclick="changeActiveTab('squareup_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-square"></i></h4>
                        <br/>
                        {lang('squareup')}  
                    </a> 
                {/if}
                {if $free_joining_status == 'yes'}
                    <a href="#" class="list-group-item text-center {if $active_tab_val=='free_join_tab'}active{/if}" id="free_join_tab" onclick="changeActiveTab('free_join_tab');">
                        <h4 class="tabs_h4 glyphicon"><i class="fa fa-cog"></i></h4>
                        <br/>
                        {lang('free_purchase')}
                    </a>
                {/if}
            </div>
        {else}
            <div class="list-group">
               {$active_tab_val = "free_join_tab"} 
                <a href="#" class="list-group-item text-center {if $active_tab_val=='free_join_tab'}active{/if}" id="free_join_tab" onclick="changeActiveTab('free_join_tab');">
                    <h4 class="tabs_h4 glyphicon"><i class="fa fa-cog"></i></h4>
                    <br/>
                    {lang('free_purchase')}
                </a>
            </div>
        {/if}        
    </div>
    <div class="col-sm-9 bhoechie-tab">
        <input type="hidden" name="active_tab" id="active_tab" value="{$active_tab_val}" >
        {if $payment_methods_tab} 
            {if $payment_pin_status == "yes" && $MODULE_STATUS['pin_status'] == "yes"}
                <div class="bhoechie-tab-content {if $active_tab_val=='epin_tab'}active{/if}">
                    <div class="content">
                        <div class="panel panel-default">
                            <table class="table table-striped table-bordered table-hover table-full-width" id="p_scents">
                                <thead>
                                    <tr>
                                        <th>{lang('sl_no')}</th>
                                        <th>{lang('epin')} </th> 
                                        <th>{lang('epin_amount')}  </th>
                                        <th>{lang('remain_epin_amount')}  </th> 
                                        <th>{lang('req_epin_amount')} </th>                                    </tr>
                                </thead> 
                                <tbody>
                                    {if $pin_count}
                                        {for $i=1 to $pin_count}
                                            <tr>
                                                <td class="hidden-xs center" style="width: 26px;>{$i}</td>  
                                                    <td class=" center">
                                                    <div class="col-sm-12">
                                                        <p>
                                                            <input  style="width:120px" tabindex="55" type="text" name="epin{$i}" id="epin{$i}" size="20"   autocomplete="Off"   class="form-control" onblur="check_epin_submit();" value="{$reg_post_array["epin{$i}"]}"/>
                                                            <span id="pin_box_{$i}" style="display:none;"></span>
                                                            {if isset($error["epin$i"])}<span class='val-error' >{$error["epin$i"]}</span>{/if}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="hidden-xs center"> 
                                                    <div class="col-sm-12">
                                                        {$DEFAULT_SYMBOL_LEFT}<input tabindex="56" type="text" name="pin_amount{$i}" id="pin_amount{$i}" size="20"   autocomplete="Off"   class="form-control" readonly value="{$reg_post_array["pin_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                        <span id="pin_amount_span" style="display:none;"></span>
                                                    </div>
                                                </td>
                                                <td class="hidden-xs center">
                                                    <div class="col-sm-12">
                                                        {$DEFAULT_SYMBOL_LEFT}<input tabindex="57" type="text" name="remaining_amount{$i}" id="remaining_amount{$i}" size="20"   autocomplete="Off"   class="form-control" readonly value="{$reg_post_array["remaining_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                        <span id="remain_amount_span" style="display:none;"></span>
                                                    </div>
                                                </td>
                                                <td class="hidden-xs center">
                                                    <div class="col-sm-12">
                                                        {$DEFAULT_SYMBOL_LEFT}<input tabindex="58" type="text" name="$i}" id="balance_amount{$i}" size="19"   autocomplete="Off"   class="form-control" readonly value="{$reg_post_array["balance_amount{$i}"]}"/> {$DEFAULT_SYMBOL_RIGHT}
                                                        <span id="balance_amount_span" style="display:none;"></span>
                                                    </div>
                                                </td>
                                            </tr> 
                                        {/for}
                                    {else}
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input class="form-control epin_input" type="text" name="epin[]"  autocompleautote="Off"/>                                                    
                                            </td>
                                            <td> 
                                                <input class="form-control" type="text" name="pin_amount[]" readonly/>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="remaining_amount[]" readonly/>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="balance_amount[]" readonly/>
                                            </td>
                                        </tr>
                                    {/if}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both" >
                            <label class="control-label" for="tt">{lang('total_amount')}:</label>
                            <input tabindex="59" type="text" name="epin_total_amount" id="epin_total_amount" size="20"   autocomplete="Off"   class="form-control"  readonly {if isset($reg_post_array["epin_total_amount"])}value="{$reg_post_array["epin_total_amount"]}"{/if}/>  
                            <span id="epin_total_amount_span" style="display:none;">
                            </span>
                        </div>
                        <div class="col-sm-5 padding_both_small m-t-t-t" id="validate_epin_div" >
                            <input type="button" id ="pin_btn" name= "pin_btn" value = "{lang('epin_val')}" onclick="" tabindex="60" class="btn m-b-xs btn-primary"  />
                            <button class="btn m-b-xs btn-primary" name="epin_submit" id="epin_submit" disabled="">
                                {lang('finish')} <i class="fa fa-arrow-circle-right"></i>
                            </button>  
                        </div>
                    </div>
                    <div class="form-group" id="finButtn">
                        <div class="col-sm-2 col-sm-offset-8">
                        </div>
                    </div>  
                </div>
            {/if}
            {if $payment_ewallet_status== 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='ewallet_tab'}active{/if}">
                    <div class="content">
                        <div class="row col-sm-12">
                            <div class="col-sm-3 padding_both">
                                <div class="form-group">
                                    <label>{lang('user_name')}</label>
                                    <input type="text" class="form-control" id="user_name_ewallet" name="user_name_ewallet" placeholder="{lang('User_Name')}"  title="{lang('User_Name')}" class="form-control" autocomplete="off"/>  
                                    <span id="user_name_ewallet_box" style="display:none;"></span>
                                    {if isset($error['user_name_ewallet'])}<span class='val-error' >{$error['user_name_ewallet']} </span>{/if}
                                </div>
                            </div>
                            <div class="col-sm-3 padding_both_small" >
                                <div class="form-group">
                                    <label>{lang('transaction_password')}</label>
                                    <input type="password" class="form-control" id="tran_pass_ewallet" name="tran_pass_ewallet" placeholder="{lang('transaction_password')}"title="{lang('transaction_password')}" class="form-control" autocomplete="off"/>  
                                    <span id="tran_pass_ewallet_box" style="display:none;"></span>
                                    {if isset($error['tran_pass_ewallet'])}<span class='val-error' >{$error['tran_pass_ewallet']} </span>{/if}
                                </div>
                            </div>
                            <div class=" mark_paid col-sm-3 padding_both_small" id="check_ewallet_button">
                                <div class="form-group">
                                    <button type="button" id ="ewallet_btn" name= "ewallet_btn" value = "Check Availability" onclick="validate_ewallet();" class="btn btn-sm btn-primary ">{lang('check_availability')}</button>
                                    <button type="submit" name="ewallet_submit" id="ewallet_submit" class="btn btn-sm btn-primary "  disabled="">{lang('finish')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $paypal_status == "yes"} 
                <div class="bhoechie-tab-content {if $active_tab_val=='paypal_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="paypal" id="paypal" class="btn btn-sm btn-primary">{lang('next')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $authorize_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='authorize_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="authorize" id="authorize" class="btn btn-sm btn-primary">{lang('next')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $blocktrail_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='blocktrail_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="bitcoin" id="bitcoin" class="btn btn-sm btn-primary">{lang('next')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $blockchain_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='blockchain_tab'}active{/if}">
                    <div class="content">
                        <pre class="alert alert-info">{lang('blockchain_only_in_live')}</pre>
                    </div>
                </div>
            {/if}
            {if $bitgo_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='bitgo_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="bitgo" id="bitgo" class="btn btn-sm btn-primary">{lang('next')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $payeer_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='payeer_tab'}active{/if}">
                    <div class="content">
                        <pre class="alert alert-info">{lang('payeer_only_in_live')}</pre>
                    </div>
                </div>
            {/if}
            {if $sofort_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='sofort_tab'}active{/if}">
                    <div class="content">
                           <pre class="alert alert-info">{lang('sofort_only_in_live')}</pre>
                    </div>
                </div>
            {/if}
            {if $squareup_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='squareup_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="squareup" id="squareup" class="btn btn-sm btn-primary">{lang('next')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            {if $free_joining_status == 'yes'}
                <div class="bhoechie-tab-content {if $active_tab_val=='free_join_tab'}active{/if}">
                    <div class="content">
                        <div class="form form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <button type="submit" name="free_purchase" id="free_purchase" class="btn btn-sm btn-primary">{lang('finish')}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        {else}
            <div class="bhoechie-tab-content active">
                <div class="content">
                    <div class="form form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <button type="submit" name="free_purchase" id="free_purchase" class="btn btn-sm btn-primary">{lang('finish')}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</div> 
{form_close()}
<div id="epin_row" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td></td>
                <td>
                    <input class="form-control epin_input" type="text" name="epin[]" onblur="loadEpinBlur();" autocompleautote="Off"/>                                                    
                </td>
                <td> 
                    <input class="form-control" type="text" name="pin_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="remaining_amount[]" readonly/>
                </td>
                <td>
                    <input class="form-control" type="text" name="balance_amount[]" readonly/>
                </td>
            </tr>
        </tbody>
    </table>
</div>