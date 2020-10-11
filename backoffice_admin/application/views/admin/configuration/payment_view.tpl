{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg1">{lang('sure_you_want_to_edit_this_news_there_is_no_undo')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="error_msg1">{lang('you_must_enter_rank_name')}</span>
    <span id="error_msg2">{lang('you_must_enter_referal_count')}</span>
    <span id="error_msg3">{lang('digits_only')}</span>
    <span id="error_msg4">{lang('Digit limit is five')}</span>
    <span id="error_msg5">{lang('digit_greater_than_0')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}


<div class="panel panel-default">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('payment')}</span></legend>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('Payment_method')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="pin_status" value="{$MODULE_STATUS['pin_status']}"}
                {assign var="ewallet_status" value="{$MODULE_STATUS['ewallet_status']}"}
                {assign var="i" value=0}
                {foreach from=$payment_methods item=v}
                    {if $MODULE_STATUS['opencart_status'] == "yes" && $v.payment_type=="Free Joining" ||  $v.payment_type eq 'Payment Gateway'}
                        {continue}
                    {/if}
                    {if DEMO_STATUS == 'yes' && $MODULE_STATUS['basic_demo_status'] == 'yes' && $is_preset_demo && $v.id == 1}
                    {else}
                    <tr {if $v.id == 3 && $MODULE_STATUS['ewallet_status']=='no'}style="display:none;"{/if}{if $v.id == 2 && $pin_status=='no'}style="display:none;"{/if}>
                        <td>
                            {if $v.id == 3 && $MODULE_STATUS['ewallet_status']=='no'}
                                {$i}
                            {elseif $v.id == 2 && $pin_status=='no'}
                                {$i}
                            {else}
                                {assign var="i" value=$i+1}{$i}
                            {/if}
                        </td>
                        <td>
                            {if $v.payment_type eq 'Payment Gateway'}
                                {lang('payment_gateway')}
                            {elseif $v.payment_type eq 'E-pin'}
                                {lang('epin')}
                            {elseif $v.payment_type eq 'E-wallet'}
                                {lang('ewallet')}
                            {elseif $v.payment_type eq 'Free Joining'}
                                {lang('free_joining')}
                                {elseif $v.payment_type eq 'Bank Transfer'}
                                {lang('bank_transfer')}
                            {/if}
                        </td>
                        <td class="payment_width_td">
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" {if $v.status=="yes"} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="set_module_status" id="set_ewallet_status" class="switch-input payment_status">
                                    <i></i>
                                </label>
                            </div>
                            {if $v.id==1 && $v.status=="yes"}
                                <a href="{$BASE_URL}admin/configuration/payment_gateway_configuration" class="Payment_payment_view_1"> <i class="fa fa-cog"></i></a>
                            {/if}
                        </td>
                    </tr>
                    {/if}
                {/foreach}
            </tbody>
        </table>
        </div>
        </div>
    </div>
    
    {form_open('', 'name="payment_status_form" id="payment_status_form" method="post"')}
<div class="panel panel-default">
<div class="panel-body">

<legend>
    <span class="fieldset-legend">{lang('payeer_conf')}</span>
    
</legend>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('Payment_method')}</th>
                    <th>{lang('payment_logo')}</th>
                   <th>{lang('status')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="i" value=0}
                {foreach from=$card_status item=v}
                    <tr>
                        <td>{assign var="i" value=$i+1}{$i}</td>
                        <td>{if $v.gateway_name=="Bitcoin"}{lang('blocktrail')}{else}{$v.gateway_name}{/if}</td>
                        <td>
                            <img class="img_width_payout" src="{$BASE_URL}/public_html/images/logos/{$v.logo}" />
                        </td>
                        <td>{if $v.payout_status=='yes'}<span class="text-success">{lang('enabled')}</span>{else}<span class="text-danger">{lang('disabled')}</span>{/if}</td>
                       
                        <td>
                            {$link=""}
                            {if $v.id==1}
                                {$link="paypal_config"}
                            {elseif $v.id==4}
                                {$link="authorize_config"}
                            {elseif $v.id==5}
                                {$link="bitcoin_configuration"}
                            {elseif $v.id==6}
                                {$link="blockchain_configuration"}
                            {elseif $v.id==7}
                                {$link="bitgo_configuration"}
                            {elseif $v.id==8}
                                {$link="payeer_configuration"}
                            {elseif $v.id==9}
                                {$link="sofort_configuration"}
                            {elseif $v.id==10}
                                {$link="squareup_configuration"}
                            {/if}
                            <a href="{$link}" class=""> <i class="fa fa-cog fa-1-5-x"></i></a>
                            <input type="hidden" id="number" name="number" value="{$i}">
                            <input type="hidden" id="id" name="id{$i}" value="{$v.id}">
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
        </div>
         <button type="submit" id="update" value="update" name="update" class="btn btn-sm btn-primary update_config">Update</button>
        </div>
    </div>
{form_close()}  
       
{form_open('', 'name="payment_status_form" id="payment_status_form" method="post"')}
<div class="panel panel-default">
<div class="panel-body">

<legend>
    <span class="fieldset-legend">{lang('stripe_conf')}</span>
    
</legend>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('Payment_method')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="i" value=0}
                
                    <tr>
                        <td>{assign var="i" value=$i+1}{$i}</td>
                        <td>{lang('stripe')}</td>
                        
                        <td>
                            
                            <a href="{$BASE_URL}admin/stripe_configuration" class=""> <i class="fa fa-cog fa-1-5-x"></i></a>
                            
                        </td>
                    </tr>
                
            </tbody>
        </table>
        </div>
         <button type="submit" id="update" value="update" name="update" class="btn btn-sm btn-primary update_config">Update</button>
        </div>
    </div>
{form_close()}
{/block}
