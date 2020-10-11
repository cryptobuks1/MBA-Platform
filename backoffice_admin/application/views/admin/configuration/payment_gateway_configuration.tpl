{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="load_msg">{lang('loading')}</span>
    <span id="error_msg3">{lang('digits_only')}</span>
</div>



{form_open('', 'name="payment_status_form" id="payment_status_form" method="post"')}
<div class="panel panel-default">
<div class="panel-body">
<a href="{$BASE_URL}admin/configuration/payment_view" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        {lang('back')}
    </a>
<legend>
    <span class="fieldset-legend">{lang('payment_gateway_configuration')}</span>
    
</legend>
<div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('Payment_method')}</th>
                    <th>{lang('payment_logo')}</th>
                    <th>{lang('status')}</th>
                    <th>{lang('mode')}</th>
                    <th width="10%">{lang('sort_order')}</th>
                    <th>{lang('registration')}</th>
                    {if $MODULE_STATUS['repurchase_status'] == 'yes'}
                        <th>{lang('repurchase')}</th>
                    {/if}
                    {if $MODULE_STATUS['product_validity'] == 'yes'}
                        <th>{lang('membership_renewal')}</th>
                    {/if}
                    {if $MODULE_STATUS['package_upgrade'] == 'yes'}
                        <th>{lang('upgradation')}</th>
                    {/if}
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
                        <td>{if $v.status=='yes'}<span class="text-success">{lang('enabled')}</span>{else}<span class="text-danger">{lang('disabled')}</span>{/if}</td>
                        <td>
                            {if $v.mode=='live'}{lang('live')}{else}{lang('test')}{/if}
                        </td>
                        <td><input class="form-control sort_order" type="text" id="sort_order{$i}" name="sort_order{$i}" value="{$v.sort_order}"><span id="errmsg{$i}" style="color:red;"></span></td>
                        <td class="payment_width_td">
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" {if $v.registration} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="registration" class="switch-input payment_avilable">
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        {if $MODULE_STATUS['repurchase_status'] == 'yes'}
                            <td  class="payment_width_td">
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" {if $v.repurchase} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="repurchase" class="switch-input payment_avilable">
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                        {/if}
                        {if $MODULE_STATUS['product_validity'] == 'yes'}
                            <td class="payment_width_td" >
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" {if $v.membership_renewal} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="membership_renewal" class="switch-input payment_avilable">
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                        {/if}
                        {if $MODULE_STATUS['package_upgrade'] == 'yes'}
                            <td class="payment_width_td">
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" {if $v.upgradation} checked {/if} data-id="{$v.id}" data-status="{$v.status}" name="upgradation" class="switch-input payment_avilable">
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                        {/if}
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


<div class="panel panel-default table-responsive">
<div class="panel-body">
<legend><span class="fieldset-legend">{lang('set_module_status')}</span></legend>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('status')}</th>
                    <th> {lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="count" value="1"}
                <tr>
                    <td>{$count}</td> 
                    <td>{lang('google_auth_status')}</td>
                    <td  class="payment_width_td">
                        <div class="form-group-button">
                            <label class="i-switch bg-primary">
                                <input type="checkbox" {if $MODULE_STATUS['google_auth_status'] == "yes"} checked {/if} data-status="{$MODULE_STATUS['google_auth_status']}" name="set_module_status" class="switch-input google_auth_status" id="set_google_auth_status">
                                <i></i>
                            </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
        <p class="text-danger">{lang('note')} : {lang('available_only_for_bitcoin_payment')}</p>

{/block}